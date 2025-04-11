<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Certificat;
use App\Models\Stagiaires;
use Spatie\Pdf\Pdf;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Génération de la fiche de présence
    public function generatePresence(Formation $formation)
    {
        $formation->load('groupes.stagiaires');

        $pdf = Pdf::view('admin.documents.presence', compact('formation'))
            ->format('A4')
            ->name('presence-formation-'.$formation->id.'.pdf');

        // Sauvegarde en storage
        Storage::put('documents/presence/'.$formation->id.'.pdf', $pdf->output());

        return $pdf->download();
    }

    // Génération des certificats pour une formation
    public function generateCertificats(Formation $formation)
    {
        $formation->load('groupes.stagiaires');

        foreach ($formation->groupes as $groupe) {
            foreach ($groupe->stagiaires as $stagiaire) {
                $certificat = Certificat::create([
                    'stagiaire_id' => $stagiaire->id,
                    'formation_id' => $formation->id,
                    'verified' => false,
                ]);

                $pdf = Pdf::view('admin.documents.certificat', compact('formation', 'stagiaire', 'certificat'))
                    ->format('A4')
                    ->name('certificat-'.$stagiaire->id.'-'.$formation->id.'.pdf');

                $path = 'certificats/'.$certificat->id.'.pdf';
                Storage::put($path, $pdf->output());

                $certificat->update(['url' => $path]);
            }
        }

        return back()->with('success', 'Certificats générés avec succès!');
    }

    // Liste des documents générés
    public function index()
    {
        $formations = Formation::has('certificats')->withCount('certificats')->get();
        return view('admin.documents.index', compact('formations'));
    }
}
