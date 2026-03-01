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

    /* ==============================
     | PROFIL UTILISATEUR CONNECTÉ
     ============================== */

    public function profil()
    {
        $this->logVisit('user_profil');
        return view('profil');
    }

    public function profile()
    {
        $this->logVisit('user_profile');
        return view('profile');
    }

    public function update(Request $request)
    {
        $this->logVisit('user_profile_update');

        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $request->file('photo')
                ->store('users/avatars', 'public');
        }

        $user->save();

        return redirect()->route('profil')
            ->with('success', 'Profil mis à jour avec succès');
    }

    /* ==============================
     | GESTION DES UTILISATEURS
     ============================== */

    public function index()
    {
        $this->logVisit('users_index');
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $this->logVisit('users_edit');

        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }


     public function updatePhoto(Request $request)
    {
         $this->logVisit('user_photo_update');
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->photo = $request->file('photo')
            ->store('users/avatars', 'public');

        $user->save();

        return response()->json([
            'success' => true,
            'photo_url' => asset('storage/'.$user->photo)
        ]);
    }

     public function updateUser(Request $request, $id)
    {
        $this->logVisit('user_update');
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'role'          => 'nullable|string',
            'niveau_admin'  => 'nullable|integer',
            'password'      => 'nullable|confirmed|min:8',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if (isset($validated['role'])) {
            $user->role = $validated['role'];
        }

        if (isset($validated['niveau_admin'])) {
            $user->niveau_admin = $validated['niveau_admin'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy($id)
    {
        $this->logVisit('users_delete');

        $user = User::findOrFail($id);

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}
