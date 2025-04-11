<?php

namespace App\Http\Controllers;

use App\Models\Certificat;
use Illuminate\Http\Request;

class CertificatController extends Controller
{
    // Vérification d'un certificat via QR code
    public function verify($id)
    {
        $certificat = Certificat::with(['stagiaire', 'formation'])->findOrFail($id);

        return view('certificat.verify', compact('certificat'));
    }

    // Marquer un certificat comme vérifié
    public function markAsVerified(Certificat $certificat)
    {
        $certificat->update(['verified' => true]);

        return back()->with('success', 'Certificat marqué comme vérifié!');
    }
}
