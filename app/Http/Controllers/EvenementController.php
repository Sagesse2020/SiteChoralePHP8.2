<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsVisits;
use Illuminate\Support\Str;

class EvenementController extends Controller
{
    use LogsVisits;

    // Affiche tous les événements + FullCalendar
    public function index()
    {
        $this->logVisit('evenement_index');

        // Pour FullCalendar
        $evenementsCalendar = Evenement::all()->map(function($e){
            return [
                'title' => $e->titre,
                'start' => $e->date,
                'url' => route('evenements.show', $e->id),
            ];
        });

        // Pour la grille avec pagination
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

        // Détection de conflit de date
        if (Evenement::where('date', $validated['date'])->exists()) {
            return redirect()->back()->with('error', 'Un événement existe déjà à cette date.');
        }

        // Upload image dans dossier "evenements"
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('evenements', 'public');
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

        // Détection de conflit sauf pour l'événement courant
        if (Evenement::where('date', $validated['date'])->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Un événement existe déjà à cette date.');
        }

        // Gestion image
        if ($request->hasFile('image')) {
            // Supprimer ancienne image si elle existe
            if ($evenement->image && Storage::disk('public')->exists($evenement->image)) {
                Storage::disk('public')->delete($evenement->image);
            }
            $evenement->image = $request->file('image')->store('evenements', 'public');
        }

        // Mise à jour
        $evenement->titre = $validated['titre'];
        $evenement->description = $validated['description'];
        $evenement->date = $validated['date'];
        $evenement->lieu = $validated['lieu'];
        $evenement->type = $validated['type'];
        $evenement->save();

        return redirect()->route('evenements.index')->with('success', 'Événement mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $evenement = Evenement::findOrFail($id);

        // Supprimer image si elle existe
        if ($evenement->image && Storage::disk('public')->exists($evenement->image)) {
            Storage::disk('public')->delete($evenement->image);
        }

        $evenement->delete();

        return redirect()->route('evenements.index')->with('success', 'Événement supprimé avec succès !');
    }
}
