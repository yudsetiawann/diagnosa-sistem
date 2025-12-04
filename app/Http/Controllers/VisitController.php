<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Tampilkan daftar seluruh riwayat kunjungan (Rekam Medis).
     */
    public function index(Request $request)
    {
        // Mulai query
        $query = Visit::with(['patient', 'disease'])->latest();

        // LOGIKA PRIVASI:
        // Jika user BUKAN admin, paksa query hanya menampilkan data miliknya sendiri
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        // (Fitur search hanya relevan buat admin, tapi tidak apa dibiarkan)
        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $visits = $query->paginate(10)->withQueryString();

        return view('visits.index', compact('visits'));
    }

    /**
     * Tampilkan detail lengkap satu kunjungan.
     */
    public function show(Visit $visit)
    {
        // Proteksi: Jika bukan admin DAN bukan pemilik data -> Tolak
        if (auth()->user()->role !== 'admin' && $visit->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak melihat rekam medis ini.');
        }

        return view('visits.show', compact('visit'));
    }

    /**
     * Hapus riwayat (jika salah input)
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}
