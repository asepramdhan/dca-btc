<?php

use App\Models\Asset;
use App\Models\FinancialEntry;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Volt\Component;

new class extends Component {
  use WithPagination;

  // Properti untuk filter
  public $filterType = '';
  public $filterAsset = '';
  public $search = '';
  public $filterDate = '';

  // Properti untuk modal
  public $showAddModal = false;
  public $showEditModal = false;
  public $showDeleteModal = false;

  // Properti untuk form
  public $type = 'income', $asset_id, $quantity, $price_per_unit, $amount, $category, $notes, $transaction_date;

  // Properti untuk aksi
  public ?FinancialEntry $editing = null;
  public ?FinancialEntry $deleting = null;

  public function addTransaction(): void
  {
    // Membersihkan nilai
    $this->amount = $this->amount ? str_replace('.', '', $this->amount) : null;
    $this->price_per_unit = $this->price_per_unit ? str_replace('.', '', $this->price_per_unit) : null;
    $this->quantity = $this->quantity ? str_replace(',', '.', $this->quantity) : null;

    $validated = $this->validate([
      'type' => 'required|in:buy,sell,income,expense',
      'amount' => 'required|numeric|min:0',
      'transaction_date' => 'required|date',
      'category' => 'required_if:type,income,expense|nullable|string|max:255',
      'notes' => 'nullable|string',
      'asset_id' => 'required_if:type,buy,sell|nullable|exists:assets,id',
      'quantity' => 'required_if:type,buy,sell|nullable|numeric|min:0',
      'price_per_unit' => 'required_if:type,buy,sell|nullable|numeric|min:0',
    ]);

    FinancialEntry::create($validated + ['user_id' => Auth::id()]);

    $this->reset(['type', 'asset_id', 'quantity', 'price_per_unit', 'amount', 'category', 'notes', 'transaction_date']);
    $this->type = 'income';

    session()->flash('message', 'Transaksi berhasil ditambahkan.');
    $this->showAddModal = false;
  }

  public function prepareToEdit(FinancialEntry $entry): void
  {
    $this->editing = $entry;

    $this->type = $entry->type;
    $this->asset_id = $entry->asset_id;
    $this->quantity = $entry->quantity;
    $this->price_per_unit = number_format($entry->price_per_unit ?? 0, 0, ',', '.');
    $this->amount = number_format($entry->amount, 0, ',', '.');
    $this->category = $entry->category;
    $this->notes = $entry->notes;
    $this->transaction_date = $entry->transaction_date->format('Y-m-d');

    $this->showEditModal = true;
  }

  public function updateTransaction(): void
  {
    if (!$this->editing) {
      return;
    }

    // Membersihkan nilai
    $this->amount = $this->amount ? str_replace('.', '', $this->amount) : null;
    $this->price_per_unit = $this->price_per_unit ? str_replace('.', '', $this->price_per_unit) : null;
    $this->quantity = $this->quantity ? str_replace(',', '.', $this->quantity) : null;

    $validated = $this->validate([
      'type' => 'required|in:buy,sell,income,expense',
      'amount' => 'required|numeric|min:0',
      'transaction_date' => 'required|date',
      'category' => 'required_if:type,income,expense|nullable|string|max:255',
      'notes' => 'nullable|string',
      'asset_id' => 'required_if:type,buy,sell|nullable|exists:assets,id',
      'quantity' => 'required_if:type,buy,sell|nullable|numeric|min:0',
      'price_per_unit' => 'required_if:type,buy,sell|nullable|numeric|min:0',
    ]);

    $this->editing->update($validated);

    session()->flash('message', 'Transaksi berhasil diperbarui.');
    $this->showEditModal = false;
  }

  public function prepareToDelete(FinancialEntry $entry): void
  {
    $this->deleting = $entry;
    $this->showDeleteModal = true;
  }

  public function deleteTransaction(): void
  {
    if ($this->deleting) {
      $this->deleting->delete();
      session()->flash('message', 'Transaksi berhasil dihapus.');
    }
    $this->showDeleteModal = false;
  }

  public function with(): array
  {
    $query = FinancialEntry::with('asset')
      ->where('user_id', Auth::id())
      ->orderBy('transaction_date', 'desc');

    if ($this->filterType) {
      $query->where('type', $this->filterType);
    }

    if ($this->filterAsset) {
      $query->where('asset_id', $this->filterAsset);
    }

    if ($this->search) {
      $query->where('category', 'like', '%' . $this->search . '%');
    }

    if ($this->filterDate) {
      $query->whereDate('transaction_date', $this->filterDate);
    }

    return [
      'transactions' => $query->paginate(10),
      'assets' => Asset::all(),
    ];
  }
}; ?>

