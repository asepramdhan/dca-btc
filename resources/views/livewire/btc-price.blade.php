<div wire:poll.300s='updateBitcoinPrice'>
  <span class="text-sm font-semibold">BTC-IDR : </span>
  <span class="font-semibold text-yellow-500">
    @if (auth()->user()->premium_until)
    @if ($bitcoinIdr)
    {{ number_format($bitcoinIdr, 0, ',', '.') }}
    @else
    <span class="animate-pulse text-gray-400">Loading...</span>
    @endif
    @else
    <span class="group relative">
      <span class="blur-sm">
        @if ($bitcoinIdr)
        {{ number_format($bitcoinIdr, 0, ',', '.') }}
        @else
        <span class="animate-pulse text-gray-400">Loading...</span>
        @endif
      </span>
      <a href="###" class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 text-blue-500 underline text-sm">Upgrade</a>
    </span>
    @endif
  </span>
</div>
