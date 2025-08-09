<div>
  <div>
    User All Chat
    @foreach ($users as $user)
    <x-list-item :item="$user" class="cursor-pointer {{ $selectedUser->id === $user->id ? 'text-primary' : '' }}" wire:click='selectUser({{ $user->id }})' />
    @endforeach
  </div>
  <div>
    User Message : {{ $selectedUser->name }}
    <div>
      @foreach ($messages as $message)
      <div class="flex items-center {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
        <div class="px-4 py-2 rounded-md shadow-sm my-2 {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-secondary text-primary' }}">
          {{ $message->message }}
        </div>
      </div>
      @endforeach
    </div>
    <div>
      <x-form wire:submit='send'>
        <x-input wire:model='newMessage' />
        <x-button type='submit'>Send</x-button>
      </x-form>
    </div>
  </div>
</div>
