@props([
    'id' => 'modal',
    'title' => '',
    'type' => 'default', // default, success, warning, danger, info
    'size' => 'modal-dialog-centered', // modal-sm, modal-lg, modal-xl, modal-dialog-centered
    'closeButton' => true,
    'footer' => true
])

@php
    $typeClasses = [
        'default' => ['header' => 'bg-primary text-white', 'icon' => 'fas fa-info-circle'],
        'success' => ['header' => 'bg-success text-white', 'icon' => 'fas fa-check-circle'],
        'warning' => ['header' => 'bg-warning text-dark', 'icon' => 'fas fa-exclamation-triangle'],
        'danger' => ['header' => 'bg-danger text-white', 'icon' => 'fas fa-exclamation-circle'],
        'info' => ['header' => 'bg-info text-white', 'icon' => 'fas fa-info-circle']
    ];
    
    $currentType = $typeClasses[$type] ?? $typeClasses['default'];
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            <div class="modal-header {{ $currentType['header'] }}">
                <h5 class="modal-title" id="{{ $id }}Label">
                    <i class="{{ $currentType['icon'] }} me-2"></i>{{ $title }}
                </h5>
                @if($closeButton)
                    <button type="button" class="btn-close {{ $type === 'warning' ? '' : 'btn-close-white' }}" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if($footer)
                <div class="modal-footer">
                    {{ $footer ?? '' }}
                </div>
            @endif
        </div>
    </div>
</div> 