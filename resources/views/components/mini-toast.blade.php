<!-- Toast Component -->
<div x-data="{
show: false,
message: '',
type: 'success',
timeout: 2000,
icon: 'lucide.check-circle',

showToast(detail) {
    this.message = detail.title || 'Berhasil';
    this.type = detail.type || 'success';
    this.timeout = detail.timeout || 2000;
    this.icon = detail.icon || 'lucide.check-circle';
    this.show = true;

    setTimeout(() => {
    this.show = false;

    if (detail.redirectTo) {
        if (window.Livewire?.navigate) {
        window.Livewire.navigate(detail.redirectTo);
        } else {
        window.location.href = detail.redirectTo;
        }
    }
    }, this.timeout);
}
}" x-on:custom-toast.window="showToast($event.detail[0])" x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-full" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-max">

  <div :class="{
    'alert alert-success': type === 'success',
    'alert alert-error': type === 'error',
    'alert alert-warning': type === 'warning',
    'alert alert-info': type === 'info',
}" class="shadow-lg flex items-center gap-2">
    <!-- Ikon custom jika diset -->
    <template x-if="icon === 'lucide.check-circle'">
      <x-icon name="lucide.check-circle" class="w-5 h-5" />
    </template>
    <template x-if="icon === 'lucide.x-circle'">
      <x-icon name="lucide.x-circle" class="w-5 h-5" />
    </template>
    <template x-if="icon === 'lucide.alert-triangle'">
      <x-icon name="lucide.alert-triangle" class="w-5 h-5" />
    </template>
    <template x-if="icon === 'lucide.info'">
      <x-icon name="lucide.info" class="w-5 h-5" />
    </template>

    <!-- Pesan -->
    <span x-text="message"></span>
  </div>
</div>
