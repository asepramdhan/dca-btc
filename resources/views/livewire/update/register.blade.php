<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
  <main class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8" style="background-color: #0F172A;">
    <div class="w-full max-w-md space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
          Buat Akun Baru Anda
        </h2>
        <p class="mt-2 text-center text-sm text-slate-400">
          Atau <a href="/update/login" wire:navigate class="font-medium text-sky-400 hover:text-sky-500">login</a> jika Anda sudah punya akun.
        </p>
      </div>
      <form class="mt-8 space-y-6" wire:submit.prevent="register">
        <div class="rounded-md shadow-sm -space-y-px">
          <div class="mb-6">
            <label for="full-name" class="sr-only">Nama Lengkap</label>
            <input id="full-name" wire:model="name" type="text" autocomplete="name" required class="form-input rounded-t-md" placeholder="Nama Lengkap">
          </div>
          <div class="mb-6">
            <label for="email-address" class="sr-only">Alamat Email</label>
            <input id="email-address" wire:model="email" type="email" autocomplete="email" required class="form-input" placeholder="Alamat Email">
          </div>
          <div class="mb-6">
            <label for="password" class="sr-only">Kata Sandi</label>
            <input id="password" wire:model="password" type="password" autocomplete="new-password" required class="form-input" placeholder="Kata Sandi">
          </div>
          <div>
            <label for="password-confirmation" class="sr-only">Konfirmasi Kata Sandi</label>
            <input id="password-confirmation" wire:model="password_confirmation" type="password" autocomplete="new-password" required class="form-input rounded-b-md" placeholder="Konfirmasi Kata Sandi">
          </div>
        </div>

        <div>
          <button type="submit" wire:loading.attr="disabled" wire:target="register" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-sky-500 cursor-pointer">
            <x-loading wire:loading wire:target="register" class="loading-dots" />
            <span wire:loading.remove wire:target="register">
              Daftar Akun
            </span>
          </button>
        </div>
      </form>
    </div>
  </main>
</div>
