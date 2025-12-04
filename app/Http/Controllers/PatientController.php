<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Ambil User yang punya profil pasien
        $query = User::query()->has('patient')->with('patient');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('patient', function ($q) use ($request) {
                      $q->where('phone', 'like', '%' . $request->search . '%')
                        ->orWhere('address', 'like', '%' . $request->search . '%');
                  });
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();
        return view('patients.index', compact('users'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        // 2. Buat USER terlebih dahulu (Induk)
        // Kita generate email random karena form tidak meminta email
        $user = User::create([
            'name' => $validated['name'],
            'email' => 'patient_' . time() . '_' . Str::random(5) . '@system.local',
            'password' => bcrypt('password123'), // Default password
        ]);

        // 3. Buat PATIENT yang terhubung ke User tersebut
        Patient::create([
            'user_id' => $user->id, // INI KUNCINYA
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('patients.index')->with('success', 'Pasien berhasil ditambah.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        // 1. Update nama di tabel USERS
        $patient->user->update(['name' => $validated['name']]);

        // 2. Update data medis di tabel PATIENTS
        $patient->update([
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        // Hapus User-nya, maka Patient akan ikut terhapus (Cascade)
        $patient->user->delete();

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
