<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;

class EtudiantController extends Controller
{
    // عرض الفورم ديال تسجيل الدخول
    public function showForm()
    {
        return view('profil.etudiant');
    }

    // معالجة تسجيل الدخول
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

    // تسجيل الخروج
    public function logout()
    {
        session()->forget('etudiant_id');
        return redirect()->route('profil.etudiant');
    }
}