<div>
  <!-- Page Content -->
  <div class="mb-6 flex flex-col justify-between md:flex-row md:items-center">
    <h1 class="text-3xl font-bold text-white">Riwayat Transaksi</h1>
    <button @click="$wire.set('showAddModal', true)" class="mt-4 flex cursor-pointer items-center gap-2 rounded-lg bg-sky-500 px-4 py-2 font-semibold text-white transition-colors hover:bg-sky-600 md:mt-0">
      <x-icon name="lucide.plus-circle" class="h-5 w-5" />
      Tambah Transaksi
    </button>
  </div>

  <!-- Filters -->
  <div class="card mb-6 p-4">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <input type="text" wire:model.live="search" placeholder="Cari berdasarkan kategori..." class="rounded-lg border border-slate-700 bg-slate-800 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500">
      <select wire:model.live="filterType" class="rounded-lg border border-slate-700 bg-slate-800 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500">
        <option value="">Semua Tipe</option>
        <option value="buy">Beli</option>
        <option value="sell">Jual</option>
        <option value="income">Pemasukan</option>
        <option value="expense">Pengeluaran</option>
      </select>
      <select wire:model.live="filterAsset" class="rounded-lg border border-slate-700 bg-slate-800 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500">
        <option value="">Semua Aset</option>
        @foreach ($assets as $asset)
        <option value="{{ $asset->id }}">{{ $asset->name }}</option>
        @endforeach
      </select>
      <input type="date" wire:model.live="filterDate" class="rounded-lg border border-slate-700 bg-slate-800 px-4 py-2 text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
    </div>
  </div>

  <x-update.alert />

  <!-- Transactions Table -->
  <div class="card">
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Aset/Kategori</th>
            <th>Jumlah</th>
            <th>Nilai (IDR)</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($transactions as $transaction)
          <tr>
            <td class="text-slate-300">{{ $transaction->transaction_date->format('d M Y') }}</td>
            <td>
              @if ($transaction->type == 'buy')
              <p class="font-semibold text-green-400">Beli</p>
              @elseif($transaction->type == 'sell')
              <p class="font-semibold text-red-400">Jual</p>
              @elseif($transaction->type == 'income')
              <p class="font-semibold text-sky-400">Pemasukan</p>
              @else
              <p class="font-semibold text-orange-400">Pengeluaran</p>
              @endif
            </td>
            <td>
              <p class="font-semibold text-white">{{ Str::title($transaction->asset->name ?? $transaction->category) }}</p>
            </td>
            <td>
              @if ($transaction->quantity && $transaction->asset)
              <p class="font-semibold text-white">{{ rtrim(rtrim(number_format($transaction->quantity, 8, '.', '.'), '0'), '.') }} {{ $transaction->asset->symbol }}</p>
              @else
              -
              @endif
            </td>
            <td>
              <p class="text-slate-300">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
            </td>
            <td>
              <div class="flex space-x-2">
                <button wire:click="prepareToEdit({{ $transaction->id }})" class="cursor-pointer text-slate-400 hover:text-sky-400">
                  <x-icon name="lucide.edit-3" class="h-5 w-5" />
                </button>
                <button wire:click="prepareToDelete({{ $transaction->id }})" class="cursor-pointer text-slate-400 hover:text-red-500">
                  <x-icon name="lucide.trash-2" class="h-5 w-5" />
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada transaksi yang ditemukan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Pagination -->
    <div class="border-t border-slate-800 p-4">
      {{ $transactions->links('livewire.update.tailwind-custom') }}
    </div>
  </div>

  <!-- ===== Add Transaction Modal ===== -->
  <div x-data="{ show: @entangle('showAddModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black p-4" style="background-color: rgba(0, 0, 0, 0.7)" x-cloak>
    <div @click.away="show = false" class="card max-h-full w-full max-w-lg overflow-y-auto">
      @include('livewire.update.partials.transaction-form', ['formType' => 'add'])
    </div>
  </div>

  <!-- Edit Modal -->
  <div x-data="{ show: @entangle('showEditModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black p-4" style="background-color: rgba(0, 0, 0, 0.7)" x-cloak>
    <div @click.away="show = false" class="card max-h-full w-full max-w-lg overflow-y-auto">
      @include('livewire.update.partials.transaction-form', ['formType' => 'edit'])
    </div>
  </div>

  <!-- ===== Delete Confirmation Modal ===== -->
  <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black p-4" style="background-color: rgba(0, 0, 0, 0.7)" x-cloak>
    <div @click.away="show = false" class="card w-full max-w-md">
      <div class="p-6 text-center md:p-8">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-500/10">
          <x-icon name="lucide.trash-2" class="h-8 w-8 text-red-500" />
        </div>
        <h2 class="text-2xl font-bold text-white">Hapus Transaksi?</h2>
        <p class="mt-2 text-slate-400">
          Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="mt-6 flex justify-center gap-4">
          <button type="button" @click="show = false" class="w-full cursor-pointer rounded-lg bg-slate-700 px-6 py-2 font-semibold text-white hover:bg-slate-600">Batal</button>
          <button type="button" wire:click="deleteTransaction" wire:loading.attr="disabled" wire:target="deleteTransaction" class="w-full cursor-pointer rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">
            <x-loading wire:loading wire:target="deleteTransaction" class="loading-dots" />
            <span wire:loading.remove wire:target="deleteTransaction">
              Ya, Hapus
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
