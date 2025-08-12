<?php

use function Laravel\Folio\name;
 
name('disclaimer');

?>

<x-app-layout :title="__('Pernyataan Batasan Tanggung Jawab (Disclaimer)')">
  <div class="container mx-auto px-4 py-12 md:py-20 max-w-4xl">
    <h1 class="text-4xl md:text-5xl font-bold text-primary mb-8 text-center">Pernyataan Batasan Tanggung Jawab (Disclaimer)</h1>
    <p class="text-lg dark:text-gray-200 text-gray-700 mb-6 text-center">
      Penting: Harap baca disclaimer ini dengan seksama sebelum menggunakan layanan {{ config('app.name') }}. Dengan mengakses dan menggunakan website ini, Anda dianggap telah memahami dan menyetujui seluruh ketentuan yang tercantum di bawah.
    </p>

    <div class="space-y-8">
      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="info" class="w-6 h-6 mr-2 text-primary"></i> Bukan Nasihat Keuangan atau Saran Investasi
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Website {{ config('app.name') }} ("Layanan") disediakan semata-mata sebagai alat bantu pribadi untuk mencatat dan memvisualisasikan portofolio Bitcoin serta keuangan pribadi Anda. **Layanan ini bukanlah platform trading, broker, penasihat keuangan, atau penyedia saran investasi dalam bentuk apa pun.** Semua informasi yang tersedia di situs ini, termasuk grafik simulasi, data harga real-time, atau data pencatatan, hanyalah untuk tujuan informasi dan pencatatan pribadi. Informasi tersebut tidak boleh diinterpretasikan sebagai rekomendasi untuk membeli, menjual, atau menyimpan aset kripto apa pun.
        </p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="alert-triangle" class="w-6 h-6 mr-2 text-primary"></i> Risiko Investasi Bitcoin
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Investasi dalam aset kripto, termasuk Bitcoin, memiliki risiko yang sangat tinggi. Harga Bitcoin sangat fluktuatif dan dapat mengalami perubahan nilai yang drastis dalam waktu singkat. Ada kemungkinan besar Anda dapat kehilangan sebagian atau seluruh modal yang Anda investasikan. Pastikan Anda telah memahami sepenuhnya semua risiko yang terkait sebelum membuat keputusan investasi. {{ config('app.name') }} tidak bertanggung jawab atas kerugian finansial yang mungkin Anda alami.
        </p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="gavel" class="w-6 h-6 mr-2 text-primary"></i> Tanggung Jawab Pengguna
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Semua keputusan investasi, pembelian, penjualan, atau tindakan lain yang terkait dengan aset kripto adalah tanggung jawab penuh Anda sebagai pengguna. Anda bertanggung jawab atas semua transaksi yang Anda lakukan di platform exchange pihak ketiga (seperti Indodax, Pintu, Tokocrypto, atau lainnya). {{ config('app.name') }} hanya berfungsi sebagai alat pencatat transaksi yang Anda input secara manual ke dalam sistem kami. Kami tidak memiliki akses ke akun exchange Anda dan tidak dapat melakukan transaksi atas nama Anda.
        </p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="trending-up" class="w-6 h-6 mr-2 text-primary"></i> Akurasi Data dan Simulasi
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Kami berusaha untuk menampilkan data harga Bitcoin real-time seakurat mungkin. Namun, kami tidak menjamin bahwa data tersebut selalu 100% akurat, terkini, atau bebas dari kesalahan. Harga yang ditampilkan bersifat indikatif dan mungkin ada penundaan. Simulasi investasi yang disediakan juga bersifat ilustratif dan bukan jaminan hasil investasi di masa depan. Hasil aktual dapat sangat bervariasi.
        </p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="lock" class="w-6 h-6 mr-2 text-primary"></i> Privasi dan Keamanan Data
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Kami sangat memprioritaskan privasi dan keamanan data pribadi serta keuangan yang Anda catatkan di platform kami. Untuk informasi lebih lanjut mengenai bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi data Anda, silakan kunjungi halaman <a href="/privacy-policy" wire:navigate class="text-primary hover:underline font-semibold">Kebijakan Privasi</a> kami.
        </p>
      </div>

      <p class="text-lg dark:text-gray-200 text-gray-700 mt-8 text-center font-semibold">
        Dengan melanjutkan penggunaan layanan {{ config('app.name') }}, Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui seluruh ketentuan dalam disclaimer ini.
      </p>
    </div>
  </div>
</x-app-layout>
