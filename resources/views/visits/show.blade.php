<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Rekam Medis #{{ $visit->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Header Laporan -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Laporan Medis</h3>
                        <p class="text-sm text-gray-500">{{ $visit->created_at->translatedFormat('l, d F Y - H:i') }} WIB</p>
                    </div>
                    <div class="text-right">
                        <span class="block text-xs text-gray-500 uppercase">Status</span>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Selesai
                        </span>
                    </div>
                </div>

                <!-- Info Pasien -->
                <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h4 class="text-sm font-bold text-gray-500 uppercase mb-2">Data Pasien</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block text-gray-500">Nama Lengkap:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $visit->patient->name }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500">Usia:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $visit->patient->patient->age ?? '-' }} Tahun
                            </span>
                        </div>
                        <div>
                            <span class="block text-gray-500">Gender:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $visit->patient->patient->gender ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-gray-500">Telepon:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $visit->patient->patient->phone ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Hasil Diagnosa -->
                <div class="mb-6">
                    <h4 class="text-sm font-bold text-gray-500 uppercase mb-2 border-b pb-1">Hasil Diagnosa</h4>

                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm">Penyakit Terdeteksi:</span>
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                            {{ $visit->disease->name ?? 'Tidak Diketahui' }}
                        </span>
                        <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm italic">
                            {{ $visit->disease->description ?? '-' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <span class="block text-gray-500 text-sm mb-1">Gejala yang dilaporkan:</span>
                        <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 rounded text-gray-700 dark:text-gray-300">
                            {{ $visit->symptoms_snapshot ?? 'Tidak ada data gejala.' }}
                        </div>
                    </div>

                    <div>
                        <span class="block text-gray-500 text-sm mb-1">Catatan Tambahan:</span>
                        <p class="text-gray-900 dark:text-gray-100">
                            {{ $visit->notes }}
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                    <a href="{{ route('visits.index') }}" class="text-gray-600 hover:text-gray-900 underline">
                        &larr; Kembali ke Daftar
                    </a>

                    <button onclick="window.print()" class="bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition">
                        Cetak / Simpan PDF
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
