<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;

class AbsenceController extends Controller
{
    // عرض لائحة الغيابات
    public function index()
    {
        $absences = Absence::all();
        return view('absences.index', compact('absences'));
    }

    // فورم الإضافة (اختياري)
    public function create()
    {
        return view('absences.create');
    }

    // حفظ الغياب الجديد
    public function store(Request $request)
    {
        $request->validate([
            'etudiant_nom' => 'required|string|max:255',
            'date' => 'required|date',
            'motif' => 'nullable|string|max:255',
        ]);

        Absence::create($request->all());

        return redirect()->back()->with('success', 'Absence enregistrée avec succès.');
    }

    // ✅ Afficher formulaire modification
    public function edit($id)
    {
        $absence = Absence::findOrFail($id);
        return view('absences.edit', compact('absence'));
    }

    // ✅ Modifier une absence
    public function update(Request $request, $id)
    {
        $request->validate([
            'etudiant_nom' => 'required|string',
            'date' => 'required|date',
            'motif' => 'nullable|string'
        ]);

        $absence = Absence::findOrFail($id);
        $absence->update($request->all());

        return redirect()->route('dashboard.professeur')->with('success', 'Absence modifiée avec succès.');
    }

    // ✅ Supprimer une absence
    public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->route('dashboard.professeur')->with('success', 'Absence supprimée.');
    }
}
