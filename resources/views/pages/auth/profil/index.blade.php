<?php

use function Laravel\Folio\name;
 
name('profil');

?>

<x-app-layout :title="__('Halaman Profil')">
  <div>
    <livewire:profil />
  </div>
</x-app-layout>
