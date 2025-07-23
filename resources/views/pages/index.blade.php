<?php

use function Laravel\Folio\name;

name('home');

?>

<x-app-layout>
  <div class="-mt-5">
    <section class="min-h-screen bg-gradient-to-b from-base-100 to-base-200 flex flex-col items-center justify-center text-center px-6 py-12 space-y-8">

      <!-- Logo / Nama -->
      <h1 class="text-4xl md:text-6xl font-bold text-primary tracking-tight">
        DCA-BTC
      </h1>
      <p class="text-lg text-gray-600 max-w-xl">
        Otomatiskan pembelian Bitcoin kamu dengan strategi Dollar Cost Averaging (DCA) secara konsisten dan aman.
      </p>

      <!-- Tombol CTA -->
      <div class="space-x-4">
        @guest
        <x-button label="Mulai Investasi" class="btn-primary" icon="lucide.vault" :link="route('register')" />
        <x-button label="Masuk" class="btn-ghost" icon="lucide.user-circle-2" :link="route('login')" />
        @else
        <x-button label="Dashboard" class="btn-primary" icon="lucide.layout-dashboard" :link="route('dashboard')" />
        @endguest
      </div>

      <!-- Ilustrasi / Gambar -->
      <img src="/images/bitcoin-illustration.svg" alt="Bitcoin Illustration" class="w-62 md:w-86 mt-8" />

    </section>
  </div>
</x-app-layout>
