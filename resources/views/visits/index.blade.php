<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
      <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
        </path>
      </svg>
      Riwayat Rekam Medis
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      @if (session('success'))
        <div
          class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
            </path>
          </svg>
          {{ session('success') }}
        </div>
      @endif

      <!-- Toolbar -->
      <div
        class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('visits.index') }}" class="relative w-full md:w-1/2">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
              </path>
            </svg>
          </div>
          <input type="text" name="search" value="{{ request('search') }}"
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white text-gray-700 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out"
            placeholder="Cari nama pasien...">
        </form>
        <div class="text-sm text-gray-500">
          Total Kunjungan:
          <span class="font-bold text-gray-800">{{ $visits->total() }}</span>
        </div>
      </div>

      <!-- Tabel -->
      <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pasien</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hasil Diagnosa
                </th>
                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($visits as $visit)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                  <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">
                      {{ $visit->created_at->format('d M Y') }}
                    </div>
                    <div class="text-xs text-gray-500">
                      {{ $visit->created_at->format('H:i') }} WIB
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="flex items-center">
                      @if ($visit->patient)
                        <div
                          class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-xs">
                          {{ substr($visit->patient->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                          <div class="text-sm font-medium text-gray-900">{{ $visit->patient->name }}</div>
                          <div class="text-xs text-gray-500">{{ $visit->patient->email }}</div>
                        </div>
                      @else
                        <div
                          class="h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-xs">
                          ?</div>
                        <div class="ml-3">
                          <div class="text-sm font-medium text-red-500 italic">User Terhapus</div>
                          <div class="text-xs text-gray-400">ID: {{ $visit->user_id }}</div>
                        </div>
                      @endif
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    @if ($visit->disease)
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                        {{ $visit->disease->name }}
                      </span>
                    @else
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Belum Terdiagnosa
                      </span>
                    @endif
                  </td>

                  <td class="px-6 py-4 text-right text-sm font-medium">
                    <a href="{{ route('visits.show', $visit) }}"
                      class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1.5 rounded-lg mr-2 transition">
                      Detail
                    </a>

                    <form action="{{ route('visits.destroy', $visit) }}" method="POST" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?');">
                      @csrf @method('DELETE')
                      <button type="submit"
                        class="text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                      <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                      </svg>
                      <span class="text-gray-500 text-sm font-medium">Belum ada riwayat kunjungan yang tercatat.</span>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-4">
        {{ $visits->links() }}
      </div>

    </div>
  </div>
</x-app-layout>
