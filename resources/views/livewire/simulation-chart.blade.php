<div class="my-10 space-y-6">

  <div class="lg:flex lg:w-full lg:gap-4 lg:justify-between">
    <div class="mb-4">
      <x-input label="Nominal Investasi (bulan)" wire:model="nominal" money inline />
    </div>
    <div class="mb-4">
      <x-input label="Durasi (Bulan)" type="number" wire:model="durasi" inline />
    </div>
    {{-- Ini adalah input untuk rata-rata harga beli yang Anda inginkan --}}
    <div class="mb-4">
      <x-input label="Rata-rata Beli" wire:model="rataRataHargaBeliInput" money inline />
    </div>
    <div class="mb-4">
      <x-input label="Harga Bitcoin" wire:model="hargaBtc" money inline />
    </div>
    <div class="mb-4">
      <x-button label="Hitung" icon="lucide.calculator" class="btn-primary w-full" wire:click="updateChart" spinner />
    </div>
  </div>

  <div class="overflow-auto">
    <div class="min-w-[600px] sm:min-w-full h-[300px] sm:h-[400px] md:h-[500px]">
      <x-chart wire:model="simulasiChart" class="h-full" />
    </div>
  </div>
</div>
