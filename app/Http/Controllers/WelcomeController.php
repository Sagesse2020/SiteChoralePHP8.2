<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;

class WelcomeController extends Controller
{
    public function index()
    {
        // On récupère tous les commentaires avec leur auteur et leurs réponses
        $commentaires = Commentaire::with(['user', 'reponses.user'])
            ->latest()
            ->paginate(10);

        // On envoie les données à la vue welcome
        return view('welcome', compact('commentaires'));
    }
}
