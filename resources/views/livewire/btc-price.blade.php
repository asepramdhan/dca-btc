<div wire:poll.300s='updateBitcoinPrice' class="flex items-center gap-1">
  <span class="text-sm font-semibold">BTC-IDR :</span>

  @if ($isStillPremium || $isFreeTrial)
  <!-- Premium & Free Trial User: tampil normal -->
  <span class="font-semibold text-slate-600">
    {{ number_format($bitcoinIdr, 0, ',', '.') }}
  </span>
  @else
  <!-- Free User: tampil blur + tombol upgrade -->
  <div class="relative group">
    <span class="font-semibold text-slate-600 blur-xs lg:group-hover:blur-sm transition duration-300">
      {{ number_format($bitcoinIdr, 0, ',', '.') }}
    </span>
    <x-button label="Upgrade" class="btn-primary btn-sm btn-soft absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition duration-300" link="/auth/upgrade" no-wire-navigate />
  </div>
  @endif
</div>
