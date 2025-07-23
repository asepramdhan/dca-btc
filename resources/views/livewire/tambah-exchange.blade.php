<div>
  <x-header subtitle="Tambahkan Exchange dan masukan fee (Fee Beli 0.00% dan Fee 0.00% Jual)" separator />
  <div class="lg:w-1/2">
    <!-- Exchange creation form -->
    <x-form>
      <div x-data x-init="$el.querySelector('input')?.focus(); $el.querySelector('input')?.select()" @focus-name.window="$el.querySelector('input')?.focus()">
        <x-input label="Nama Exchange" wire:model="name" placeholder="Nama Exchange" icon="lucide.repeat" inline />
      </div>
      <x-input label="Fee Beli" wire:model="fee_buy" placeholder="0.00%" icon="lucide.trending-down" inline />
      <x-input label="Fee Jual" wire:model="fee_sell" placeholder="0.00%" icon="lucide.trending-up" inline />
      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" :link="route('exchange')" />
        <x-button label="Tambah Lagi" icon="lucide.plus" class="btn-success btn-sm" wire:click="tambahLagi" spinner />
        <x-button label="Tambah" icon="lucide.circle-fading-plus" class="btn-primary btn-sm" wire:click="tambahDanKembali" spinner />
      </x-slot:actions>
    </x-form>
  </div>
</div>
