<div wire:poll.300s='updateBitcoinPrice'>
  <span class="text-sm font-semibold">BTC-IDR : </span>
  <span class="font-semibold text-yellow-500">
    @if ($bitcoinIdr)
    {{ number_format($bitcoinIdr, 0, ',', '.') }}
    @else
    <span class="animate-pulse text-gray-400">Loading...</span>
    @endif
  </span>
</div>
