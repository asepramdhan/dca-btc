<?php

use function Laravel\Folio\name;
 
name('admin-testing-chat');

?>

<x-app-layout :title="__('Halaman Testing Chat') ">
  <div>
    <x-header title="Testing Chat" subtitle="Untuk pengembangan fitur chat" separator />
    <livewire:testing-chat />
  </div>
</x-app-layout>
