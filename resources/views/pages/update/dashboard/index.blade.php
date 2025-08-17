<?php
 
use function Laravel\Folio\{middleware};
 
middleware(['auth', 'verified']);
 
?>
<x-layouts.update.app :title="__('Dashboard')">
  <livewire:update.dashboard.index />
</x-layouts.update.app>
