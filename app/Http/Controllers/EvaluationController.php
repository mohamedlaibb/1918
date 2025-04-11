<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Formation;
use App\Models\Stagiaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    // Affichage du formulaire d'évaluation
    public function create(Formation $formation)
    {
        $stagiaire = Stagiaires::where('email', Auth::user()->email)->firstOrFail();

        // Vérifier que le stagiaire est bien dans cette formation
        if (!$stagiaire->groupes->pluck('formation_id')->contains($formation->id)) {
            abort(403);
        }

        return view('stagiaire.evaluations.create', compact('formation'));
    }

    // Enregistrement de l'évaluation
    public function store(Request $request, Formation $formation)
    {
        $stagiaire = Stagiaires::where('email', Auth::user()->email)->firstOrFail();

        $validated = $request->validate([
            'reponses' => 'required|json',
        ]);

        Evaluation::create([
            'stagiaire_id' => $stagiaire->id,
            'formation_id' => $formation->id,
            'reponses' => $validated['reponses'],
        ]);

        return redirect()->route('stagiaire.dashboard')
            ->with('success', 'Évaluation enregistrée avec succès!');
    }
}
