<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      Riwayat Rekam Medis
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded relative">
          {{ session('success') }}
        </div>
      @endif

      <!-- Search Bar -->
      <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('visits.index') }}" class="flex w-full md:w-1/2">
          <x-text-input name="search" placeholder="Cari nama pasien..." :value="request('search')" class="text-sm w-full" />
          <x-primary-button class="ml-2">Cari</x-primary-button>
        </form>
      </div>

      <!-- Tabel Riwayat -->
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-750">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              @forelse($visits as $visit)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                    {{ $visit->created_at->format('d M Y, H:i') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $visit->patient->name }}
                    <div class="text-xs text-gray-500">{{ $visit->patient->email }}</div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    @if ($visit->disease)
                      <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        {{ $visit->disease->name }}
                      </span>
                    @else
                      <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                        Belum Terdiagnosa
                      </span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('visits.show', $visit) }}"
                      class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>

                    <form action="{{ route('visits.destroy', $visit) }}" method="POST" class="inline"
                      onsubmit="return confirm('Hapus rekam medis ini?');">
                      @csrf @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center p-4 text-gray-500">Belum ada riwayat kunjungan.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="p-4">
          {{ $visits->links() }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
