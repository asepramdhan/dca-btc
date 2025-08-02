<?php

use function Laravel\Folio\name;
 
name('voucher');

?>

<x-app-layout :title="__('Halaman Voucher')">
  <div>
    <livewire:voucher />
  </div>
</x-app-layout>
