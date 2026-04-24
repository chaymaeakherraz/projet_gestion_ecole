<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class ProfilAdminController extends Controller
{
    public function showForm()
    {
        return view('profil.admin');
    }

    public function login(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $request->password == $admin->password) {
            session(['admin_id' => $admin->id]);
            return redirect()->route('dashboard.admin');
        }

        return back()->with('error', 'Email ou mot de passe incorrect');
    }

    public function edit()
    {
        $admin = Admin::find(session('admin_id'));
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Admin::find(session('admin_id'));

        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $admin->nom = $request->nom;
        $admin->email = $request->email;
        $admin->save();

        return redirect()->route('dashboard.admin', ['section' => 'profil'])->with('success', 'Profil mis à jour avec succès.');
    }
}
