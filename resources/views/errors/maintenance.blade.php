<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Maintenance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- Import CSS menggunakan Vite --}}
  @vite('resources/css/app.css')
</head>
<body class="bg-base-200 text-center flex items-center justify-center min-h-screen px-4">
  <div class="max-w-md space-y-6">

    {{-- Icon peringatan --}}
    <div class="flex justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
        <line x1="12" y1="9" x2="12" y2="13" />
        <line x1="12" y1="17" x2="12.01" y2="17" />
      </svg>
    </div>

    {{-- Judul Maintenance --}}
    <h1 class="text-3xl font-bold text-warning">Halaman Sedang Maintenance</h1>

    {{-- Pesan penjelasan --}}
    <p class="text-gray-600 text-sm">
      Kami sedang melakukan pemeliharaan untuk meningkatkan kualitas layanan.
      <br>
      Silakan kembali beberapa saat lagi.
    </p>

    {{-- Informasi tambahan --}}
    <div class="bg-white rounded-xl shadow-md p-4 text-left text-sm text-gray-500">
      <p>
        <strong>Perkiraan selesai:</strong> Hari ini jam 23:59 WIB
      </p>
      <p>
        <strong>Kontak:</strong>
        <a href="###" class="text-blue-500 hover:underline">
          {{-- support@dcabitcoin.my.id --}} -
        </a>
      </p>
      <p>
        <strong>Chat Admin:</strong>
        <a href="/auth/user/chat" target="_blank" class="text-blue-500 hover:underline">
          Klik disini
        </a>
      </p>
    </div>

    {{-- Tombol kembali ke halaman depan --}}
    <div>
      <a href="{{ route('dashboard') }}" wire:navigate class="inline-block mt-4 px-4 py-2 bg-warning text-white font-semibold rounded-lg shadow hover:bg-warning/90 transition">
        🔙 Kembali ke Halaman Dashboard
      </a>
    </div>

  </div>
</body>
</html>
