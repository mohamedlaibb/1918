<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Client;
use App\Models\Groupe;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    // Liste des formations
    public function index()
    {
        $formations = Formation::with('client')->latest()->get();
        return view('admin.formations.index', compact('formations'));
    }

    // Affichage du formulaire de création
    public function create()
    {
        $clients = Client::all();
        return view('admin.formations.create', compact('clients'));
    }

    // Enregistrement d'une nouvelle formation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'categorie' => 'required|string',
            'formateur_nom' => 'required|string',
            'duree' => 'required|string',
            'date_d' => 'required|date',
            'client_id' => 'required|exists:clients,client_id',
        ]);

        $formation = Formation::create($validated);

        return redirect()->route('admin.formations.show', $formation)
            ->with('success', 'Formation créée avec succès!');
    }

    // Affichage d'une formation
    public function show(Formation $formation)
    {
        $formation->load('client', 'groupes.stagiaires');
        return view('admin.formations.show', compact('formation'));
    }

    // Édition d'une formation
    public function edit(Formation $formation)
    {
        $clients = Client::all();
        return view('admin.formations.edit', compact('formation', 'clients'));
    }

    // Mise à jour d'une formation
    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'categorie' => 'required|string',
            'formateur_nom' => 'required|string',
            'duree' => 'required|string',
            'date_d' => 'required|date',
            'client_id' => 'required|exists:clients,client_id',
        ]);

        $formation->update($validated);

        return redirect()->route('admin.formations.show', $formation)
            ->with('success', 'Formation mise à jour avec succès!');
    }

    // Suppression d'une formation
    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation supprimée avec succès!');
    }
}
