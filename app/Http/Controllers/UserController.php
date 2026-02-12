<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsVisits;

class UserController extends Controller
{
    use LogsVisits;

    // ==============================
    // PROFIL UTILISATEUR
    // ==============================
    public function profile()
    {
        $this->logVisit('user_profile');
        return view('profile');
    }

    public function profil()
    {
        $this->logVisit('user_profil');
        return view('profil');
    }

    public function update(Request $request)
    {
        $this->logVisit('user_update');
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Vérifier l'ancien mot de passe
        if ($request->filled('old-password')) {
            if (!Hash::check($request->input('old-password'), $user->password)) {
                return redirect()->back()->with('error', 'Ancien mot de passe incorrect.');
            }
            if ($request->input('new-password') === $request->input('new-password_confirmation')) {
                $user->password = bcrypt($request->input('new-password'));
            } else {
                return redirect()->back()->with('error', 'Les mots de passe ne coïncident pas.');
            }
        }

        // Changer le mot de passe si nécessaire
        if ($request->input('new-password') && $request->input('new-password_confirmation')) {
            if ($request->input('new-password') === $request->input('new-password_confirmation')) {
                $user->password = bcrypt($request->input('new-password'));
            } else {
                return redirect()->back()->with('error', 'Les mots de passe ne coïncident pas.');
            }
        }

        // Mettre à jour la photo si un fichier est envoyé
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        // Mettre à jour les autres champs
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save(); // <-- save corrigé, plus de problème

        return redirect()->route('profil')->with('status', 'Profil édité avec succès');
    }

    public function updatePhoto(Request $request)
    {
        $this->logVisit('user_update_photo');

        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('avatars', 'public');
        $user->photo = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'photo_url' => asset('storage/'.$user->photo)
        ]);
    }

    // ==============================
    // MISE À JOUR DU PROFIL
    // ==============================
   public function updateProfil(Request $request)
{
    $this->logVisit('user_update_profil');

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $validated = $request->validate([
        'name' => ['required','string','max:255','regex:/^[\pL\s\-]+$/u'],
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|confirmed|min:8',
    ], [
        'name.required' => 'Le nom est obligatoire.',
        'name.regex' => 'Le nom ne doit contenir que des lettres, espaces ou tirets.',
        'email.required' => 'L’email est obligatoire.',
        'email.email' => 'Le format de l’email est invalide.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save(); // plus de soulignement rouge dans VS

    return back()->with('success', '✅ Profil mis à jour avec succès.');
}

    // ==============================
    // LISTE DES UTILISATEURS
    // ==============================
    public function index()
    {
        $this->logVisit('user_index');
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // ==============================
    // FORMULAIRE CRÉATION UTILISATEUR
    // ==============================
    public function createUser()
    {
        $this->logVisit('user_create_form');
        return view('users.create');
    }

    // ==============================
    // STOCKAGE UTILISATEUR CRÉÉ PAR ADMIN
    // ==============================
    public function store(Request $request)
    {
        $this->logVisit('user_store');

        try {
            $validated = $request->validate([
                'name' => ['required','string','max:255','regex:/^[\pL\s\-]+$/u'],
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|confirmed|min:8',
                'role' => 'required|in:user,admin',
                'niveau_admin' => 'nullable|integer|min:1|max:' . (Auth::check() ? Auth::user()->niveau_admin : 3),
            ], [
                'name.required' => 'Le nom est obligatoire.',
                'name.regex' => 'Le nom ne doit contenir que des lettres, espaces ou tirets.',
                'email.required' => 'L’email est obligatoire.',
                'email.email' => 'Le format de l’email est invalide.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.confirmed' => 'Les mots de passe ne correspondent pas.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'role.required' => 'Le rôle est obligatoire.',
            ]);

            // Gestion du premier admin automatique niveau 3
            if ($validated['role'] === 'admin') {
                $adminCount = User::where('role', 'admin')->count();
                if ($adminCount === 0) {
                    $validated['niveau_admin'] = 3;
                } else {
                    $validated['niveau_admin'] = $validated['niveau_admin'] ?? 1;
                }
            } else {
                $validated['niveau_admin'] = null;
            }

            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
                'niveau_admin' => $validated['niveau_admin'],
            ]);

            return redirect()->route('users.index')->with('success', '✅ Utilisateur créé avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Une erreur est survenue : ' . $e->getMessage());
        }
    }

    // ==============================
    // FORMULAIRE ÉDITION UTILISATEUR
    // ==============================
    public function edit($id)
    {
        $this->logVisit('user_edit');
        $user = User::findOrFail($id);

        if ($user->role === 'admin' && Auth::user()->niveau_admin <= $user->niveau_admin) {
            return redirect()->route('users.index')->with('error', '❌ Vous ne pouvez pas modifier cet utilisateur.');
        }

        return view('users.edit', compact('user'));
    }

    // ==============================
    // MISE À JOUR UTILISATEUR
    // ==============================
    public function updateUser(Request $request, $id)
    {
        $this->logVisit('user_update_admin');
        $user = User::findOrFail($id);

        if ($user->role === 'admin' && Auth::user()->niveau_admin <= $user->niveau_admin) {
            return redirect()->route('users.index')->with('error', '❌ Vous ne pouvez pas modifier cet utilisateur.');
        }

        try {
            $validated = $request->validate([
                'name' => ['required','string','max:255','regex:/^[\pL\s\-]+$/u'],
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|in:user,admin',
                'niveau_admin' => 'nullable|integer|min:1|max:' . Auth::user()->niveau_admin,
                'password' => 'nullable|string|confirmed|min:8',
            ], [
                'name.required' => 'Le nom est obligatoire.',
                'name.regex' => 'Le nom ne doit contenir que des lettres, espaces ou tirets.',
                'email.required' => 'L’email est obligatoire.',
                'email.email' => 'Le format de l’email est invalide.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'Les mots de passe ne correspondent pas.',
                'role.required' => 'Le rôle est obligatoire.',
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->niveau_admin = $validated['role'] === 'admin' ? ($validated['niveau_admin'] ?? 1) : null;

            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', '✅ Utilisateur mis à jour avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Une erreur est survenue : ' . $e->getMessage());
        }
    }

    // ==============================
    // SUPPRESSION UTILISATEUR
    // ==============================
    public function destroy($id)
    {
        $this->logVisit('user_destroy');
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', '❌ Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->role === 'admin' && Auth::user()->niveau_admin <= $user->niveau_admin) {
            return redirect()->route('users.index')->with('error', '❌ Vous ne pouvez pas supprimer cet utilisateur.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
