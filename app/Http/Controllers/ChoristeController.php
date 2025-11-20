<?php

namespace App\Http\Controllers;

use App\Models\Choriste;
use App\Models\Groupe_vocal;
use Illuminate\Http\Request;
use App\Traits\LogsVisits;

class ChoristeController extends Controller
{
    use LogsVisits;

    public function create()
    {
        $this->logVisit('create_choriste'); // <-- Ici
        $choristes = Choriste::all();
        $groupes_vocaux = Groupe_vocal::all();
        return view('choristes.create', compact('choristes','groupes_vocaux'));
    }

    public function store(Request $request)
    {
        $this->logVisit('store_choriste'); // <-- Ici si tu veux enregistrer le store aussi

        $request->validate([
            'nom' => 'required|string|max:255',
            'groupe_id' => 'required|exists:groupes_vocaux,id',
        ]);

        Choriste::create([
            'nom' => $request->nom,
            'groupe_id' => $request->groupe_id,
        ]);

        return redirect()->route('choristes.create')->with('success', 'Choriste ajouté avec succès.');
    }

    public function show($id)
    {
        $this->logVisit('show_choriste'); // <-- Ici
        $choristes = Choriste::findOrFail($id);
        return view('choristes.show', compact('choristes'));
    }

    public function index()
    {
        $this->logVisit('index_choriste'); // <-- Ici
        $choristes = Choriste::all();
        return view('choristes.index', compact('choristes'));
    }

    public function rechercher(Request $request)
    {
        $this->logVisit('rechercher_choriste'); // <-- Ici
        $choristes = Choriste::query();

        if ($request->has('search') && !empty($request->search)) {
            $choristes = $choristes->where('nom', 'like', '%' . $request->search . '%')
                                   ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $choristes = $choristes->paginate(10);
        return view('choristes.rechercher', compact('choristes'));
    }

    public function edit($id)
    {
        $this->logVisit('edit_choriste'); // <-- Ici
        $choristes = Choriste::findOrFail($id);
        $groupes = Groupe_vocal::all();
        return view('choristes.edit', compact('choristes', 'groupes'));
    }

    public function update(Request $request, $id)
    {
        $this->logVisit('update_choriste'); // <-- Ici
        $choristes = Choriste::findOrFail($id);
        $choristes->update($request->all());
        return redirect()->route('choristes.index');
    }

    public function copy($id)
    {
        $this->logVisit('copy_choriste'); // <-- Ici
        $choristes = Choriste::findOrFail($id);
        $newClient = $choristes->replicate();
        $newClient->save();

        return redirect()->route('choristes.index')->with('success', 'Choriste copié avec succès');
    }

    public function paste($id)
    {
        $this->logVisit('paste_choriste'); // <-- Ici
        $choristes = Choriste::findOrFail($id);
        $newChoriste = $choristes->replicate();
        $newChoriste->save();

        return redirect()->route('choristes.index')->with('success', 'Choriste collé avec succès');
    }

    public function destroy($id)
    {
        $this->logVisit('destroy_choriste');

        $choriste = Choriste::findOrFail($id);
        $choriste->delete();

        return redirect()->route('choristes.index')->with('success', 'Choriste supprimé avec succès.');
    }
}
