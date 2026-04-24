<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;

class ProfilEtudiantController extends Controller
{
    public function showForm()
    {
        return view('profil.etudiant');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $etudiant = Etudiant::where('email', $credentials['email'])->first();

        if ($etudiant && $credentials['password'] === $etudiant->password) {
            session(['etudiant_id' => $etudiant->id]);
            return redirect()->route('dashboard.etudiant');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        return redirect()->route('dashboard.admin')->with('success', 'Étudiant supprimé avec succès.');
    }
}
