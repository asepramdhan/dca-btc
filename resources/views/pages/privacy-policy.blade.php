<?php

use function Laravel\Folio\name;
 
name('privacy-policy');

?>

<x-app-layout :title="__('Kebijakan Privasi')">
  <div class="container mx-auto px-4 py-12 md:py-20 max-w-4xl">
    <h1 class="text-4xl md:text-5xl font-bold text-primary mb-8 text-center">Kebijakan Privasi</h1>
    <p class="text-lg dark:text-gray-200 text-gray-700 mb-6 text-center">
      Terakhir Diperbarui: 11 Agustus 2025
    </p>
    <p class="text-lg dark:text-gray-200 text-gray-700 mb-8">
      {{ config('app.name') }} berkomitmen untuk melindungi privasi data pribadi pengguna kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi Anda saat Anda menggunakan website kami untuk mencatat data keuangan dan investasi Bitcoin Anda.
    </p>

    <div class="space-y-8">
      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="database" class="w-6 h-6 mr-2 text-primary"></i> Informasi yang Kami Kumpulkan
        </h2>
        <p class="dark:text-gray-300 text-gray-600 mb-4">Kami mengumpulkan berbagai jenis informasi untuk menyediakan dan meningkatkan layanan kami kepada Anda:</p>
        <ul class="list-disc list-inside dark:text-gray-300 text-gray-600 space-y-2">
          <li>
            **Informasi Akun:** Saat Anda mendaftar, kami mengumpulkan informasi seperti **nama pengguna, alamat email, dan kata sandi yang terenkripsi**.
          </li>
          <li>
            **Data Keuangan Pribadi:** Informasi yang Anda masukkan secara manual untuk pencatatan, termasuk namun tidak terbatas pada:
            <ul class="list-circle list-inside ml-5 mt-2 space-y-1">
              <li>**Catatan Pembelian/Penjualan Bitcoin:** Tanggal, jumlah, harga, dan exchange (Indodax, Pintu, Tokocrypto, dll.) tempat transaksi dilakukan.</li>
              <li>**Catatan Keuangan Umum:** Data terkait Dana Darurat, Dana Harian, dan Jumlah Investasi Anda.</li>
            </ul>
            **Penting:** Kami **TIDAK** meminta atau menyimpan informasi sensitif seperti detail kartu kredit, nomor rekening bank lengkap, atau kunci pribadi (private keys) aset kripto Anda. Kami juga **TIDAK** terhubung langsung ke akun exchange Anda. Semua pencatatan transaksi bersifat manual oleh pengguna.
          </li>
          <li>
            **Data Penggunaan:** Informasi tentang bagaimana Anda mengakses dan menggunakan Layanan kami, seperti alamat IP, jenis browser, halaman yang dikunjungi, waktu kunjungan, dan data diagnostik lainnya.
          </li>
          <li>
            <x-badge value="Masih dalam pengembangan" class="badge-error badge-soft" />
            **Cookie dan Teknologi Pelacakan:** Kami menggunakan cookie dan teknologi pelacakan serupa untuk melacak aktivitas di Layanan kami dan menyimpan informasi tertentu. Anda dapat mengatur browser Anda untuk menolak semua cookie atau memberi tahu ketika cookie dikirim. Namun, jika Anda tidak menerima cookie, Anda mungkin tidak dapat menggunakan sebagian Layanan kami.
          </li>
        </ul>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="wrench" class="w-6 h-6 mr-2 text-primary"></i> Bagaimana Kami Menggunakan Informasi Anda
        </h2>
        <p class="dark:text-gray-300 text-gray-600 mb-4">Kami menggunakan informasi yang kami kumpulkan untuk berbagai tujuan, termasuk:</p>
        <ul class="list-disc list-inside dark:text-gray-300 text-gray-600 space-y-2">
          <li>Untuk menyediakan dan memelihara Layanan kami (misalnya, menampilkan portofolio dan grafik Anda).</li>
          <li>Untuk mengelola akun Anda dan memberikan dukungan pengguna.</li>
          <li>Untuk mempersonalisasi pengalaman Anda (misalnya, menyimpan preferensi Anda).</li>
          <li>Untuk menganalisis penggunaan Layanan kami dan meningkatkan fungsionalitasnya.</li>
          <li>Untuk memantau penggunaan Layanan kami dan mendeteksi masalah teknis.</li>
          <li>Untuk berkomunikasi dengan Anda (misalnya, pembaruan layanan, pemberitahuan penting).</li>
          <li>Untuk mematuhi kewajiban hukum atau permintaan dari otoritas berwenang.</li>
        </ul>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="share-2" class="w-6 h-6 mr-2 text-primary"></i> Pengungkapan Informasi Anda
        </h2>
        <p class="dark:text-gray-300 text-gray-600 mb-4">Kami tidak menjual, memperdagangkan, atau menyewakan informasi pribadi Anda kepada pihak ketiga. Kami dapat mengungkapkan informasi Anda hanya dalam situasi berikut:</p>
        <ul class="list-disc list-inside dark:text-gray-300 text-gray-600 space-y-2">
          <li>
            **Dengan Persetujuan Anda:** Jika Anda memberikan persetujuan eksplisit.
          </li>
          <li>
            **Penyedia Layanan Pihak Ketiga:** Kami dapat mempekerjakan perusahaan atau individu pihak ketiga untuk memfasilitasi Layanan kami (misalnya, penyedia hosting, layanan analitik). Pihak ketiga ini memiliki akses ke informasi pribadi Anda hanya untuk melakukan tugas-tugas ini atas nama kami dan berkewajiban untuk tidak mengungkapkan atau menggunakannya untuk tujuan lain.
          </li>
          <li>
            **Kewajiban Hukum:** Jika diwajibkan oleh hukum atau menanggapi permintaan yang sah dari otoritas publik (misalnya, perintah pengadilan atau permintaan pemerintah).
          </li>
          <li>
            **Perlindungan Hak:** Untuk melindungi dan mempertahankan hak atau properti {{ config('app.name') }}, mencegah atau menyelidiki kemungkinan kesalahan terkait Layanan, melindungi keamanan pribadi pengguna Layanan atau publik, atau melindungi dari tanggung jawab hukum.
          </li>
        </ul>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="shield-check" class="w-6 h-6 mr-2 text-primary"></i> Keamanan Data
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Keamanan data Anda sangat penting bagi kami. Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang wajar untuk melindungi informasi pribadi Anda dari akses tidak sah, pengungkapan, perubahan, atau penghancuran. Namun, perlu diingat bahwa tidak ada metode transmisi melalui internet, atau metode penyimpanan elektronik yang 100% aman. Meskipun kami berusaha untuk menggunakan cara yang dapat diterima secara komersial untuk melindungi Informasi Pribadi Anda, kami tidak dapat menjamin keamanan mutlaknya.
        </p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="user" class="w-6 h-6 mr-2 text-primary"></i> Hak-hak Anda
        </h2>
        <p class="dark:text-gray-300 text-gray-600 mb-4">Anda memiliki hak-hak tertentu terkait dengan informasi pribadi Anda:</p>
        <ul class="list-disc list-inside dark:text-gray-300 text-gray-600 space-y-2">
          <li>
            **Akses dan Koreksi:** Anda dapat mengakses dan memperbarui informasi akun Anda kapan saja melalui dashboard pengguna Anda.
          </li>
          <li>
            **Penghapusan Data:** Anda dapat meminta penghapusan data pribadi Anda, tunduk pada kewajiban hukum kami untuk menyimpan catatan tertentu.
          </li>
          <li>
            **Keberatan terhadap Pemrosesan:** Anda dapat mengajukan keberatan terhadap pemrosesan data pribadi Anda dalam kondisi tertentu.
          </li>
        </ul>
        <p class="dark:text-gray-300 text-gray-600 mt-4">Untuk menggunakan hak-hak ini, silakan hubungi kami melalui saluran kontak yang tersedia di website.</p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="link" class="w-6 h-6 mr-2 text-primary"></i> Tautan ke Situs Lain
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Layanan kami mungkin berisi tautan ke situs lain yang tidak dioperasikan oleh kami. Jika Anda mengeklik tautan pihak ketiga, Anda akan diarahkan ke situs pihak ketiga tersebut. Kami sangat menyarankan Anda untuk meninjau Kebijakan Privasi setiap situs yang Anda kunjungi. Kami tidak memiliki kendali dan tidak bertanggung jawab atas konten, kebijakan privasi, atau praktik situs atau layanan pihak ketiga mana pun.
        </p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="info" class="w-6 h-6 mr-2 text-primary"></i> Perubahan pada Kebijakan Privasi Ini
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Kami dapat memperbarui Kebijakan Privasi kami dari waktu ke waktu. Kami akan memberi tahu Anda tentang setiap perubahan dengan memposting Kebijakan Privasi baru di halaman ini. Kami akan memperbarui tanggal "Terakhir Diperbarui" di bagian atas Kebijakan Privasi ini. Anda disarankan untuk meninjau Kebijakan Privasi ini secara berkala untuk setiap perubahan. Perubahan pada Kebijakan Privasi ini efektif ketika diposting di halaman ini.
        </p>
      </div>

      <div class="bg-base-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-secondary mb-3 flex items-center">
          <i data-lucide="mail" class="w-6 h-6 mr-2 text-primary"></i> Hubungi Kami
        </h2>
        <p class="dark:text-gray-300 text-gray-600">
          Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami:
        </p>
        <ul class="list-disc list-inside dark:text-gray-300 text-gray-600 space-y-1 mt-2">
          <li>Melalui email: [-]</li>
          <li>Melalui fitur chat di website (untuk pengguna yang login).</li>
        </ul>
      </div>
    </div>
  </div>
</x-app-layout>
