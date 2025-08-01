<div>
  <x-header title="Daftar Percakapan Admin" subtitle="Kelola semua percakapan dengan pengguna." separator />

  <div class="flex flex-col md:flex-row gap-4">
    <div class="w-full md:w-1/3">
      <!-- Pencarian User untuk Mulai Chat Baru -->
      <x-card title="Mulai Chat Baru" shadow separator class="mb-4">
        <x-input wire:model.live.debounce.300ms="searchUsers" placeholder="Cari user..." icon="o-magnifying-glass" />

        @if (!empty($searchUsers) && strlen($searchUsers) > 2)
        @if ($this->getUsersForNewChatProperty()->count() > 0)
        <div class="mt-4 border rounded-md">
          @foreach ($this->getUsersForNewChatProperty() as $user)
          <div class="p-2 border-b last:border-b-0 flex justify-between items-center">
            <span>{{ $user->name }} ({{ $user->email }})</span>
            <x-button label="Chat" wire:click="startNewChat({{ $user->id }})" class="btn-sm btn-primary" />
          </div>
          @endforeach
        </div>
        @else
        <p class="text-sm text-gray-500 mt-4">Tidak ada user ditemukan.</p>
        @endif
        @endif
      </x-card>
    </div>

    <div class="w-full md:w-2/3">
      <x-card title="Daftar Percakapan Aktif" shadow separator>
        <x-input wire:model.live.debounce.300ms="search" placeholder="Cari percakapan..." icon="o-magnifying-glass" />

        @forelse ($conversations as $conversation)
        <div class="p-4 border-b hover:bg-base-200 cursor-pointer flex justify-between items-center" wire:click="openChat({{ $conversation->id }})">
          <div>
            <p class="font-semibold text-lg">{{ $conversation->user->name }}</p>
            <p class="text-sm text-gray-500">
              {{ Str::limit($conversation->messages->sortByDesc('created_at')->first()->content ?? 'Belum ada pesan', 50) }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
              Terakhir: {{ $conversation->last_message_at?->diffForHumans() ?? 'Belum ada pesan' }}
            </p>
            @if ($conversation->admin_id === null)
            <x-badge value="Belum Ditugaskan" class="badge-warning mt-1 badge-sm" />
            @endif
          </div>
          <!-- Badge untuk pesan belum dibaca -->
          @if ($conversation->messages_count > 0)
          <!-- Ini dari withCount di Livewire -->
          <x-badge value="{{ $conversation->messages_count }}" class="badge-secondary badge-xs" />
          @endif
        </div>
        @empty
        <x-alert title="Tidak Ada Percakapan" description="Belum ada percakapan aktif." icon="o-chat-bubble-bottom-center-text" />
        @endforelse

        <div class="mt-4">
          {{ $conversations->links() }}
        </div>
      </x-card>
    </div>
  </div>
</div>
