<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificat;
use App\Models\Etudiant;
use Barryvdh\DomPDF\Facade\Pdf; // تأكد أن DomPDF منصب

class CertificatController extends Controller
{
    // الطالب كيصيفط طلب الشهادة
    public function envoyerDemande(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Certificat de scolarité,Certificat de stage,Attestation d\'inscription',
        ]);

        Certificat::create([
            'etudiant_id' => session('etudiant_id'),
            'type' => $request->input('type'),
            'motif' => $request->input('motif'), // message facultatif
        ]);

        return back()->with('success', 'Votre demande a été envoyée avec succès.');
    }

    // المدير كيشوف جميع الطلبات
    public function voirDemandes()
    {
        $demandes = Certificat::with('etudiant')->orderBy('created_at', 'desc')->get();
        return view('admin.certificats.index', compact('demandes'));
    }

    // تغيير حالة الشهادة من طرف المدير
    public function changerStatut($id, $statut)
    {
        if (!in_array($statut, ['accepté', 'refusé'])) {
            return back()->with('error', 'Statut invalide.');
        }

        $certificat = Certificat::findOrFail($id);
        $certificat->update(['statut' => $statut]);

        return back()->with('success', 'Le statut a été mis à jour.');
    }

    // تحميل الشهادة على شكل PDF
    public function telecharger($id)
    {
        $certificat = Certificat::with('etudiant')->findOrFail($id);

        if ($certificat->statut !== 'accepté') {
            return back()->with('error', 'Ce certificat n\'est pas encore accepté.');
        }

        $pdf = Pdf::loadView('pdf.certificat', compact('certificat'));
        return $pdf->download('certificat_' . $certificat->id . '.pdf');
    }
}
