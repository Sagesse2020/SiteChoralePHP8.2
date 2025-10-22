<?php

namespace App\Http\Controllers;

use App\Models\Publicite;
use Illuminate\Http\Request;
use App\Traits\LogsVisits;

class PubliciteController extends Controller
{
    use LogsVisits;

    public function index()
    {
        $this->logVisit('publicite_index');
        $publicites = Publicite::latest()->paginate(6);
        return view('publicites.index', compact('publicites'));
    }

    public function create()
    {
        $this->logVisit('publicite_create');
        return view('publicites.create');
    }

    public function store(Request $request)
    {
        $this->logVisit('publicite_store');
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['titre','contenu']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('publicites', 'public');
        }

        Publicite::create($data);
        return redirect()->route('publicites.index')
                         ->with('success', 'Publicité créée avec succès.');
    }

    public function rechercher(Request $request)
    {
        $this->logVisit('publicite_rechercher');
        $publicites = Publicite::query();

        if ($request->has('search') && !empty($request->search)) {
            $publicites = $publicites->where('libelle', 'like', '%' . $request->search . '%');
        }

        $publicites = $publicites->paginate(10);
        return view('publicites.rechercher', compact('publicites'));
    }

    public function edit(Publicite $publicite)
    {
        $this->logVisit('publicite_edit');
        return view('publicites.edit', compact('publicite'));
    }

    public function update(Request $request, Publicite $publicite)
    {
        $this->logVisit('publicite_update');
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['titre','contenu']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('publicites', 'public');
        }

        $publicite->update($data);
        return redirect()->route('publicites.index')
                         ->with('success', 'Publicité mise à jour avec succès.');
    }

    public function destroy(Publicite $publicite)
    {
        $this->logVisit('publicite_destroy');
        $publicite->delete();
        return redirect()->route('publicites.index')
                         ->with('success', 'Publicité supprimée avec succès.');
    }
}
