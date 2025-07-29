<div>
  <x-header subtitle="Silahkan Ubah Exchange / Fee" separator />
  <div class="lg:w-1/2">
    <!-- Dana Darurat Fund Form -->
    <x-form wire:submit="editExchange">
      <!-- Form Inputs -->
      <x-input label="Nama Exchange" wire:model="name" placeholder="Nama Exchange" icon="lucide.repeat" inline />
      <x-input label="Fee Beli" wire:model="fee_buy" placeholder="0.00%" icon="lucide.trending-down" inline />
      <x-input label="Fee Jual" wire:model="fee_sell" placeholder="0.00%" icon="lucide.trending-up" inline />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/auth/exchange" />
        <x-button label="Ubah" icon="lucide.edit" class="btn-primary btn-sm" type="submit" spinner="editExchange" />
      </x-slot:actions>
    </x-form>
  </div>
</div>
