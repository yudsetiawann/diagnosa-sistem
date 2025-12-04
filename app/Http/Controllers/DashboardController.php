<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Statistik Data
        // Hitung User yang memiliki profil 'patient' (artinya dia adalah pasien)
        $totalPatients = User::has('patient')->count();
        $totalDiseases = Disease::count();
        $totalSymptoms = Symptom::count();

        // 2. Data Statistik Diagnosa (Contoh Data Dummy untuk Grafik)
        // Nanti di Level 2, ini akan diambil dari tabel 'Visits' yang asli
        $chartData = [
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'data'   => [12, 19, 3, 5, 2, 3, 10], // Contoh jumlah pasien per hari
        ];

        return view('dashboard', compact('totalPatients', 'totalDiseases', 'totalSymptoms', 'chartData'));
    }
}
