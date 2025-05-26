@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex items-center px-3 py-2 rounded transition
          {{ $isActive ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-blue-100' }}">
    <span class="text-xl">{{ $icon }}</span>
    <span class="ml-3" x-show="$store.sidebar.sidebarOpen" x-transition>{{ $label }}</span>
</a>
