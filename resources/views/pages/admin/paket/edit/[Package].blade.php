<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Edit Paket') ">
  <div>
    <livewire:edit-paket :paket="$package" />
  </div>
</x-app-layout>
