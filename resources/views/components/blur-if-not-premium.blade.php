<div>
  @props(['link' => '###'])

  @php
  $isPremium = auth()->user()?->premium_until;
  @endphp

  @if ($isPremium)
  <div {{ $attributes }}>
    {{ $slot }}
  </div>
  @else
  <div class="relative group w-fit h-fit" {{ $attributes }}>
    <div class="blur-[2px] opacity-60 select-none pointer-events-none">
      {{ $slot }}
    </div>

    <a href="{{ route('dashboard') }}" wire:navigate class="absolute inset-0 flex items-center justify-center
             opacity-0 group-hover:opacity-100 transition-opacity duration-200
             bg-white/70 dark:bg-neutral-800/70
             text-emerald-600 underline text-sm font-semibold rounded">
      Upgrade
    </a>
  </div>
  @endif
</div>
