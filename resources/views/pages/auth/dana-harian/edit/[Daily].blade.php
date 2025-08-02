<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Edit Dana Harian')">
  <div>
    <livewire:edit-dana-harian :daily="$daily" />
  </div>
</x-app-layout>
