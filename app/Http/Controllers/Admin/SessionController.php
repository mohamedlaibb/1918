<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Formation;
use App\Models\Groupe;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Affiche la liste des sessions pour une formation
     */
    public function index(Formation $formation)
    {
        $sessions = $formation->sessions()->with('groupe')->get();
        return view('admin.sessions.index', compact('formation', 'sessions'));
    }

    /**
     * Affiche le formulaire de création d'une session
     */
    public function create(Formation $formation)
    {
        $groupes = Groupe::where('formation_id', $formation->id)->get();
        return view('admin.sessions.create', compact('formation', 'groupes'));
    }

    /**
     * Enregistre une nouvelle session
     */
    public function store(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'nbr_session' => 'required|integer|min:1',
            'groupe_id' => 'required|exists:groupes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'required|string|max:255',
        ]);

        $session = $formation->sessions()->create($validated);

        return redirect()->route('admin.formations.sessions.show', [$formation, $session])
            ->with('success', 'Session créée avec succès!');
    }

    /**
     * Affiche les détails d'une session
     */
    public function show(Formation $formation, Session $session)
    {
        $session->load('groupe.stagiaires');
        return view('admin.sessions.show', compact('formation', 'session'));
    }

    /**
     * Affiche le formulaire d'édition d'une session
     */
    public function edit(Formation $formation, Session $session)
    {
        $groupes = Groupe::where('formation_id', $formation->id)->get();
        return view('admin.sessions.edit', compact('formation', 'session', 'groupes'));
    }

    /**
     * Met à jour une session existante
     */
    public function update(Request $request, Formation $formation, Session $session)
    {
        $validated = $request->validate([
            'nbr_session' => 'required|integer|min:1',
            'groupe_id' => 'required|exists:groupes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'required|string|max:255',
        ]);

        $session->update($validated);

        return redirect()->route('admin.formations.sessions.show', [$formation, $session])
            ->with('success', 'Session mise à jour avec succès!');
    }

    /**
     * Supprime une session
     */
    public function destroy(Formation $formation, Session $session)
    {
        $session->delete();
        return redirect()->route('admin.formations.sessions.index', $formation)
            ->with('success', 'Session supprimée avec succès!');
    }

    /**
     * Génère la fiche de présence pour une session
     */
    public function generatePresenceSheet(Formation $formation, Session $session)
    {
        $session->load('groupe.stagiaires');

        $pdf = \PDF::loadView('admin.sessions.presence_sheet', [
            'formation' => $formation,
            'session' => $session
        ]);

        return $pdf->download("presence_session_{$session->id}.pdf");
    }
}
