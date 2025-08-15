<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
  <!-- Page Content -->
  <div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
    <h1 class="text-3xl font-bold text-white">Laporan Keuangan</h1>
    <div class="flex items-center gap-4 mt-4 md:mt-0">
      <select class="bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none">
        <option>Bulan Ini</option>
        <option>Bulan Lalu</option>
        <option>Tahun Ini</option>
        <option>Semua</option>
      </select>
      <button class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition-colors cursor-pointer">
        <x-icon name="lucide.download" class="w-5 h-5" />
        Unduh Laporan
      </button>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card p-6">
      <h3 class="text-slate-400 font-medium mb-2">Total Pemasukan</h3>
      <p class="text-3xl font-bold text-green-500">+ Rp 10.000.000</p>
    </div>
    <div class="card p-6">
      <h3 class="text-slate-400 font-medium mb-2">Total Pengeluaran</h3>
      <p class="text-3xl font-bold text-red-500">- Rp 7.650.000</p>
    </div>
    <div class="card p-6">
      <h3 class="text-slate-400 font-medium mb-2">Arus Kas Bersih</h3>
      <p class="text-3xl font-bold text-white">+ Rp 2.350.000</p>
    </div>
  </div>

  <!-- Charts -->
  <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
    <!-- Main Chart -->
    <div class="lg:col-span-3 card p-6">
      <h3 class="text-xl font-bold text-white mb-4">Pemasukan vs Pengeluaran</h3>
      <div class="h-80 bg-slate-800 rounded-lg flex items-center justify-center">
        <p class="text-slate-500">Placeholder untuk Grafik Batang/Garis</p>
      </div>
    </div>
    <!-- Pie Chart -->
    <div class="lg:col-span-2 card p-6">
      <h3 class="text-xl font-bold text-white mb-4">Alokasi Pengeluaran</h3>
      <div class="h-80 bg-slate-800 rounded-lg flex items-center justify-center">
        <p class="text-slate-500">Placeholder untuk Grafik Lingkaran</p>
      </div>
    </div>
  </div>
</div>
