<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Edit Exchange')">
  <div>
    <livewire:edit-exchange :exchange="$exchange" />
  </div>
</x-app-layout>
