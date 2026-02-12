<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\LogsVisits;

class AuthController extends Controller
{
    use LogsVisits;

    // ==============================
    // FORMULAIRES
    // ==============================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ==============================
    // LOGIN
    // ==============================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Veuillez entrer votre adresse email.',
            'email.email' => 'L’adresse email n’est pas valide.',
            'password.required' => 'Veuillez entrer votre mot de passe.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => "Aucun compte trouvé avec cette adresse email."
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => "Le mot de passe est incorrect."
            ])->withInput();
        }

        Auth::login($user, $request->has('remember'));
        $request->session()->regenerate();

        DB::table('logins_temp')->insert([
            'user_id' => $user->id,
            'logged_in_at' => now(),
        ]);

        return $user->role === 'admin'
            ? redirect()->route('admin')->with('success', 'Bienvenue, ' . $user->name . ' !')
            : redirect()->route('home')->with('success', 'Bienvenue, ' . $user->name . ' !');
    }

    // ==============================
    // REGISTER
    // ==============================
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255','regex:/^[\pL\s\-]+$/u'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.regex' => 'Le nom ne peut contenir que des lettres, espaces ou tirets.',
            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
        ]);

        // ==============================
        // LOGIQUE PREMIER ADMIN
        // ==============================
        $isFirstAdmin = User::where('role', 'admin')->count() === 0;
        $role = $isFirstAdmin ? 'admin' : 'user';
        $niveau = $isFirstAdmin ? 3 : null;

        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $role,
            'niveau_admin' => $niveau,
        ]);

        Auth::login($user);

        return $role === 'admin'
            ? redirect()->route('admin')->with('success', 'Compte administrateur créé avec succès !')
            : redirect()->route('home')->with('success', 'Votre compte a été créé avec succès !');
    }

    // ==============================
    // CREATION PAR ADMIN
    // ==============================
    public function createUser()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->logVisit('user_store');

        try {
            $validated = $request->validate([
                'name' => ['required','string','max:255','regex:/^[\pL\s\-]+$/u'],
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|confirmed|min:8',
                'role' => 'required|in:user,admin',
                'niveau_admin' => 'nullable|integer|min:1|max:' . (Auth::user()->niveau_admin ?? 3),
            ], [
                'name.required' => 'Le nom est obligatoire.',
                'name.regex' => 'Le nom ne peut contenir que des lettres, espaces ou tirets.',
                'email.required' => 'L’email est obligatoire.',
                'email.email' => 'Le format de l’email est invalide.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'Les mots de passe ne correspondent pas.',
                'role.required' => 'Le rôle est obligatoire.',
            ]);

            // Gestion du premier admin automatique niveau 3
            $isFirstAdmin = User::where('role', 'admin')->count() === 0;
            if ($validated['role'] === 'admin' && $isFirstAdmin) {
                $validated['niveau_admin'] = 3;
            }

            $niveau = $validated['role'] === 'admin' ? ($validated['niveau_admin'] ?? 1) : null;

            /** @var \App\Models\User $user */
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
                'niveau_admin' => $niveau,
            ]);

            return redirect()->route('users.index')->with('success', '✅ Utilisateur créé avec succès !');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', '⚠️ Certaines informations sont invalides. Vérifiez les champs en rouge.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Une erreur interne est survenue : ' . $e->getMessage())
                ->withInput();
        }
    }

    // ==============================
    // LOGOUT
    // ==============================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Vous avez été déconnecté.');
    }
}
