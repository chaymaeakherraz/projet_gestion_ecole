<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;

class ProfilProfesseurController extends Controller
{
    public function showForm()
    {
        return view('profil.professeur');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $professeur = Professeur::where('email', $credentials['email'])->first();

        if ($professeur && $credentials['password'] === $professeur->password) {
            session(['professeur_id' => $professeur->id]);
            return redirect()->route('dashboard.professeur');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    public function edit()
    {
        $id = session('professeur_id');
        $professeur = Professeur::findOrFail($id);
        return view('professeurs.edit', compact('professeur'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'specialite' => 'nullable|string',
        ]);

        $professeur = Professeur::findOrFail(session('professeur_id'));

        $professeur->nom = $request->nom;
        $professeur->prenom = $request->prenom;
        $professeur->email = $request->email;
        $professeur->specialite = $request->specialite;
        $professeur->save();

        return redirect()->route('dashboard.professeur')->with('success', 'Profil mis à jour avec succès');
    }

    public function destroy($id)
    {
        $professeur = Professeur::findOrFail($id);
        $professeur->delete();

        return redirect()->route('dashboard.admin')->with('success', 'Professeur supprimé avec succès.');
    }
}
