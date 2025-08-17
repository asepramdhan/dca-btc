<?php
 
use function Laravel\Folio\{middleware};
 
middleware(['guest']);
 
?>
<x-layouts.update.app-home :title="__('Masuk')">
  <livewire:update.login />
</x-layouts.update.app-home>
