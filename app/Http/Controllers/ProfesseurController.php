<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesseurController extends Controller
{
    // ✅ Afficher tous les professeurs (optionnel pour admin)
    public function index()
    {
        $professeurs = Professeur::all();
        return view('professeurs.index', compact('professeurs'));
    }

    // ✅ Afficher le formulaire d'ajout
    public function create()
    {
        return view('professeurs.create');
    }

    // ✅ Enregistrer un nouveau professeur
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:professeurs',
            'password' => 'required|string|min:6',
        ]);

        Professeur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard.admin')->with('success', 'Professeur ajouté avec succès.');
    }

    // ✅ Afficher le formulaire d'édition (pour le professeur connecté via session)
    public function edit()
    {
        $prof = Professeur::findOrFail(session('professeur_id'));
        return view('professeurs.edit', ['professeur' => $prof]);

    }

    // ✅ Enregistrer les modifications du professeur connecté
    public function update(Request $request)
    {
        $prof = Professeur::findOrFail(session('professeur_id'));

        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:professeurs,email,' . $prof->id,
            'password' => 'nullable|string|min:6',
        ]);

        $prof->nom = $request->nom;
        $prof->prenom = $request->prenom;
        $prof->email = $request->email;

        if ($request->filled('password')) {
            $prof->password = Hash::make($request->password);
        }

        $prof->save();

        return redirect()->route('dashboard.professeur')->with('success', 'Profil mis à jour avec succès.');
    }

    // ✅ Supprimer un professeur (admin uniquement)
    public function destroy($id)
    {
        $prof = Professeur::findOrFail($id);
        $prof->delete();

        return redirect()->route('dashboard.admin')->with('success', 'Professeur supprimé avec succès.');
    }
}
