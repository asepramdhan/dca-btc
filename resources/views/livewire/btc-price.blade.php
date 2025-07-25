<div wire:poll.300s='updateBitcoinPrice' class="flex items-center gap-1">
  <span class="text-sm font-semibold">BTC-IDR : </span>
  <x-blur-if-not-premium class="font-semibold text-slate-600" :link="route('dashboard')">
    {{ number_format($bitcoinIdr, 0, ',', '.') }}
  </x-blur-if-not-premium>
</div>
