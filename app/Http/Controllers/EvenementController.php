<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\LogsVisits;

class EvenementController extends Controller
{
    use LogsVisits;

    public function create()
    {
        $this->logVisit('evenement_create');
        $evenements = Evenement::all();
        return view('evenements.create', compact('evenements'));
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Evenement::create($validated);
        return redirect()->route('evenements.index')->with('success', 'Événement enregistré avec succès !');
    }

    public function index()
    {
        $this->logVisit('evenement_index');
        $evenements = Evenement::latest()->paginate(6);
        return view('evenements.index', compact('evenements'));
    }

    public function evenement()
    {
        $this->logVisit('evenement_page');
        $evenements = Evenement::all();
        return view('evenements', compact('evenements'));
    }

    public function rechercher(Request $request)
    {
        $this->logVisit('evenement_rechercher');
        $evenements = Evenement::query();

        if ($request->has('search') && !empty($request->search)) {
            $evenements = $evenements->where('libelle', 'like', '%' . $request->search . '%');
        }

        $evenements = $evenements->paginate(10);
        return view('evenements.rechercher', compact('evenements'));
    }

    public function show($id)
    {
        $this->logVisit('evenement_show');
        $evenement = Evenement::findOrFail($id);
        return view('evenements.show', compact('evenement'));
    }

    public function showAlbums()
    {
        $this->logVisit('evenement_show_albums');
        $evenements = Evenement::with('galeries')->orderBy('date')->get();
        return view('albums.index', compact('evenements'));
    }

    public function futur()
    {
        $this->logVisit('evenement_futur');
        $evenements = Evenement::whereDate('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();
        return view('evenements.futur', compact('evenements'));
    }

    public function inscription($id)
    {
        $this->logVisit('evenement_inscription');
        $evenement = Evenement::findOrFail($id);
        return redirect()->route('evenements.index')
            ->with('success', "Inscription confirmée pour l'événement : {$evenement->titre}");
    }

     public function edit($id)
  {
    $evenement = Evenement::findOrFail($id);

    // Convertir la date en objet Carbon
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
