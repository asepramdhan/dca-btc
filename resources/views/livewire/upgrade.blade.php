<div x-data="{
    isPaying: false,
    init() {
        $wire.$on('snap-token-received', ({ token }) => {
            if (!token) {
                console.error('❌ Token tidak diterima');
                return;
            }

            if (this.isPaying) {
                console.log('⚠️ Masih dalam proses pembayaran...');
                return;
            }

            this.isPaying = true;

            snap.pay(token, {
                onSuccess: (result) => {
                    console.log('✅ Success', result);
                    this.isPaying = false;

                    // Kirim ke Livewire
                    $wire.handlePayment(result);
                },
                onPending: (result) => {
                    console.log('🕒 Pending', result);
                    this.isPaying = false;

                    // Kirim ke Livewire
                    $wire.handlePayment(result);
                  },
                  onError: (result) => {
                    console.error('❌ Error', result);
                    this.isPaying = false;
                    
                    // Kirim ke Livewire
                    $wire.handlePayment(result);
                  },
                  onClose: () => {
                    console.log('❌ Popup ditutup oleh user');
                    this.isPaying = false;
                },
            });
        });
    }
}" x-init="init">

  <div class="mb-6 w-full flex justify-center">
    <x-alert icon="lucide.alert-triangle" class="alert-warning lg:h-15">
      <strong>Agar pembayaran berhasil, jangan tutup popup sebelum pembayaran selesai, jika terjadi kendala silahkan hubungi admin, melalui chat disini : / melalui whatsapp : 085-159-630-221</strong>
    </x-alert>
  </div>

  <h2 class="text-xl font-bold text-center text-gray-700 mb-6">Pilih Paket Premium</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4 my-4">

    @if ($satuBulan == null)
    @elseif ($satuBulan->is_active)
    <!-- Langganan 1 Bulan -->
    <x-card shadow separator class="border-2 border-slate-100 lg:transform lg:transition lg:duration-300 lg:ease-in-out 
         lg:hover:scale-105 lg:hover:-translate-y-1 lg:hover:shadow-md">
      <x-slot:title>
        <div class="flex justify-between items-center w-full">
          {{ Str::title($satuBulan->name) }}
          <x-button icon="lucide.star" class="btn-circle btn-ghost hover:bg-transparent hover:shadow-none hover:border-transparent" />
        </div>
      </x-slot:title>

      <div class="space-y-2 text-sm text-gray-600">
        <p>🔓 Akses penuh semua fitur</p>
        <p>🚫 Tanpa iklan</p>
        <p>📈 Analitik lanjutan</p>
      </div>

      <div class="mt-4 flex justify-between items-center">
        <div>
          <div class="text-lg font-bold text-gray-800">Rp{{ number_format($satuBulan->price, 0, ',', '.') }}</div>
          <div class="text-sm text-gray-500">per bulan</div>
        </div>
        <x-button label="Upgrade" class="btn-primary" wire:click="pay({{ $satuBulan->id }})" spinner />
      </div>
    </x-card>
    @endif

    @if ($duaBulan == null)
    @elseif ($duaBulan->is_active)
    <!-- Langganan 2 Bulan -->
    <x-card shadow separator class="border-2 border-indigo-200 lg:transform lg:transition lg:duration-300 lg:ease-in-out 
         lg:hover:scale-105 lg:hover:-translate-y-1 lg:hover:shadow-lg lg:hover:border-indigo-400 lg:hover:bg-indigo-50">
      <x-slot:title>
        <div class="flex justify-between items-center w-full">
          {{ Str::title($duaBulan->name) }}
          <x-button icon="lucide.badge-check" class="btn-circle btn-ghost hover:bg-transparent hover:shadow-none hover:border-transparent" />
        </div>
      </x-slot:title>

      <div class="space-y-2 text-sm text-gray-600">
        <p>🔓 Akses penuh semua fitur</p>
        <p>🚫 Tanpa iklan</p>
        <p>🎁 Hemat Rp1.000</p>
      </div>

      <div class="mt-4 flex justify-between items-center">
        <div>
          <div class="text-lg font-bold text-gray-800">Rp{{ number_format($duaBulan->price, 0, ',', '.') }}</div>
          <div class="text-sm text-gray-500">untuk 2 bulan</div>
        </div>
        <x-button label="Upgrade" class="btn-primary" wire:click="pay({{ $duaBulan->id }})" spinner />
      </div>
    </x-card>
    @endif

    @if ($satuTahun == null)
    @elseif ($satuTahun->is_active)
    <!-- Langganan 1 Tahun -->
    <div class="group w-full">
      <x-card shadow separator class="w-full border-2 border-yellow-400 lg:transform lg:transition lg:duration-300 lg:ease-in-out 
           lg:hover:scale-105 lg:hover:-translate-y-1 lg:hover:shadow-2xl lg:hover:bg-yellow-50 lg:hover:border-yellow-500">
        <x-slot:title>
          <div class="flex justify-between items-center w-full">
            {{ Str::title($satuTahun->name) }}
            <x-button icon="lucide.crown" class="btn-circle btn-ghost text-yellow-500 lg:transition-transform lg:duration-500 lg:group-hover:rotate-6 hover:bg-transparent hover:shadow-none hover:border-transparent" />
          </div>
        </x-slot:title>

        <div class="space-y-2 text-sm text-gray-600">
          <p>🔓 Akses penuh semua fitur</p>
          <p>🚫 Tanpa iklan</p>
          <p>💸 Hemat hingga Rp61.000</p>
          <p>🎉 Prioritas dukungan</p>
        </div>

        <div class="mt-4 flex justify-between items-center">
          <div>
            <div class="text-lg font-bold text-yellow-600">Rp{{ number_format($satuTahun->price, 0, ',', '.') }}</div>
            <div class="text-sm text-gray-500">untuk 1 tahun</div>
          </div>
          <x-button label="Upgrade" class="btn-warning" wire:click="pay({{ $satuTahun->id }})" spinner />
        </div>
      </x-card>
    </div>
    @endif

  </div>

  <div class="text-center mt-8 mb-4">
    <p class="text-sm text-gray-500 mb-2">
      Belum ingin upgrade sekarang? Kamu bisa kembali dan lanjutkan aktivitas seperti biasa.
    </p>
    <x-button label="Kembali ke Dashboard" link="/auth/dashboard" class="btn-outline btn-sm" />
  </div>
</div>
