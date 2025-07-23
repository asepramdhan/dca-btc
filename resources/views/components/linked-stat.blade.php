<div>
  @props([
  'link' => '#',
  'title',
  'description' => null,
  'value',
  'icon' => null,
  'color' => null,
  'class' => '',
  ])

  <a href="{{ $link }}" wire:navigate class="block">
    <x-stat :title="$title" :value="$value" :icon="$icon" :color="$color" class="{{ $class }}" {{ $attributes }}>
      {{-- Kirim slot ke dalam x-stat --}}
      @if ($description)
      <x-slot:description>
        {{ $description }}
      </x-slot:description>
      @endif

      {{-- Tambahkan juga slot umum jika diperlukan --}}
      {{ $slot }}
    </x-stat>
  </a>
</div>
