<div>
  @php
  $isPremium = auth()->user()?->premium_until;
  @endphp
  <div wire:poll.300s='updateBitcoinPrice' class="flex items-center gap-1">
    <span class="text-sm font-semibold">BTC-IDR : </span>
    <!-- premium user: tampil normal -->
    @if ($isPremium)
    <span class="font-semibold text-slate-600">
      {{ number_format($bitcoinIdr, 0, ',', '.') }}
    </span>
    @else
    <!-- Non premium user: tampil blur -->
    <div class="relative group">
      <span class="font-semibold text-slate-600 blur-xs lg:group-hover:blur-sm lg:transition lg:duration-300">
        {{ number_format($bitcoinIdr, 0, ',', '.') }}
      </span>
      <!-- Tombol muncul saat hover -->
      <x-button label="Upgrade" class="btn-primary btn-sm btn-soft absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 lg:opacity-0 lg:group-hover:opacity-100 lg:transition lg:duration-300" link="/auth/upgrade" no-wire-navigate />
    </div>
    @endif
  </div>
</div>
