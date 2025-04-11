<?php

namespace App\Http\Controllers;

use App\Models\Stagiaires;
use App\Models\Certificat;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StagiaireController extends Controller
{
    // Tableau de bord stagiaire
    public function dashboard()
    {
        $stagiaire = Stagiaires::where('email', Auth::user()->email)->firstOrFail();
        $formations = $stagiaire->groupes->load('formation')->pluck('formation');

        return view('stagiaire.dashboard', compact('stagiaire', 'formations'));
    }

    // Liste des certificats
    public function certificats()
    {
        $stagiaire = Stagiaires::where('email', Auth::user()->email)->firstOrFail();
        $certificats = $stagiaire->certificats()->with('formation')->get();

        return view('stagiaire.certificats.index', compact('certificats'));
    }

    // Téléchargement d'un certificat
    public function downloadCertificat(Certificat $certificat)
    {
        if ($certificat->stagiaire->email !== Auth::user()->email) {
            abort(403);
        }

        return response()->download(storage_path('app/'.$certificat->url));
    }
}
