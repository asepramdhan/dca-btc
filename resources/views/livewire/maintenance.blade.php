<div>
  <x-header subtitle="Pengaturan Maintenance Halaman" separator />
  <!-- Loop setiap halaman yang tersedia -->
  @foreach ($availablePages as $page)
  <x-card>
    <div class="flex justify-between items-center">
      <div>
        <p class="font-semibold capitalize">{{ $page }}</p>
        <p class="text-sm text-gray-500">
          Akses halaman <code>{{ $page }}</code>
        </p>
      </div>
      <!-- Toggle untuk mengaktifkan/nonaktifkan maintenance -->
      <x-toggle wire:click="toggle('{{ $page }}')" :checked="($pages[$page] ?? false)" />
    </div>
  </x-card>
  @endforeach
</div>
