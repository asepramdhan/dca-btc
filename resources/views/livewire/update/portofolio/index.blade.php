<?php

use Livewire\Volt\Component;

new class extends Component {
    public $transaction_type = 'buy';
    public $asset = 'BTC';
    public $quantity, $price, $date, $total;
    public function addTransaction(): void
    {
      $this->dispatch('close-add-modal');
      // dd([
      //     'transaction_type' => $this->transaction_type,
      //     'asset' => $this->asset,
      //     'quantity' => str_replace('.', '', $this->quantity),
      //     'price' => str_replace('.', '', $this->price),
      //     'date' => $this->date,
      //     'total' => str_replace('.', '', $this->total),
      // ]);
    }
    public function updateTransaction(): void
    {
        $this->dispatch('close-edit-modal');
    }
    public function deleteTransaction(): void
    {
        $this->dispatch('close-delete-modal');
    }
}; ?>

<div>
  <!-- Page Content -->
  <div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
    <h1 class="text-3xl font-bold text-white">Portofolio Aset</h1>
    <button @click="isAddModalOpen = true" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition-colors mt-4 md:mt-0 cursor-pointer">
      <x-icon name="lucide.plus-circle" class="w-5 h-5" />
      Tambah Transaksi
    </button>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card p-6">
      <h3 class="text-slate-400 font-medium mb-2">Nilai Portofolio Saat Ini</h3>
      <p class="text-3xl font-bold text-white">Rp 120.300.000</p>
    </div>
    <div class="card p-6">
      <h3 class="text-slate-400 font-medium mb-2">Total Investasi</h3>
      <p class="text-3xl font-bold text-white">Rp 108.000.000</p>
    </div>
    <div class="card p-6">
      <h3 class="text-slate-400 font-medium mb-2">Laba/Rugi Portofolio</h3>
      <p class="text-3xl font-bold text-green-500">+ Rp 12.300.000</p>
    </div>
  </div>

  <!-- Asset Table -->
  <div class="card">
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Aset</th>
            <th>Jumlah</th>
            <th>Harga Beli Rata-rata</th>
            <th>Nilai Saat Ini</th>
            <th>Laba/Rugi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Contoh Baris Data -->
          <tr>
            <td>
              <div class="flex items-center">
                <img src="https://placehold.co/32x32/FBBF24/000000?text=B" alt="BTC Logo" class="w-8 h-8 mr-4 rounded-full" />
                <div>
                  <p class="font-bold text-white">Bitcoin</p>
                  <p class="text-sm text-slate-400">BTC</p>
                </div>
              </div>
            </td>
            <td>
              <p class="font-semibold text-white">1.25 BTC</p>
            </td>
            <td>
              <p class="font-semibold text-white">Rp 86.400.000</p>
            </td>
            <td>
              <p class="font-semibold text-white">Rp 96.240.000</p>
            </td>
            <td>
              <p class="font-semibold text-green-500">+11.39%</p>
            </td>
            <td>
              <div class="flex space-x-2">
                <button @click="isEditModalOpen = true" class="text-slate-400 hover:text-sky-400 cursor-pointer">
                  <x-icon name="lucide.edit-3" class="w-5 h-5" /></button>
                <button @click="isDeleteModalOpen = true" class="text-slate-400 hover:text-red-500 cursor-pointer">
                  <x-icon name="lucide.trash-2" class="w-5 h-5" /></button>
              </div>
            </td>
          </tr>
          <!-- Tambahkan baris lain jika ada aset lain -->
        </tbody>
      </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 flex justify-between items-center text-sm text-slate-400 border-t border-slate-800">
      <span>Menampilkan 1 dari 1 Aset</span>
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
            <div class="grid grid-cols-2 gap-4">
              <label>
                <input type="radio" wire:model="transaction_type" value="buy" class="sr-only peer">
                <div class="p-3 w-full rounded-lg border border-slate-700 text-center cursor-pointer peer-checked:border-sky-500 peer-checked:bg-sky-500/10 peer-checked:text-sky-400 font-semibold">Beli</div>
              </label>
              <label>
                <input type="radio" wire:model="transaction_type" value="sell" class="sr-only peer">
                <div class="p-3 w-full rounded-lg border border-slate-700 text-center cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-500/10 peer-checked:text-red-400 font-semibold">Jual</div>
              </label>
            </div>
          </div>
          <!-- Asset -->
          <div>
            <label for="asset" class="block text-sm font-medium text-slate-300 mb-2">Aset</label>
            <select id="asset" wire:model="asset" class="form-input">
              <option value="BTC">Bitcoin (BTC)</option>
            </select>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="quantity" class="block text-sm font-medium text-slate-300 mb-2">Jumlah</label>
              <input type="text" inputmode="decimal" step="any" id="quantity" x-mask:dynamic="'9.99999'" wire:model="quantity" placeholder="Contoh: 0.05 atau 1.12345" class="form-input">
            </div>
            <div>
              <label for="price" class="block text-sm font-medium text-slate-300 mb-2">Harga per Koin (IDR)</label>
              <input type="text" inputmode="decimal" step="any" id="price" x-mask:dynamic="$money($input, ',')" wire:model="price" placeholder="Contoh: 90.000.000" class="form-input">
            </div>
          </div>

          <div>
            <label for="date" class="block text-sm font-medium text-slate-300 mb-2">Tanggal Transaksi</label>
            <input type="date" id="date" wire:model="date" class="form-input text-slate-400">
          </div>

          <div>
            <label for="total" class="block text-sm font-medium text-slate-300 mb-2">Total Biaya/Penerimaan (IDR)</label>
            <input type="text" inputmode="decimal" step="any" id="total" x-mask:dynamic="$money($input, ',')" wire:model="total" placeholder="Total termasuk fee Contoh: 85.000.000" class="form-input">
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

  <!-- ===== Edit Transaction Modal ===== -->
  <div x-show="isEditModalOpen" @keydown.escape.window="isEditModalOpen = false" class="fixed inset-0 bg-black z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);" x-cloak>
    <div @click.away="isEditModalOpen = false" class="card w-full max-w-lg max-h-full overflow-y-auto">
      <div class="p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-white">Edit Transaksi</h2>
          <button @click="isEditModalOpen = false" class="text-slate-400 hover:text-white cursor-pointer">
            <x-icon name="lucide.x" class="w-6 h-6" />
          </button>
        </div>
        <form wire:submit.prevent="updateTransaction" class="space-y-4">
          <!-- Transaction Type -->
          <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Tipe Transaksi</label>
            <div class="grid grid-cols-2 gap-4">
              <label>
                <input type="radio" wire:model="transaction_type" value="buy" class="sr-only peer">
                <div class="p-3 w-full rounded-lg border border-slate-700 text-center cursor-pointer peer-checked:border-sky-500 peer-checked:bg-sky-500/10 peer-checked:text-sky-400 font-semibold">Beli</div>
              </label>
              <label>
                <input type="radio" wire:model="transaction_type" value="sell" class="sr-only peer">
                <div class="p-3 w-full rounded-lg border border-slate-700 text-center cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-500/10 peer-checked:text-red-400 font-semibold">Jual</div>
              </label>
            </div>
          </div>
          <!-- Asset -->
          <div>
            <label for="asset" class="block text-sm font-medium text-slate-300 mb-2">Aset</label>
            <select id="asset" wire:model="asset" class="form-input">
              <option value="BTC">Bitcoin (BTC)</option>
            </select>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="quantity" class="block text-sm font-medium text-slate-300 mb-2">Jumlah</label>
              <input type="text" inputmode="decimal" step="any" id="quantity" x-mask:dynamic="'9.99999'" wire:model="quantity" placeholder="Contoh: 0.05 atau 1.12345" class="form-input">
            </div>
            <div>
              <label for="price" class="block text-sm font-medium text-slate-300 mb-2">Harga per Koin (IDR)</label>
              <input type="text" inputmode="decimal" step="any" id="price" x-mask:dynamic="$money($input, ',')" wire:model="price" placeholder="Contoh: 90.000.000" class="form-input">
            </div>
          </div>

          <div>
            <label for="date" class="block text-sm font-medium text-slate-300 mb-2">Tanggal Transaksi</label>
            <input type="date" id="date" wire:model="date" class="form-input text-slate-400">
          </div>

          <div>
            <label for="total" class="block text-sm font-medium text-slate-300 mb-2">Total Biaya/Penerimaan (IDR)</label>
            <input type="text" inputmode="decimal" step="any" id="total" x-mask:dynamic="$money($input, ',')" wire:model="total" placeholder="Total termasuk fee Contoh: 85.000.000" class="form-input">
          </div>

          <div class="pt-4 flex justify-end gap-4">
            <button type="button" @click="isEditModalOpen = false" class="bg-slate-700 hover:bg-slate-600 text-white font-semibold px-6 py-2 rounded-lg cursor-pointer">Batal</button>
            <button type="submit" wire:loading.attr="disabled" wire:target="updateTransaction" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-6 py-2 rounded-lg cursor-pointer">
              <x-loading wire:loading wire:target="updateTransaction" class="loading-dots" />
              <span wire:loading.remove wire:target="updateTransaction">
                Simpan Perubahan
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ===== Delete Confirmation Modal ===== -->
  <div x-show="isDeleteModalOpen" @keydown.escape.window="isDeleteModalOpen = false" class="fixed inset-0 bg-black z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);" x-cloak>
    <div @click.away="isDeleteModalOpen = false" class="card w-full max-w-md">
      <div class="p-6 md:p-8 text-center">
        <div class="mx-auto bg-red-500/10 w-16 h-16 flex items-center justify-center rounded-full mb-4">
          <x-icon name="lucide.trash-2" class="w-8 h-8 text-red-500" />
        </div>
        <h2 class="text-2xl font-bold text-white">Hapus Transaksi?</h2>
        <p class="text-slate-400 mt-2">
          Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.
        </p>
        <form wire:submit.prevent="deleteTransaction">
          <div class="mt-6 flex justify-center gap-4">
            <button type="button" @click="isDeleteModalOpen = false" class="bg-slate-700 hover:bg-slate-600 text-white font-semibold px-6 py-2 rounded-lg w-full cursor-pointer">Batal</button>
            <button type="submit" wire:loading.attr="disabled" wire:target="deleteTransaction" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg w-full cursor-pointer">
              <x-loading wire:loading wire:target="deleteTransaction" class="loading-dots" />
              <span wire:loading.remove wire:target="deleteTransaction">
                Ya, Hapus
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
