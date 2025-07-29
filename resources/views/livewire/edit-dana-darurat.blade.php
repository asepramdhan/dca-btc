<div>
  <x-header subtitle="Masukkan Jumlah Dana Darurat, Apabila mau diubah (100.000,00)" separator />
  <div class="lg:w-1/2">
    <!-- Dana Darurat Fund Form -->
    <x-form wire:submit="editDanaDarurat">
      <!-- Form Inputs -->
      <x-input label="Jumlah" wire:model="amount" prefix="IDR" locale="id-ID" money inline />
      <x-select label="Tipe" wire:model="type" :options="$types" icon="o-rocket-launch" inline />
      <x-textarea label="Keterangan" wire:model="description" placeholder="Tulis sesuatu ..." rows="5" inline />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/auth/dana-darurat" />
        <x-button label="Ubah" icon="lucide.edit" class="btn-primary btn-sm" type="submit" spinner="editDanaDarurat" />
      </x-slot:actions>
    </x-form>
  </div>
</div>
