<?php

use function Laravel\Folio\name;
 
name('admin.maintenance');

?>

<x-app-layout :title="__('Halaman Maintenance') ">
  <div>
    <livewire:maintenance />
  </div>
</x-app-layout>
