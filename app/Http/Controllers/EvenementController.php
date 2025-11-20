<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\LogsVisits;

class EvenementController extends Controller
{
    use LogsVisits;

    // Affiche tous les événements + FullCalendar
    public function index()
    {
        $this->logVisit('evenement_index');

        // Récupération des événements pour FullCalendar
        $evenementsCalendar = Evenement::all()->map(function($e){
            return [
                'title' => $e->titre,
                'start' => $e->date,
                'url' => route('evenements.show', $e->id),
            ];
        });

        // Récupération des événements pour la grille et pagination
        $evenements = Evenement::latest()->paginate(6);

        return view('evenements.index', compact('evenements', 'evenementsCalendar'));
    }

    public function create()
    {
        $this->logVisit('evenement_create');
        return view('evenements.create');
    }

    public function store(Request $request)
    {
        $this->logVisit('evenement_store');

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'lieu' => 'required|string',
            'type' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        // Détection des conflits
        $conflict = Evenement::where('date', $validated['date'])->exists();
        if ($conflict) {
            return redirect()->back()->with('error', 'Un événement existe déjà à cette date.');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Evenement::create($validated);

        return redirect()->route('evenements.index')->with('success', 'Événement enregistré avec succès !');
    }

    public function show($id)
    {
        $this->logVisit('evenement_show');
        $evenement = Evenement::findOrFail($id);
        return view('evenements.show', compact('evenement'));
    }

    public function edit($id)
    {
        $evenement = Evenement::findOrFail($id);
        $evenement->date = Carbon::parse($evenement->date);
        return view('evenements.edit', compact('evenement'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'lieu' => 'required|string',
            'type' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $evenement = Evenement::findOrFail($id);

        // Détection des conflits sauf pour l'événement en cours
        $conflict = Evenement::where('date', $validated['date'])->where('id', '!=', $id)->exists();
        if ($conflict) {
            return redirect()->back()->with('error', 'Un événement existe déjà à cette date.');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $evenement->update($validated);

        return redirect()->route('evenements.index')->with('success', 'Événement mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $evenement = Evenement::findOrFail($id);
        $evenement->delete();

        return redirect()->route('evenements.index')->with('success', 'Événement supprimé avec succès !');
    }
}
