<?php

namespace App\Http\Controllers;

use App\Models\Groupe_vocal;
use Illuminate\Http\Request;
use App\Traits\LogsVisits;

class GroupeController extends Controller
{
    use LogsVisits;

    public function create()
    {
        $this->logVisit('groupe_create');
        return view('groupes_vocaux.create');
    }

    public function store(Request $request)
    {
        $this->logVisit('groupe_store');
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Groupe_vocal::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('groupes_vocaux.store')->with('success', 'Groupe vocal enregistré avec succès.');
    }

    public function index()
    {
        $this->logVisit('groupe_index');
        $groupes_vocaux = Groupe_vocal::all();
        return view('groupes_vocaux.index', compact('groupes_vocaux'));
    }

    public function rechercher(Request $request)
    {
        $this->logVisit('groupe_rechercher');
        $groupes_vocaux = Groupe_vocal::query();

        if ($request->has('search') && !empty($request->search)) {
            $groupes_vocaux = $groupes_vocaux->where('libelle', 'like', '%' . $request->search . '%');
        }

        $groupes_vocaux = $groupes_vocaux->paginate(10);
        return view('groupes_vocaux.rechercher', compact('groupes_vocaux'));
    }
}
