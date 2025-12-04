<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    /**
     * Tampilkan daftar gejala, dengan pencarian.
     * (Tetap sama)
     */
    public function index(Request $request)
    {
        $query = Symptom::query();

        // Logika Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $symptoms = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('symptoms.index', compact('symptoms'));
    }

    /**
     * FUNGSI BARU: Menampilkan halaman 'create.blade.php'
     */
    public function create()
    {
        return view('symptoms.create');
    }

    /**
     * Simpan gejala baru.
     * (Tetap sama)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:symptoms',
            'description' => 'nullable|string',
        ]);

        Symptom::create($validated);

        return redirect()->route('symptoms.index')->with('success', 'Gejala berhasil ditambah.');
    }

    /**
     * FUNGSI BARU: Menampilkan halaman 'edit.blade.php' dengan data gejala
     */
    public function edit(Symptom $symptom)
    {
        return view('symptoms.edit', compact('symptom'));
    }

    /**
     * Perbarui data gejala.
     * (TetP sama)
     */
    public function update(Request $request, Symptom $symptom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:symptoms,name,' . $symptom->id,
            'description' => 'nullable|string',
        ]);

        $symptom->update($validated);

        return redirect()->route('symptoms.index')->with('success', 'Data gejala berhasil diperbarui.');
    }

    /**
     * Hapus data gejala.
     * (Tetap sama)
     */
    public function destroy(Symptom $symptom)
    {
        $symptom->delete();
        return redirect()->route('symptoms.index')->with('success', 'Data gejala berhasil dihapus.');
    }
}
