<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    /**
     * Tampilkan daftar penyakit.
     */
    public function index(Request $request)
    {
        $query = Disease::query()->withCount('symptoms');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $diseases = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('diseases.index', compact('diseases'));
    }

    /**
     * BARU: Tampilkan form tambah penyakit.
     */
    public function create()
    {
        $symptoms = Symptom::orderBy('name')->get();
        return view('diseases.create', compact('symptoms'));
    }

    /**
     * Simpan penyakit baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:diseases',
            'description' => 'nullable|string',
            'symptoms' => 'nullable|array',
            'symptoms.*' => 'exists:symptoms,id'
        ]);

        $disease = Disease::create($validated);
        $disease->symptoms()->sync($request->input('symptoms', []));

        return redirect()->route('diseases.index')->with('success', 'Penyakit berhasil ditambah.');
    }

    /**
     * BARU: Tampilkan form edit penyakit.
     */
    public function edit(Disease $disease)
    {
        $symptoms = Symptom::orderBy('name')->get();
        // Load relasi gejala yang sudah dimiliki penyakit ini
        $disease->load('symptoms');
        return view('diseases.edit', compact('disease', 'symptoms'));
    }

    /**
     * Perbarui data penyakit.
     */
    public function update(Request $request, Disease $disease)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:diseases,name,' . $disease->id,
            'description' => 'nullable|string',
            'symptoms' => 'nullable|array',
            'symptoms.*' => 'exists:symptoms,id'
        ]);

        $disease->update($validated);
        $disease->symptoms()->sync($request->input('symptoms', []));

        return redirect()->route('diseases.index')->with('success', 'Data penyakit berhasil diperbarui.');
    }

    /**
     * Hapus data penyakit.
     */
    public function destroy(Disease $disease)
    {
        $disease->delete();
        return redirect()->route('diseases.index')->with('success', 'Data penyakit berhasil dihapus.');
    }
}
