<div>
  <x-header subtitle="Edit Investasi" separator />
  <div class="lg:w-1/2">
    <x-form wire:submit="editInvestasi">
      <!-- Form Inputs -->
      <x-datepicker label="Tanggal & Waktu" wire:model="created_at" icon="lucide.calendar" :config="$configWithTime" inline />
      <x-select label="Nama Exchange" wire:model="exchange_id" :options="$exchanges" icon="lucide.repeat" inline />
      <x-input label="Jumlah Beli" wire:model="amount" prefix="IDR" locale="id-ID" money inline />
      <x-input label="Harga Beli / Jual" wire:model="price" prefix="IDR" locale="id-ID" money inline />
      <x-select label="Tipe" wire:model="type" :options="$types" icon="o-rocket-launch" inline />
      <x-textarea label="Keterangan" wire:model="description" placeholder="Tulis sesuatu ..." rows="5" inline />

      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/auth/investasi" />
        <x-button label="Ubah" icon="lucide.edit" class="btn-primary btn-sm" type="submit" spinner="editInvestasi" />
      </x-slot:actions>
    </x-form>
  </div>
</div>
