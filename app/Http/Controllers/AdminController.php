<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\Event;
use App\Models\Evenement;
use App\Models\Certificat;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ✅ Affiche le formulaire de connexion admin
    public function showForm()
    {
        return view('profil.admin');
    }

    // ✅ Traitement de la connexion
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            session(['admin_id' => $admin->id]);
            return redirect()->route('dashboard.admin');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    // ✅ Redirige vers le profil admin
    public function toProfil()
    {
        return view('profil.admin');
    }

    // ✅ Affichage du tableau de bord admin
    public function dashboard()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login.admin');
        }

        $admin = Admin::find(session('admin_id'));
        $etudiants = Etudiant::paginate(10);
        $professeurs = Professeur::paginate(10);
        $evenements = Event::paginate(10); // ou Evenement si tu utilises ce model
        $certificats = Certificat::with('etudiant')->paginate(10);

        return view('dashboard.admin', compact('admin', 'etudiants', 'professeurs', 'evenements', 'certificats'));
    }

    // ✅ Déconnexion
    public function logout()
    {
        session()->forget('admin_id');
        return redirect()->route('login.admin');
    }

    // ✅ Changer le statut d’un certificat
    public function changerStatutCertificat($id, $statut)
    {
        $certificat = Certificat::findOrFail($id);
        $certificat->statut = $statut;
        $certificat->save();

        return back()->with('success', 'Statut mis à jour.');
    }
}
