<?php

use function Laravel\Folio\name;
 
// name('edit-dana-darurat');

?>

<x-app-layout>
  <div>
    <livewire:edit-dana-darurat :emergency="$emergency" />
  </div>
</x-app-layout>
