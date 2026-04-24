<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\Certificat;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $admin = Admin::find(session('admin_id'));

        $etudiants = Etudiant::all();
        $professeurs = Professeur::all();
        $certificats = Certificat::with('etudiant')->latest()->get();

        return view('dashboard.admin', compact('admin', 'etudiants', 'professeurs', 'certificats'));
    }
}
