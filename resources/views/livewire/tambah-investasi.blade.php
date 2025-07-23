<div>
  <x-header subtitle="Masukkan Jumlah Dana Investasi (100.000.000,00)" separator />
  <div class="lg:w-1/2">
    <x-form>
      <!-- Form Inputs -->
      <x-datepicker label="Tanggal & Waktu" wire:model="created_at" icon="lucide.calendar" :config="$configWithTime" inline />
      <x-select label="Nama Exchange" wire:model="exchange_id" :options="$exchanges" icon="lucide.repeat" inline />
      <div x-data x-init="$el.querySelector('input')?.focus(); $el.querySelector('input')?.select()" @focus-jumlah.window="$el.querySelector('input')?.focus(); $el.querySelector('input')?.select()">
        <x-input label="Jumlah Beli" wire:model="amount" prefix="IDR" locale="id-ID" money inline />
      </div>
      <x-input label="Harga Beli / Jual" wire:model="price" prefix="IDR" locale="id-ID" money inline />
      <x-select label="Tipe" wire:model="type" :options="$types" icon="o-rocket-launch" inline />
      <x-textarea label="Keterangan" wire:model="description" placeholder="Tulis sesuatu ..." rows="5" inline />

      <x-slot:actions>
        <x-button label="Kembali" icon="lucide.chevron-left" class="btn-sm" :link="route('investasi')" />
        <x-button label="Tambah Lagi" icon="lucide.plus" class="btn-success btn-sm" wire:click="tambahLagi" spinner />
        <x-button label="Tambah" icon="lucide.circle-fading-plus" class="btn-primary btn-sm" wire:click="tambahDanKembali" spinner />
      </x-slot:actions>
    </x-form>
  </div>
</div>
