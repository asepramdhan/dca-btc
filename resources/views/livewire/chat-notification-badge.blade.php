<div wire:poll.60s="getUnreadCount">
  @if ($unreadCount > 0)
  <x-badge value="{{ $unreadCount > 99 ? '99+' : $unreadCount }}" class="badge-secondary badge-xs indicator-item" />
  @endif
</div>
