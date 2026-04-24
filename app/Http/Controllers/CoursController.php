<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cours;

class CoursController extends Controller
{
    // ✅ 1. عرض جميع الكورسات الخاصة بالأستاذ
    public function index()
    {
        $profId = session('professeur_id');
        $cours = Cours::where('professeur_id', $profId)->get();
        return view('cours.index', compact('cours'));
    }

    // ✅ 2. عرض الفورم لإضافة كورس جديد
    public function create()
    {
        return view('cours.create');
    }

    // ✅ 3. تخزين الكورس مع رفع ملف PDF
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'nullable',
            'fichier_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('fichier_pdf')) {
            $path = $request->file('fichier_pdf')->store('cours_pdfs', 'public');
        }

        Cours::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'fichier_pdf' => $path,
            'professeur_id' => session('professeur_id'),
        ]);

        return redirect()->route('dashboard.professeur')->with('success', 'Cours ajouté avec succès');
    }

    // ✅ 4. عرض صفحة التعديل
    public function edit($id)
    {
        $cours = Cours::findOrFail($id);

        if ($cours->professeur_id !== session('professeur_id')) {
            abort(403);
        }

        return view('cours.edit', compact('cours'));
    }

    // ✅ 5. تعديل الكورس
    public function update(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);

        if ($cours->professeur_id !== session('professeur_id')) {
            abort(403);
        }

        $request->validate([
            'titre' => 'required',
            'description' => 'nullable',
            'fichier_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('fichier_pdf')) {
            $path = $request->file('fichier_pdf')->store('cours_pdfs', 'public');
            $cours->fichier_pdf = $path;
        }

        $cours->titre = $request->titre;
        $cours->description = $request->description;
        $cours->save();

        return redirect()->route('dashboard.professeur')->with('success', 'Cours modifié avec succès');
    }

    // ✅ 6. حذف الكورس
    public function destroy($id)
    {
        $cours = Cours::findOrFail($id);

        if ($cours->professeur_id !== session('professeur_id')) {
            abort(403);
        }

        $cours->delete();

        return redirect()->route('dashboard.professeur')->with('success', 'Cours supprimé');
    }
}
