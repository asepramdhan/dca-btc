<div>
  <h2 class="text-xl font-bold text-center text-gray-700 mb-6">Pilih Paket Premium</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4 my-4">

    <!-- Langganan 1 Bulan -->
    <x-card shadow separator class="border-2 border-slate-100 lg:transform lg:transition lg:duration-300 lg:ease-in-out 
         lg:hover:scale-105 lg:hover:-translate-y-1 lg:hover:shadow-md">
      <x-slot:title>
        <div class="flex justify-between items-center w-full">
          Premium 1 Bulan
          <x-button icon="lucide.star" class="btn-circle btn-ghost hover:bg-transparent hover:shadow-none hover:border-transparent" />
        </div>
      </x-slot:title>

      <div class="space-y-2 text-sm text-gray-600">
        <p>🔓 Akses penuh semua fitur</p>
        <p>🚫 Tanpa iklan</p>
        <p>📈 Analitik lanjutan</p>
      </div>

      <div class="mt-4 flex justify-between items-center">
        <div>
          <div class="text-lg font-bold text-gray-800">Rp30.000</div>
          <div class="text-sm text-gray-500">per bulan</div>
        </div>
        <x-button label="Upgrade" class="btn-primary" :link="route('pin')" />
      </div>
    </x-card>

    <!-- Langganan 2 Bulan -->
    <x-card shadow separator class="border-2 border-indigo-200 lg:transform lg:transition lg:duration-300 lg:ease-in-out 
         lg:hover:scale-105 lg:hover:-translate-y-1 lg:hover:shadow-lg lg:hover:border-indigo-400 lg:hover:bg-indigo-50">
      <x-slot:title>
        <div class="flex justify-between items-center w-full">
          Premium 2 Bulan
          <x-button icon="lucide.badge-check" class="btn-circle btn-ghost hover:bg-transparent hover:shadow-none hover:border-transparent" />
        </div>
      </x-slot:title>

      <div class="space-y-2 text-sm text-gray-600">
        <p>🔓 Akses penuh semua fitur</p>
        <p>🚫 Tanpa iklan</p>
        <p>🎁 Hemat Rp1.000</p>
      </div>

      <div class="mt-4 flex justify-between items-center">
        <div>
          <div class="text-lg font-bold text-gray-800">Rp59.000</div>
          <div class="text-sm text-gray-500">untuk 2 bulan</div>
        </div>
        <x-button label="Upgrade" class="btn-primary" :link="route('pin')" />
      </div>
    </x-card>

    <!-- Langganan 1 Tahun -->
    <div class="group w-full">
      <x-card shadow separator class="w-full border-2 border-yellow-400 lg:transform lg:transition lg:duration-300 lg:ease-in-out 
           lg:hover:scale-105 lg:hover:-translate-y-1 lg:hover:shadow-2xl lg:hover:bg-yellow-50 lg:hover:border-yellow-500">
        <x-slot:title>
          <div class="flex justify-between items-center w-full">
            Premium 1 Tahun
            <x-button icon="lucide.crown" class="btn-circle btn-ghost text-yellow-500 lg:transition-transform lg:duration-500 lg:group-hover:rotate-6 hover:bg-transparent hover:shadow-none hover:border-transparent" />
          </div>
        </x-slot:title>

        <div class="space-y-2 text-sm text-gray-600">
          <p>🔓 Akses penuh semua fitur</p>
          <p>🚫 Tanpa iklan</p>
          <p>💸 Hemat hingga Rp61.000</p>
          <p>🎉 Prioritas dukungan</p>
        </div>

        <div class="mt-4 flex justify-between items-center">
          <div>
            <div class="text-lg font-bold text-yellow-600">Rp299.000</div>
            <div class="text-sm text-gray-500">untuk 1 tahun</div>
          </div>
          <x-button label="Upgrade" class="btn-warning" :link="route('pin')" />
        </div>
      </x-card>
    </div>

  </div>

  <div class="text-center mt-8 mb-4">
    <p class="text-sm text-gray-500 mb-2">
      Belum ingin upgrade sekarang? Kamu bisa kembali dan lanjutkan aktivitas seperti biasa.
    </p>
    <x-button label="Kembali ke Dashboard" :link="route('dashboard')" class="btn-outline btn-sm" />
  </div>
</div>
