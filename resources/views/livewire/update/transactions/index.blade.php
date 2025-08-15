<?php

use Livewire\Volt\Component;

new class extends Component {
  public $transaction_type = 'income';
  public $category, $amount, $asset_quantity, $date, $notes;
  public function addTransaction(): void
  {
    $this->dispatch('close-add-modal');
    // dd([
    //   'transaction_type' => $this->transaction_type,
    //   'category' => $this->category,
    //   'amount' => str_replace('.', '', $this->amount),
    //   'asset_quantity' => str_replace('.', '', $this->asset_quantity),
    //   'date' => $this->date,
    //   'notes' => $this->notes,
    //   'status' => 'pending',
    // ]);
  }
}; ?>

<div>
  <!-- Page Content -->
  <div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
    <h1 class="text-3xl font-bold text-white">Riwayat Transaksi</h1>
    <button @click="isAddModalOpen = true" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition-colors mt-4 md:mt-0 cursor-pointer">
      <x-icon name="lucide.plus-circle" class="w-5 h-5" />
      Tambah Transaksi
    </button>
  </div>

  <!-- Filters -->
  <div class="card p-4 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <input type="text" placeholder="Cari transaksi..." class="bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none">
      <select class="bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none">
        <option>Semua Tipe</option>
        <option>Beli</option>
        <option>Jual</option>
        <option>Pemasukan</option>
        <option>Pengeluaran</option>
      </select>
      <select class="bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none">
        <option>Semua Aset</option>
        <option>Bitcoin</option>
        <option>Cash</option>
      </select>
      <input type="date" class="bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none text-slate-400">
    </div>
  </div>

  <!-- Transactions Table -->
  <div class="card">
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Aset</th>
            <th>Jumlah</th>
            <th>Nilai (IDR)</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <!-- Contoh Baris Data -->
          <tr>
            <td class="text-slate-300">10 Agu 2024</td>
            <td>
              <p class="font-semibold text-green-400">Beli</p>
            </td>
            <td>
              <p class="font-semibold text-white">Bitcoin</p>
            </td>
            <td>
              <p class="font-semibold text-white">+0.05 BTC</p>
            </td>
            <td>
              <p class="text-slate-300">Rp 4.500.000</p>
            </td>
            <td><span class="status-badge bg-green-500/20 text-green-400">Selesai</span></td>
          </tr>
          <tr>
            <td class="text-slate-300">5 Agu 2024</td>
            <td>
              <p class="font-semibold text-red-400">Jual</p>
            </td>
            <td>
              <p class="font-semibold text-white">Bitcoin</p>
            </td>
            <td>
              <p class="font-semibold text-white">-0.02 BTC</p>
            </td>
            <td>
              <p class="text-slate-300">Rp 1.950.000</p>
            </td>
            <td><span class="status-badge bg-green-500/20 text-green-400">Selesai</span></td>
          </tr>
          <tr>
            <td class="text-slate-300">1 Agu 2024</td>
            <td>
              <p class="font-semibold text-sky-400">Pemasukan</p>
            </td>
            <td>
              <p class="font-semibold text-white">Cash</p>
            </td>
            <td>
              <p class="font-semibold text-white">+Rp 10.000.000</p>
            </td>
            <td>
              <p class="text-slate-300">Rp 10.000.000</p>
            </td>
            <td><span class="status-badge bg-green-500/20 text-green-400">Selesai</span></td>
          </tr>
          <tr>
            <td class="text-slate-300">28 Jul 2024</td>
            <td>
              <p class="font-semibold text-orange-400">Pengeluaran</p>
            </td>
            <td>
              <p class="font-semibold text-white">Cash</p>
            </td>
            <td>
              <p class="font-semibold text-white">-Rp 1.200.000</p>
            </td>
            <td>
              <p class="text-slate-300">Rp 1.200.000</p>
            </td>
            <td><span class="status-badge bg-green-500/20 text-green-400">Selesai</span></td>
          </tr>
          <tr>
            <td class="text-slate-300">25 Jul 2024</td>
            <td>
              <p class="font-semibold text-green-400">Beli</p>
            </td>
            <td>
              <p class="font-semibold text-white">Bitcoin</p>
            </td>
            <td>
              <p class="font-semibold text-white">+0.1 BTC</p>
            </td>
            <td>
              <p class="text-slate-300">Rp 8.900.000</p>
            </td>
            <td><span class="status-badge bg-yellow-500/20 text-yellow-400">Pending</span></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 flex justify-between items-center text-sm text-slate-400 border-t border-slate-800">
      <span>Menampilkan 1-5 dari 20 Transaksi</span>
      <div class="flex items-center gap-2">
        <button class="p-2 rounded hover:bg-slate-700 disabled:opacity-50" disabled>
          <x-icon name="lucide.chevron-left" class="w-4 h-4" /></button>
        <span class="bg-slate-700 text-white font-semibold rounded px-3 py-1">1</span>
        <button class="p-2 rounded hover:bg-slate-700 cursor-pointer">
          <x-icon name="lucide.chevron-right" class="w-4 h-4" /></button>
      </div>
    </div>
  </div>

  <!-- ===== Add Transaction Modal ===== -->
  <div x-show="isAddModalOpen" @keydown.escape.window="isAddModalOpen = false" class="fixed inset-0 bg-black z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);" x-cloak>
    <div @click.away="isAddModalOpen = false" class="card w-full max-w-lg max-h-full overflow-y-auto">
      <div class="p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-white">Tambah Transaksi</h2>
          <button @click="isAddModalOpen = false" class="text-slate-400 hover:text-white cursor-pointer">
            <x-icon name="lucide.x" class="w-6 h-6" />
          </button>
        </div>
        <form wire:submit.prevent="addTransaction" class="space-y-4">
          <!-- Transaction Type -->
          <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Tipe Transaksi</label>
            <select id="transaction-type" wire:model.live="transaction_type" x-data="{ transactionType: @entangle('transaction_type') }" x-on:change="transactionType = $event.target.value" class="form-input">
              <option value="income">Pemasukan</option>
              <option value="expense">Pengeluaran</option>
              <option value="buy">Beli Aset</option>
              <option value="sell">Jual Aset</option>
            </select>
          </div>

          <!-- Kategori / Aset -->
          <div>
            <label for="category" class="block text-sm font-medium text-slate-300 mb-2">Kategori / Aset</label>
            <input type="text" id="category" wire:model="category" placeholder="Contoh: Gaji, Makanan, Bitcoin" class="form-input">
          </div>

          <!-- Jumlah (IDR) -->
          <div>
            <label for="amount" class="block text-sm font-medium text-slate-300 mb-2">Jumlah (IDR)</label>
            <input type="text" inputmode="decimal" step="any" id="amount" x-mask:dynamic="$money($input, ',')" wire:model="amount" placeholder="Contoh: 50.000" class="form-input">
          </div>

          <!-- Jumlah Aset (Hanya untuk Beli/Jual) -->
          <div id="asset-quantity-group" x-data="{ transactionType: @entangle('transaction_type') }" x-show="transactionType === 'buy' || transactionType === 'sell'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
            <label for="asset_quantity" class="block text-sm font-medium text-slate-300 mb-2">Jumlah Aset</label>
            <input type="text" inputmode="decimal" step="any" id="asset_quantity" x-mask:dynamic="'9.99999'" wire:model="asset_quantity" placeholder="Contoh: 0.05 atau 1.12345" class="form-input">
          </div>

          <!-- Tanggal -->
          <div>
            <label for="date" class="block text-sm font-medium text-slate-300 mb-2">Tanggal Transaksi</label>
            <input type="date" id="date" wire:model="date" class="form-input text-slate-400">
          </div>

          <!-- Catatan -->
          <div>
            <label for="notes" class="block text-sm font-medium text-slate-300 mb-2">Catatan (Opsional)</label>
            <textarea id="notes" wire:model="notes" rows="3" class="form-input" placeholder="Detail tambahan..."></textarea>
          </div>

          <div class="pt-4 flex justify-end gap-4">
            <button type="button" @click="isAddModalOpen = false" class="bg-slate-700 hover:bg-slate-600 text-white font-semibold px-6 py-2 rounded-lg cursor-pointer">Batal</button>
            <button type="submit" wire:loading.attr="disabled" wire:target="addTransaction" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-6 py-2 rounded-lg cursor-pointer">
              <x-loading wire:loading wire:target="addTransaction" class="loading-dots" />
              <span wire:loading.remove wire:target="addTransaction">
                Simpan Transaksi
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
