<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evenement;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EvenementController extends Controller
{
    /**
     * Affiche les événements sur la page publique
     */
    public function indexPublic()
    {
        $evenements = Evenement::latest()->get();
        return view('evenement', compact('evenements'));
    }

    /**
     * Enregistre un nouvel événement depuis le formulaire admin
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('evenements', 'public');
        }

        Evenement::create($data);

        return redirect()->route('dashboard.admin')->with('success', 'Événement ajouté avec succès.');
    }

    /**
     * Affiche le formulaire de modification d’un événement
     */
    public function edit($id)
    {
        $evenement = Evenement::findOrFail($id);
        return view('admin.evenements.edit', compact('evenement'));
    }

    /**
     * Met à jour un événement existant
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'image' => 'nullable|image|max:2048'
        ]);

        $evenement = Evenement::findOrFail($id);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('evenements', 'public');
        }

        $evenement->update($data);

        return redirect()->route('dashboard.admin')->with('success', 'Événement modifié avec succès.');
    }

    /**
     * Supprime un événement existant
     */
    public function destroy($id)
    {
        $evenement = Evenement::findOrFail($id);
        $evenement->delete();

        return redirect()->route('dashboard.admin')->with('success', 'Événement supprimé.');
    }
}
