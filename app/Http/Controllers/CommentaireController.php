<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    // Affiche tous les commentaires principaux et leurs réponses
    public function index()
    {
        $commentaires = Commentaire::whereNull('parent_id')
            ->with('reponses.user') // on charge aussi les auteurs des réponses
            ->with('user')          // on charge l'auteur du commentaire
            ->latest()
            ->paginate(10);

        return view('commentaires.index', compact('commentaires'));
    }

    // Ajout d’un commentaire ou d’une réponse
    public function store(Request $request)
    {
        $request->validate([
            'pseudo'    => 'required|string|max:50',
            'contenu'   => 'required|string|max:500',
            'parent_id' => 'nullable|exists:commentaires,id',
        ]);

        Commentaire::create([
            'user_id'   => Auth::id(),
            'pseudo'    => $request->pseudo,
            'contenu'   => $request->contenu,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('commentaires.index')->with('success', 'Commentaire ajouté avec succès.');
    }

    // Suppression d’un commentaire ou d’une réponse
    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);

        // Vérification de l’admin niveau 3
        if (!Auth::check() || Auth::user()->role !== 'admin' || Auth::user()->niveau_admin != 3) {
            abort(403, 'Accès refusé : vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }

        $commentaire->delete();

        return redirect()->route('commentaires.index')->with('success', 'Commentaire supprimé avec succès.');
    }
}
