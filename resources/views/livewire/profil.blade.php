<div>
  <!-- Tabel data user -->
  <x-table :headers="$headers" :rows="$users" striped>
    <!-- Kolom nomor urut -->
    @scope('cell_id', $user)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Kolom nama lengkap -->
    @scope('cell_name', $user)
    {{ Str::title($user->name) }}
    @endscope

    <!-- Kolom tanggal daftar -->
    @scope('cell_created_at', $user)
    {{ $user->created_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom terakhir diubah -->
    @scope('cell_updated_at', $user)
    {{ $user->updated_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom aksi (edit profil) -->
    @scope('actions', $user)
    <div class="gap-1 flex">
      <x-button icon="lucide.edit" link="/auth/profil/edit/{{ $user->username }}" class="btn-sm" />
    </div>
    @endscope

    <!-- Tampilkan pesan jika data kosong -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>
</div>
