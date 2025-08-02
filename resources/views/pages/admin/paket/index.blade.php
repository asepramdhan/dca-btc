<?php

use function Laravel\Folio\name;
 
name('admin.paket');

?>

<x-app-layout :title="__('Halaman Paket') ">
  <div>
    <livewire:paket />
  </div>
</x-app-layout>
