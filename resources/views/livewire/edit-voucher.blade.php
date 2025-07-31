<div>
  <x-header subtitle="Edit Voucher" separator />
  <div class="lg:w-1/2">
    <!-- Formulir edit voucher -->
    <x-form wire:submit="editVoucher">
      <!-- Perhatikan `min-chars` dan `debounce` -->
      <x-choices label="Nama User" wire:model="selectUserId" placeholder="Nama Lengkap" icon="lucide.user-square-2" :options="$searchUsers" option-value="id" option-label="name" search-function="search" debounce="300ms" min-chars="2" single searchable clearable inline />
      <x-select label="Paket" wire:model="packageId" :options="$packages" icon="lucide.receipt" inline />

      <!-- Aksi Formulir -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/admin/voucher" />
        <x-button label="Ubah Voucher" icon="lucide.ticket" class="btn-primary btn-sm" type="submit" spinner="editVoucher" />
      </x-slot:actions>
    </x-form>
  </div>
</div>
