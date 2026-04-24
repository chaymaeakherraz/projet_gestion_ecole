<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emploi;
use App\Models\Etudiant;
use App\Models\Professeur;

class EmploiController extends Controller
{
    /**
     * Affiche le formulaire + liste des emplois
     */
    public function index()
    {
        $etudiants = Etudiant::all();
        $professeurs = Professeur::all();
        return view('admin.emplois', compact('etudiants', 'professeurs'));
    }

    /**
     * Enregistre un nouvel emploi du temps
     */
    public function store(Request $request)
    {
        $request->validate([
            'jour' => 'required',
            'heure' => 'required',
            'matiere' => 'required',
            'type' => 'required|in:etudiant,professeur',
            'user_id' => 'required|integer',
        ]);

        Emploi::create([
            'jour' => $request->jour,
            'heure' => $request->heure,
            'matiere' => $request->matiere,
            'type' => $request->type,
            'user_id' => $request->user_id,
        ]);

        return back()->with('success', 'Emploi ajouté avec succès');
    }

    /**
     * Supprime un emploi du temps existant
     */
    public function destroy($id)
    {
        $emploi = Emploi::findOrFail($id);
        $emploi->delete();

        return back()->with('success', 'Emploi supprimé avec succès');
    }
}
