<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\LogsVisits;

class PublicationController extends Controller
{
    use LogsVisits;

    public function index()
    {
        $this->logVisit('publication_index');
       // Remplace le get() par paginate
      $publications = Publication::latest()->paginate(6);// 6 par page
        return view('publications.index', compact('publications'));
    }
    public function create()
    {
        $this->logVisit('publication_create');
        return view('publications.create');
    }

    public function store(Request $request)
    {
        $this->logVisit('publication_store');
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_publication' => 'required|date'
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('publications', 'public')
            : 'default.png';

        Publication::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'image' => $imagePath,
            'date_publication' => $request->date_publication,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('publications.index')->with('success', 'Publication ajoutée avec succès !');
    }

    public function rechercher(Request $request)
    {
        $this->logVisit('publication_rechercher');
        $publications = Publication::query();

        if ($request->has('search') && !empty($request->search)) {
            $publications = $publications->where('libelle', 'like', '%' . $request->search . '%');
        }

        $publications = $publications->paginate(10);
        return view('publications.rechercher', compact('publications'));
    }

    public function edit(Publication $publication)
    {
        $this->logVisit('publication_edit');
        return view('publications.edit', compact('publication'));
    }

    public function update(Request $request, Publication $publication)
    {
        $this->logVisit('publication_update');
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['titre','contenu']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('publications', 'public');
        }

        $publication->update($data);
        return redirect()->route('publications.index')
                         ->with('success', 'Publication mise à jour avec succès.');
    }

    public function destroy(Publication $publication)
    {
        $this->logVisit('publication_destroy');
        $publication->delete();
        return redirect()->route('publications.index')
                         ->with('success', 'Publication supprimée avec succès.');
    }
}
