@props(['message' => 'Loading...', 'subtitle' => 'Please wait...', 'size' => 'default'])

@php
    $sizeClasses = [
        'small' => 'w-8 h-8 border-2',
        'default' => 'w-12 h-12 border-3',
        'large' => 'w-16 h-16 border-4',
        'xl' => 'w-20 h-20 border-4'
    ];
    
    $textSizes = [
        'small' => 'text-sm',
        'default' => 'text-base',
        'large' => 'text-lg',
        'xl' => 'text-xl'
    ];
    
    $subtitleSizes = [
        'small' => 'text-xs',
        'default' => 'text-sm',
        'large' => 'text-base',
        'xl' => 'text-lg'
    ];
@endphp

<div class="flex flex-col items-center justify-center p-6">
    <div class="loading-spinner {{ $sizeClasses[$size] }} border-gray-300 border-t-blue-600 rounded-full animate-spin"></div>
    
    @if($message)
        <div class="mt-4 text-center">
            <div class="font-semibold text-gray-700 {{ $textSizes[$size] }}">{{ $message }}</div>
            @if($subtitle)
                <div class="text-gray-500 {{ $subtitleSizes[$size] }} mt-1">{{ $subtitle }}</div>
            @endif
        </div>
    @endif
</div>

<style>
    .loading-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
