<div>
  <x-header subtitle="Masukkan Jumlah Dana Harian (100.000,00)" separator />
  <div class="lg:w-1/2">
    <!-- Dana Darurat Fund Form -->
    <x-form>
      <!-- Form Inputs -->
      <div x-data x-init="$el.querySelector('input')?.focus(); $el.querySelector('input')?.select()" @focus-jumlah.window="$el.querySelector('input')?.focus(); $el.querySelector('input')?.select()">
        <x-input label="Jumlah" wire:model="amount" prefix="IDR" locale="id-ID" money inline />
      </div>
      <x-select label="Tipe" wire:model="type" :options="$types" icon="lucide.receipt" inline />
      <x-textarea label="Keterangan" wire:model="description" placeholder="Tulis sesuatu ..." rows="5" inline />

      <!-- Form Actions -->
      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" link="/auth/dana-harian" />
        <x-button label="Tambah Lagi" icon="lucide.plus" class="btn-success btn-sm" wire:click="tambahLagi" spinner />
        <x-button label="Tambah" icon="lucide.circle-fading-plus" class="btn-primary btn-sm" wire:click="tambahDanKembali" spinner />
      </x-slot:actions>
    </x-form>
  </div>
</div>
