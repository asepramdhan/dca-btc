<?php

use function Laravel\Folio\name;

name('home');

?>

<x-app-layout :title="__('WEB APP Untuk meyimpan data keuangan, dan membantu kamu nabung Bitcoin tanpa stres.')">
  <div class="-mt-5">
    <section class="min-h-screen bg-gradient-to-b from-base-100 to-base-200 flex flex-col items-center justify-center text-center px-6 py-12 space-y-8">
      <!-- Judul & Subjudul -->
      <h1 class="text-4xl md:text-6xl font-bold text-primary tracking-tight">
        Nabung Bitcoin Tanpa Stres
      </h1>
      <p class="text-lg text-gray-600 max-w-xl">
        Otomatiskan pembelian Bitcoin kamu harian atau mingguan pakai strategi <strong>Dollar Cost Averaging (DCA)</strong>. Mudah, aman, dan cocok untuk pemula.
      </p>

      <!-- CTA -->
      <div class="space-x-4">
        @guest
        <x-button label="Coba Gratis" class="btn-primary" icon="lucide.rocket" link="/guest/register" />
        <x-button label="Masuk" class="btn-ghost" icon="lucide.user-circle-2" link="/guest/login" />
        @else
        <x-button label="Dashboard" class="btn-primary" icon="lucide.layout-dashboard" link="/auth/dashboard" />
        @endguest
      </div>

      <!-- Gambar Hero -->
      <img src="/images/bitcoin-illustration.svg" alt="Bitcoin Illustration" class="w-64 md:w-80 mt-10" />
    </section>

    <!-- Fitur Utama -->
    <section class="bg-base-200 py-16 px-6 text-center space-y-12">
      <h2 class="text-3xl font-semibold text-primary">Kenapa Pakai DCA-BTC?</h2>
      <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <div>
          <h3 class="text-xl font-bold text-secondary">Otomatis & Konsisten</h3>
          <p class="text-gray-500 mt-2">Beli Bitcoin otomatis setiap hari atau minggu tanpa perlu mikir market naik-turun.</p>
        </div>
        <div>
          <h3 class="text-xl font-bold text-secondary">Cocok untuk Pemula</h3>
          <p class="text-gray-500 mt-2">Tanpa perlu analisa chart, cukup atur budget harian dan biarkan sistem bekerja.</p>
        </div>
        <div>
          <h3 class="text-xl font-bold text-secondary">Pantau Performa</h3>
          <p class="text-gray-500 mt-2">Lihat pertumbuhan portofolio kamu dari waktu ke waktu lewat grafik yang rapi.</p>
        </div>
      </div>
    </section>

    <!-- Simulasi Chart (Placeholder) -->
    <section class="bg-base-200 py-16 px-6 text-center space-y-10">
      <h2 class="text-3xl font-semibold text-primary">Simulasi Hasil Investasi DCA</h2>
      <p class="text-gray-500 max-w-2xl mx-auto">
        Coba lihat hasilnya jika kamu rutin nabung Rp100.000 per bulan selama 2 tahun.
      </p>

      <!-- Dummy chart (ganti dengan Livewire chart jika tersedia) -->
      <div class="max-w-4xl mx-auto">
        <livewire:simulation-chart />
      </div>
    </section>

    @guest
    <!-- Tambahkan ajakan untuk bergabung dan tombol action di bawah -->
    <section class="bg-base-200 py-16 px-6 text-center space-y-8">
      <h2 class="text-3xl font-semibold text-primary">Tunggu Apa Lagi?</h2>
      <p class="text-gray-500 max-w-2xl mx-auto">
        Gabung sekarang dan nikmati kemudahan nabung Bitcoin tanpa stres.
      </p>
      <div class="space-x-4">
        <x-button label="Coba Gratis" class="btn-primary" icon="lucide.rocket" link="/guest/register" />
      </div>
    </section>
    @endguest

    <!-- Footer -->
    <footer class="bg-base-200 py-8 px-6 text-center text-sm text-gray-500 border-t">
      <div class="max-w-4xl mx-auto">
        <p class="mb-2">
          <strong class="text-primary underline"><i>DISCLAIMER</i></strong> : Website ini bukanlah platform trading. Web ini hanya membantu kamu nabung Bitcoin tanpa stres. dengan mencatatkan pembelian dan penjualan Bitcoin kamu di berbagai exchange, seperti Indodax, Pintu, Tokocrypto, dan sebagainya.
        </p>
        <p class="mb-6">
          Didalam web ini kamu bisa melihat pertumbuhan portofolio kamu dari waktu ke waktu lewat grafik yang rapi, dengan harga bitcoin yang realtime. dan kamu juga bisa mencatat keuangan kamu seperti Dana Darurat, Dana Harian dan Jumlah Investasi.
        </p>
        <p>&copy; 2022-{{ now()->year }} DCA-BTC. Semua hak dilindungi.</p>
        <div class="flex justify-center space-x-4 mt-2">
          <a href="https://www.tiktok.com/@dca_bitcoin" target="_blank" class="hover:text-primary">Tiktok</a>
          @admin
          <a href="/admin/chat" target="_blank" class="hover:text-primary">Kontak</a>
          @else
          <a href="/auth/user/chat" target="_blank" class="hover:text-primary">Kontak</a>
          @endadmin
          <a href="###" class="hover:text-primary">Privasi</a>
        </div>
      </div>
    </footer>

  </div>
</x-app-layout>
