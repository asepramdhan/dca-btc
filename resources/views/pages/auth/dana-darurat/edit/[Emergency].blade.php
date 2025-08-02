<?php

use function Laravel\Folio\name;
 
// name('edit-dana-darurat');

?>

<x-app-layout :title="__('Halaman Edit Dana Darurat')">
  <div>
    <livewire:edit-dana-darurat :emergency="$emergency" />
  </div>
</x-app-layout>
