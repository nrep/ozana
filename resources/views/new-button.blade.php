@aware(['component'])

@php
$theme = $component->getTheme();
@endphp

@if ($theme === 'bootstrap-4' || $theme === 'bootstrap-5')
    <button class="btn btn-gray-800 ml-3" style="margin-left: 10px;" onclick="location.assign('{{ route($link) }}')">
        <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        @if (isset($title))
            {{ $title }}
        @else
            New
        @endif
    </button>
@endif
