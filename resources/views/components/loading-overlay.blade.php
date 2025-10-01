@props(['id' => 'loadingOverlay', 'message' => 'Loading...', 'subtitle' => 'Please wait...', 'show' => false])

<div id="{{ $id }}" class="loading-overlay {{ $show ? '' : 'hidden' }}" style="display: {{ $show ? 'flex' : 'none' }};">
    <div class="loading-spinner"></div>
    <div class="loading-text">{{ $message }}</div>
    <div class="loading-subtitle">{{ $subtitle }}</div>
</div>

<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 1;
        visibility: visible;
    }

    .loading-overlay.hidden {
        opacity: 0;
        visibility: hidden;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .loading-text {
        margin-top: 20px;
        font-size: 18px;
        font-weight: 600;
        color: #374151;
        text-align: center;
    }

    .loading-subtitle {
        margin-top: 8px;
        font-size: 14px;
        color: #6b7280;
        text-align: center;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    // Global loading functions
    window.showLoading = function(message = 'Loading...', subtitle = 'Please wait...', overlayId = '{{ $id }}') {
        const overlay = document.getElementById(overlayId);
        if (overlay) {
            const loadingText = overlay.querySelector('.loading-text');
            const loadingSubtitle = overlay.querySelector('.loading-subtitle');
            
            if (message && loadingText) loadingText.textContent = message;
            if (subtitle && loadingSubtitle) loadingSubtitle.textContent = subtitle;
            
            overlay.classList.remove('hidden');
            overlay.style.display = 'flex';
        }
    };

    window.hideLoading = function(overlayId = '{{ $id }}') {
        const overlay = document.getElementById(overlayId);
        if (overlay) {
            overlay.classList.add('hidden');
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
        }
    };
</script>
