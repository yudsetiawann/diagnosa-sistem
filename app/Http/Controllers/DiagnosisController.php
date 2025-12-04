<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visit;
use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function searchView(Request $request)
    {
        $results = collect(); // Default koleksi kosong
        $searchTerm = $request->input('symptom_name');

        if ($searchTerm) {
            // 1. Cari gejala yang namanya mirip
            $symptoms = Symptom::where('name', 'like', '%' . $searchTerm . '%')->get();

            if ($symptoms->isNotEmpty()) {
                $symptomIds = $symptoms->pluck('id');

                // 2. Cari penyakit yang MEMILIKI salah satu dari gejala tersebut
                $results = Disease::whereHas('symptoms', function ($q) use ($symptomIds) {
                    $q->whereIn('symptom_id', $symptomIds);
                })
                    ->with('symptoms') // Eager load relasi symptoms
                    ->get();
            }
        }

        return view('diagnosis.search', compact('results', 'searchTerm'));
    }

    /**
     * Tampilan untuk fitur diagnosa cepat (Pilih Gejala -> Tampil Penyakit)
     */
    /**
     * Tampilan Diagnosa Cepat
     */
    public function quickView()
    {
        $symptoms = Symptom::orderBy('name')->get();
        // Ambil list pasien untuk dropdown (User yang punya profil patient)
        $patients = User::has('patient')->orderBy('name')->get();

        return view('diagnosis.quick', [
            'symptoms' => $symptoms,
            'patients' => $patients, // Kirim data pasien ke view
            'results' => collect(),
            'selectedSymptoms' => []
        ]);
    }

    /**
     * Proses Diagnosa (Hanya menampilkan hasil, belum simpan)
     */
    public function quickDiagnose(Request $request)
    {
        $selectedSymptomIds = $request->input('symptoms', []);

        if (empty($selectedSymptomIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu gejala.');
        }

        // Cari penyakit yang cocok dengan SEMUA gejala
        $results = Disease::whereHas('symptoms', function ($q) use ($selectedSymptomIds) {
            $q->whereIn('symptom_id', $selectedSymptomIds);
        }, '=', count($selectedSymptomIds))
            ->with('symptoms')
            ->get();

        $symptoms = Symptom::orderBy('name')->get();
        $patients = User::has('patient')->orderBy('name')->get(); // Load pasien lagi

        return view('diagnosis.quick', [
            'symptoms' => $symptoms,
            'patients' => $patients,
            'results' => $results,
            'selectedSymptoms' => $selectedSymptomIds
        ]);
    }

    /**
     * BARU: Simpan Hasil Diagnosa ke Database
     */
    public function saveDiagnosis(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'disease_id' => 'required|exists:diseases,id',
            'symptoms_list' => 'nullable|string', // Gejala dikirim sebagai string dipisah koma
        ]);

        Visit::create([
            'user_id' => $request->user_id,
            'disease_id' => $request->disease_id,
            'symptoms_snapshot' => $request->symptoms_list,
            'notes' => 'Diagnosa otomatis sistem.',
        ]);

        return redirect()->route('diagnosis.quick-view')->with('success', 'Rekam medis berhasil disimpan!');
    }

    /**
     * BARU: Menampilkan detail penyakit untuk umum (Pasien/Admin)
     */
    public function showDisease(Disease $disease)
    {
        // Load relasi symptoms agar bisa ditampilkan
        $disease->load('symptoms');

        return view('diagnosis.show', compact('disease'));
    }
}
