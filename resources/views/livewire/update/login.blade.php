<?php

use Livewire\Volt\Component;

new class extends Component {
    public function login(): void
    {
        $this->redirect('/update/dashboard');
    }
}; ?>

<div>
  <main class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8" style="background-color: #0F172A;">
    <div class="w-full max-w-md space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
          Login ke Akun Anda
        </h2>
        <p class="mt-2 text-center text-sm text-slate-400">
          Atau <a href="/update/register" wire:navigate class="font-medium text-sky-400 hover:text-sky-500">buat akun baru</a> jika Anda belum terdaftar.
        </p>
      </div>
      <form class="mt-8 space-y-6" wire:submit.prevent="login">
        <div class="rounded-md shadow-sm -space-y-px">
          <div class="mb-6">
            <label for="email-address" class="sr-only">Alamat Email</label>
            <input id="email-address" wire:model="email" type="email" autocomplete="email" required class="form-input rounded-t-md" placeholder="Alamat Email">
          </div>
          <div>
            <label for="password" class="sr-only">Kata Sandi</label>
            <input id="password" wire:model="password" type="password" autocomplete="current-password" required class="form-input rounded-b-md" placeholder="Kata Sandi">
          </div>
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-600 bg-slate-700 rounded">
            <label for="remember-me" class="ml-2 block text-sm text-slate-300">
              Ingat saya
            </label>
          </div>

          <div class="text-sm">
            <a href="/update/forgot-password" wire:navigate class="font-medium text-sky-400 hover:text-sky-500">
              Lupa kata sandi?
            </a>
          </div>
        </div>

        <div>
          <button type="submit" wire:loading.attr="disabled" wire:target="login" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-sky-500 cursor-pointer">
            <x-loading wire:loading wire:target="login" class="loading-dots" />
            <span wire:loading.remove wire:target="login">
              Login
            </span>
          </button>
        </div>
      </form>
    </div>
  </main>
</div>
