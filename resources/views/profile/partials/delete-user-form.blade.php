<section class="space-y-6">
  <header class="flex items-start">
    <div class="bg-red-100 p-3 rounded-xl mr-4 text-red-600 hidden sm:block">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
        </path>
      </svg>
    </div>
    <div>
      <h2 class="text-xl font-bold text-red-600">
        {{ __('Hapus Akun') }}
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        {{ __('Setelah akun anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin anda simpan.') }}
      </p>
    </div>
  </header>

  <div class="flex justify-end">
    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
      class="rounded-xl px-6 py-2.5 bg-red-600 hover:bg-red-700 shadow-lg shadow-red-500/30">
      {{ __('Hapus Akun Saya') }}
    </x-danger-button>
  </div>

  <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
      @csrf
      @method('delete')

      <div class="flex items-center justify-center mb-4 text-red-600">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
          </path>
        </svg>
      </div>

      <h2 class="text-xl font-bold text-gray-900 text-center">
        {{ __('Apakah anda yakin ingin menghapus akun?') }}
      </h2>

      <p class="mt-2 text-sm text-gray-600 text-center">
        {{ __('Setelah dihapus, semua data akan hilang permanen. Silakan masukkan password anda untuk mengonfirmasi bahwa anda ingin menghapus akun secara permanen.') }}
      </p>

      <div class="mt-6">
        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4 mx-auto rounded-xl py-3"
          placeholder="{{ __('Password Anda') }}" />

        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-center" />
      </div>

      <div class="mt-6 flex justify-center gap-3">
        <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-4 py-2">
          {{ __('Batal') }}
        </x-secondary-button>

        <x-danger-button class="rounded-xl px-4 py-2">
          {{ __('Ya, Hapus Akun') }}
        </x-danger-button>
      </div>
    </form>
  </x-modal>
</section>
