<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeInscription;
use App\Models\Professeur;
use App\Models\Etudiant;

class DemandeInscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'email' => 'required|email|unique:demandes_inscription',
            'password' => 'required|min:6',
            'type' => 'required|in:professeur,etudiant',
        ]);

        DemandeInscription::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type,
            'statut' => 'en_attente'
        ]);

        return redirect()->back()->with('success', 'Votre demande a été envoyée à l\'administrateur.');
    }

    public function index()
    {
        $demandes = DemandeInscription::where('statut', 'en_attente')->get();
        return view('admin.demandes', compact('demandes'));
    }

    public function changerStatut($id, $statut)
    {
        $demande = DemandeInscription::findOrFail($id);

        if (in_array($statut, ['accepte', 'refuse'])) {
            $demande->statut = $statut;
            $demande->save();

            if ($statut === 'accepte') {
                if ($demande->type === 'professeur') {
                    Professeur::create([
                        'nom' => $demande->nom,
                        'email' => $demande->email,
                        'password' => $demande->password,
                        'specialite' => 'non spécifié'
                    ]);
                } else {
                    Etudiant::create([
                        'nom' => $demande->nom,
                        'email' => $demande->email,
                        'password' => $demande->password,
                        'filiere' => 'non spécifié'
                    ]);
                }
            }
        }

        return redirect()->back()->with('status', 'Statut modifié avec succès.');
    }
}

