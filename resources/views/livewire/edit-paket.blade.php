<div>
  <x-header subtitle="Edit Paket" separator />
  <div class="lg:w-1/2">
    <!-- Paket edit form -->
    <x-form wire:submit="updatePaket">
      <x-input label="Nama Paket" wire:model="name" placeholder="Premium 1 bulan" icon="lucide.badge-dollar-sign" inline autofocus />
      <x-input label="Harga" wire:model="price" placeholder="Harga Paket" icon="lucide.coins" inline money />
      <x-select label="Durasi" wire:model="duration" :options="$durations" icon="lucide.receipt" inline />
      <x-textarea label="Keterangan" wire:model="description" placeholder="Tulis sesuatu ..." rows="5" inline />
      <x-checkbox label="Paket Aktif" wire:model="is_active" />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/admin/paket" />
        <x-button label="Ubah" icon="lucide.edit" class="btn-primary btn-sm" wire:click="updatePaket" spinner="updatePaket" />
      </x-slot:actions>
    </x-form>
  </div>
</div>
