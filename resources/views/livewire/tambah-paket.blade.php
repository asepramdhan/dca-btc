<div>
  <x-header subtitle="Tambahkan Paket Baru" separator />
  <div class="lg:w-1/2">
    <!-- Paket creation form -->
    <x-form>
      <x-input label="Nama Paket" wire:model="name" placeholder="Premium 1 bulan" icon="lucide.badge-dollar-sign" inline autofocus />
      <x-input label="Harga" wire:model="price" placeholder="Harga Paket" icon="lucide.coins" inline money />
      <x-select label="Durasi" wire:model="duration" :options="$durations" icon="lucide.receipt" inline />
      <x-textarea label="Keterangan" wire:model="description" placeholder="Tulis sesuatu ..." rows="5" inline />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/admin/paket" />
        <x-button label="Tambah Lagi" icon="lucide.plus" class="btn-success btn-sm" wire:click="tambahLagi" spinner />
        <x-button label="Tambah" icon="lucide.circle-fading-plus" class="btn-primary btn-sm" wire:click="tambahDanKembali" spinner />
      </x-slot:actions>
    </x-form>
  </div>
</div>
