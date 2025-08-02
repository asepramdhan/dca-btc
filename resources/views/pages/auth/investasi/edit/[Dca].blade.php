<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Edit Investasi')">
  <div>
    <livewire:edit-investasi :dca="$dca" />
  </div>
</x-app-layout>
