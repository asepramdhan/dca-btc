<?php

use function Laravel\Folio\name;
 
// name();

?>

<x-app-layout :title="__('Halaman Edit Profil')">
  <div>
    <livewire:edit-profil :user="$user" />
  </div>
</x-app-layout>
