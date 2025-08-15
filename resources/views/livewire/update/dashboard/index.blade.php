<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
  <!-- Page Content -->
  <h1 class="text-3xl font-bold text-white mb-6">Selamat Datang Kembali! 👋</h1>

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    <!-- Card 1: Total Aset -->
    <div class="card p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-slate-400 font-medium">Total Nilai Aset</h3>
        <x-icon name="lucide.landmark" class="text-slate-500" />
      </div>
      <p class="text-3xl font-bold text-white">Rp 150.750.000</p>
      <p class="text-sm text-green-500 flex items-center mt-1">
        <x-icon name="lucide.arrow-up" class="w-4 h-4 mr-1" />
        +5.2% (Bulan Ini)
      </p>
    </div>
    <!-- Card 2: Saldo Bitcoin -->
    <div class="card p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-slate-400 font-medium">Portofolio Bitcoin</h3>
        <x-icon name="lucide.bitcoin" class="text-slate-500" />
      </div>
      <p class="text-3xl font-bold text-white">1.25 BTC</p>
      <p class="text-sm text-slate-400 mt-1">
        ~ Rp 120.300.000
      </p>
    </div>
    <!-- Card 3: Laba / Rugi -->
    <div class="card p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-slate-400 font-medium">Total Laba/Rugi</h3>
        <x-icon name="lucide.trending-up" class="text-slate-500" />
      </div>
      <p class="text-3xl font-bold text-green-500">+ Rp 12.500.000</p>
      <p class="text-sm text-slate-400 mt-1">
        Sejak bergabung
      </p>
    </div>
  </div>

  <!-- Chart & Recent Transactions -->
  <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Chart -->
    <div class="xl:col-span-2 card p-6">
      <h3 class="text-xl font-bold text-white mb-4">Perkembangan Portofolio</h3>
      <div class="h-80 bg-slate-800 rounded-lg flex items-center justify-center">
        <p class="text-slate-500">Placeholder untuk Grafik</p>
      </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card p-6">
      <h3 class="text-xl font-bold text-white mb-4">Aktivitas Terkini</h3>
      <div class="space-y-4">
        <!-- Transaction Item 1 -->
        <div class="flex items-center">
          <div class="w-10 h-10 bg-green-500/10 rounded-full flex items-center justify-center mr-4">
            <x-icon name="lucide.arrow-down-left" class="w-5 h-5 text-green-500" />
          </div>
          <div class="flex-1">
            <p class="font-semibold text-white">Beli Bitcoin</p>
            <p class="text-sm text-slate-400">10 Agustus 2024</p>
          </div>
          <p class="font-semibold text-green-500">+0.05 BTC</p>
        </div>
        <!-- Transaction Item 2 -->
        <div class="flex items-center">
          <div class="w-10 h-10 bg-red-500/10 rounded-full flex items-center justify-center mr-4">
            <x-icon name="lucide.arrow-up-right" class="w-5 h-5 text-red-500" />
          </div>
          <div class="flex-1">
            <p class="font-semibold text-white">Jual Bitcoin</p>
            <p class="text-sm text-slate-400">5 Agustus 2024</p>
          </div>
          <p class="font-semibold text-red-500">-0.02 BTC</p>
        </div>
        <!-- Transaction Item 3 -->
        <div class="flex items-center">
          <div class="w-10 h-10 bg-sky-500/10 rounded-full flex items-center justify-center mr-4">
            <x-icon name="lucide.wallet" class="w-5 h-5 text-sky-500" />
          </div>
          <div class="flex-1">
            <p class="font-semibold text-white">Pemasukan Gaji</p>
            <p class="text-sm text-slate-400">1 Agustus 2024</p>
          </div>
          <p class="font-semibold text-white">+Rp 10.000.000</p>
        </div>
      </div>
    </div>
  </div>
</div>
