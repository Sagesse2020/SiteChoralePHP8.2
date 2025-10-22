<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Galerie;
use App\Models\GalerieImage; // Nouveau modèle pour les images multiples
use Illuminate\Http\Request;
use App\Traits\LogsVisits;
use Illuminate\Support\Facades\Storage;

class GalerieController extends Controller
{
    use LogsVisits;

    public function create()
    {
        $this->logVisit('galerie_create');
        $evenements = Evenement::all();
        $galeries = Galerie::all();
        return view('galeries.create', compact('galeries','evenements'));
    }

    public function store(Request $request)
    {
        $this->logVisit('galerie_store');
        $request->validate([
            'titre' => 'required|string|max:255',
            'evenement_id' => 'required|exists:evenements,id',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Créer la galerie
        $galerie = Galerie::create([
            'titre' => $request->titre,
            'evenement_id' => $request->evenement_id
        ]);

        // Ajouter toutes les images
        if($request->hasFile('images')){
            foreach($request->file('images') as $imageFile){
                $path = $imageFile->store('galeries', 'public');
                $galerie->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('galeries.index')->with('success', 'Galerie créée avec succès !');
    }

    public function index()
    {
        $this->logVisit('galerie_index');
        // Charger les galeries avec leurs images pour l’aperçu
        $galeries = Galerie::with('images', 'evenement')->latest()->paginate(6);
        return view('galeries.index', compact('galeries'));
    }

    public function show(Galerie $galerie)
    {
        $this->logVisit('galerie_show');
        $galerie->load('images', 'evenement');
        return view('galeries.show', compact('galerie'));
    }

    public function rechercher(Request $request)
    {
        $this->logVisit('galerie_rechercher');
        $galeries = Galerie::query();

        if ($request->has('search') && !empty($request->search)) {
            $galeries = $galeries->where('titre', 'like', '%' . $request->search . '%');
        }

        $galeries = $galeries->paginate(10);
        return view('galeries.rechercher', compact('galeries'));
    }

    public function edit($id)
    {
        $galerie = Galerie::findOrFail($id);
        $evenements = Evenement::all();
        return view('galeries.edit', compact('galerie', 'evenements'));
    }

    public function update(Request $request, Galerie $galerie)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'evenement_id' => 'required|exists:evenements,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $galerie->titre = $request->titre;
        $galerie->evenement_id = $request->evenement_id;

        if ($request->hasFile('images')) {
            // Supprimer toutes les anciennes images si nécessaire
            foreach ($galerie->images as $img) {
                if ($img->image && Storage::exists($img->image)) {
                    Storage::delete($img->image);
                }
                $img->delete();
            }

            // Stocker les nouvelles images
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('galeries', 'public');
                $galerie->images()->create(['image' => $path]);
            }
        }

        $galerie->save();

        return redirect()->route('galeries.index')->with('success', 'Galerie mise à jour avec succès !');
    }

    public function destroy(Galerie $galerie)
    {
        foreach ($galerie->images as $img) {
            if ($img->image && Storage::exists($img->image)) {
                Storage::delete($img->image);
            }
        }

        $galerie->delete();

        return redirect()->route('galeries.index')->with('success', 'Galerie supprimée avec succès.');
    }
}
