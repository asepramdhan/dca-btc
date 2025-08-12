<?php

use function Laravel\Folio\name;

name('home');

?>

<x-app-layout :title="__('WEB APP Untuk meyimpan data keuangan, dan membantu kamu nabung Bitcoin tanpa stres.')">
  <div class="-mt-5">
    <section class="min-h-screen bg-gradient-to-b from-base-100 to-base-200 flex flex-col items-center justify-center text-center px-6 py-12 space-y-8">
      <h1 class="text-4xl md:text-6xl font-bold text-primary tracking-tight leading-tight">
        Investasi Bitcoin Jadi Mudah,<br class="hidden md:block"> Bebas Stres dengan DCA Otomatis
      </h1>
      <p class="text-lg max-w-2xl text-gray-700 dark:text-gray-200">
        Lupakan kerumitan pasar! Otomatiskan pembelian Bitcoin Anda setiap hari atau minggu dengan strategi Dollar Cost Averaging (DCA) yang terbukti. Ideal untuk pemula, aman, dan pantau pertumbuhan aset Anda secara transparan.
      </p>

      <div class="space-y-4 sm:space-y-0 sm:space-x-4 flex flex-col sm:flex-row items-center justify-center">
        @guest
        <x-button label="Mulai Nabung Bitcoin Sekarang!" class="btn btn-primary btn-lg transform transition-transform duration-300 hover:scale-105" icon="lucide.rocket" link="/guest/register" />
        <x-button label="Sudah Punya Akun? Masuk" class="btn btn-ghost btn-lg text-primary hover:bg-base-300" icon="lucide.user-circle-2" link="/guest/login" />
        @else
        <x-button label="Akses Dashboard Anda" class="btn btn-primary btn-lg" icon="lucide.layout-dashboard" link="/auth/dashboard" />
        @endguest
      </div>

      <img src="/images/bitcoin-illustration.svg" alt="Ilustrasi Investasi Bitcoin" class="w-72 md:w-96 mt-10" />
    </section>

    <section class="bg-base-200 py-16 px-6 text-center space-y-12">
      <h2 class="text-3xl md:text-4xl font-bold text-primary">Mengapa {{ config('app.name') }} Pilihan Tepat untuk Anda?</h2>
      <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">
        <div class="p-6 bg-base-100 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-2xl font-bold text-secondary mb-3 flex items-center justify-center"><i data-lucide="repeat" class="w-7 h-7 mr-2 text-primary"></i>Otomatis & Konsisten</h3>
          <p class="dark:text-gray-300 text-gray-600">Atur jadwal pembelian Bitcoin otomatis (harian/mingguan). Hilangkan emosi, bangun portofolio Anda secara disiplin tanpa perlu memantau pasar setiap saat.</p>
        </div>
        <div class="p-6 bg-base-100 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-2xl font-bold text-secondary mb-3 flex items-center justify-center"><i data-lucide="graduation-cap" class="w-7 h-7 mr-2 text-primary"></i>Ramah Pemula</h3>
          <p class="dark:text-gray-300 text-gray-600">Tidak perlu keahlian teknis atau analisa chart yang rumit. Cukup tentukan budget Anda, dan biarkan sistem kami mengurus sisanya. Belajar investasi Bitcoin jadi lebih mudah.</p>
        </div>
        <div class="p-6 bg-base-100 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-2xl font-bold text-secondary mb-3 flex items-center justify-center"><i data-lucide="trending-up" class="w-7 h-7 mr-2 text-primary"></i>Pantau Pertumbuhan Portofolio</h3>
          <p class="dark:text-gray-300 text-gray-600">Lihat dengan jelas performa investasi Bitcoin Anda melalui grafik intuitif dan data real-time. Semua transaksi tercatat rapi, memudahkan Anda melacak keuntungan dan kerugian.</p>
        </div>
      </div>
    </section>

    <section class="bg-base-100 py-16 px-6 text-center space-y-12">
      <h2 class="text-3xl md:text-4xl font-bold text-primary">Bagaimana {{ config('app.name') }} Membantu Anda?</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10 max-w-6xl mx-auto">
        <div class="flex flex-col items-center">
          <div class="p-4 bg-primary text-primary-content rounded-full mb-4">
            <i data-lucide="dollar-sign" class="w-8 h-8"></i>
          </div>
          <h3 class="text-xl font-semibold text-secondary mb-2">Catat Pembelian & Penjualan</h3>
          <p class="dark:text-gray-300 text-gray-600">Integrasikan pembelian dan penjualan Bitcoin Anda dari berbagai exchange (Indodax, Pintu, Tokocrypto, dll.) dalam satu tempat.</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="p-4 bg-primary text-primary-content rounded-full mb-4">
            <i data-lucide="wallet" class="w-8 h-8"></i>
          </div>
          <h3 class="text-xl font-semibold text-secondary mb-2">Kelola Keuangan Pribadi</h3>
          <p class="dark:text-gray-300 text-gray-600">Selain Bitcoin, catat juga Dana Darurat, Dana Harian, dan jumlah investasi Anda. Dapatkan gambaran lengkap kondisi finansial Anda.</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="p-4 bg-primary text-primary-content rounded-full mb-4">
            <i data-lucide="line-chart" class="w-8 h-8"></i>
          </div>
          <h3 class="text-xl font-semibold text-secondary mb-2">Visualisasi Portofolio Real-time</h3>
          <p class="dark:text-gray-300 text-gray-600">Lihat pertumbuhan investasi Anda dengan harga Bitcoin yang selalu terupdate. Grafik interaktif akan membantu Anda mengambil keputusan lebih baik.</p>
        </div>
      </div>
    </section>

    <section class="bg-base-200 py-16 px-6 text-center space-y-10">
      <h2 class="text-3xl md:text-4xl font-bold text-primary">Lihat Sendiri Potensi Hasil Investasi Anda</h2>
      <p class="dark:text-gray-300 text-gray-600 max-w-2xl mx-auto">
        Simulasikan bagaimana strategi Dollar Cost Averaging (DCA) dapat memberikan keuntungan stabil. Coba lihat hasilnya jika Anda rutin nabung Rp100.000 per bulan selama 2 tahun.
      </p>

      <div class="max-w-4xl mx-auto bg-base-100 p-6 rounded-lg shadow-xl">
        <livewire:simulation-chart />
      </div>
      <p class="text-sm text-gray-500 mt-4">
        *Simulasi ini bersifat ilustratif. Hasil investasi sebenarnya dapat bervariasi.
      </p>
    </section>

    @guest
    <section class="bg-primary text-primary-content py-20 px-6 text-center space-y-8">
      <h2 class="text-3xl md:text-5xl font-extrabold leading-tight">Siap Nabung Bitcoin Tanpa Pusing?</h2>
      <p class="text-xl max-w-3xl mx-auto opacity-90">
        Bergabunglah dengan ribuan pengguna yang sudah merasakan kemudahan investasi Bitcoin dengan strategi DCA. Daftar sekarang dan mulai perjalanan investasi Anda!
      </p>
      <div class="space-x-4">
        <x-button label="Daftar Sekarang, Gratis!" class="btn btn-secondary btn-lg transform transition-transform duration-300 hover:scale-105 shadow-xl" icon="lucide.check-circle" link="/guest/register" />
      </div>
    </section>
    @endguest

    <footer class="bg-base-200 py-8 px-6 text-center text-sm text-gray-500 border-t border-base-300">
      <div class="max-w-4xl mx-auto">
        <p class="mb-4">
          <a href="/disclaimer" wire:navigate class="text-primary hover:underline font-bold text-base">Baca Disclaimer Penuh Kami</a>
        </p>
        <p class="mb-6">
          &copy; 2022-{{ now()->year }} {{ config('app.name') }}. Semua hak dilindungi.
        </p>
        <div class="flex justify-center space-x-4 mt-2">
          <a href="https://www.tiktok.com/@dca_bitcoin" target="_blank" class="hover:text-primary">Tiktok</a>
          @admin
          <a href="/admin/chat" target="_blank" class="hover:text-primary">Kontak</a>
          @else
          <a href="/auth/user/chat" target="_blank" class="hover:text-primary">Kontak</a>
          @endadmin
          <a href="/privacy-policy" wire:navigate class="hover:text-primary">Kebijakan Privasi</a> </div>
      </div>
    </footer>

  </div>
</x-app-layout>
