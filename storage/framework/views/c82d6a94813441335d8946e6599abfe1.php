
<div class="accessibility-features" style="position: fixed; top: 10px; right: 10px; z-index: 9999;">
    <div class="accessibility-toolbar bg-white shadow-lg rounded-lg p-2 border">
        <div class="flex items-center space-x-2">
            
            <button id="high-contrast-toggle" 
                    class="p-2 rounded hover:bg-gray-100 transition-colors"
                    title="Toggle High Contrast"
                    aria-label="Toggle High Contrast Mode">
                <i class="fas fa-adjust text-gray-600"></i>
            </button>

            
            <div class="flex items-center space-x-1">
                <button id="font-decrease" 
                        class="p-1 rounded hover:bg-gray-100 transition-colors"
                        title="Decrease Font Size"
                        aria-label="Decrease Font Size">
                    <i class="fas fa-minus text-gray-600 text-sm"></i>
                </button>
                <span id="font-size-indicator" class="text-xs text-gray-500 px-2">100%</span>
                <button id="font-increase" 
                        class="p-1 rounded hover:bg-gray-100 transition-colors"
                        title="Increase Font Size"
                        aria-label="Increase Font Size">
                    <i class="fas fa-plus text-gray-600 text-sm"></i>
                </button>
            </div>

            
            <div id="screen-reader-announcements" 
                 class="sr-only" 
                 aria-live="polite" 
                 aria-atomic="true">
            </div>

            
            <button id="keyboard-help" 
                    class="p-2 rounded hover:bg-gray-100 transition-colors"
                    title="Keyboard Navigation Help"
                    aria-label="Show Keyboard Navigation Help">
                <i class="fas fa-keyboard text-gray-600"></i>
            </button>

            
            <button id="focus-indicator-toggle" 
                    class="p-2 rounded hover:bg-gray-100 transition-colors"
                    title="Toggle Focus Indicators"
                    aria-label="Toggle Enhanced Focus Indicators">
                <i class="fas fa-crosshairs text-gray-600"></i>
            </button>
        </div>
    </div>
</div>


<style>
/* High Contrast Mode */
.high-contrast {
    filter: contrast(150%) brightness(120%);
}

.high-contrast * {
    background-color: #000 !important;
    color: #fff !important;
    border-color: #fff !important;
}

.high-contrast button,
.high-contrast input,
.high-contrast select,
.high-contrast textarea {
    background-color: #000 !important;
    color: #fff !important;
    border: 2px solid #fff !important;
}

.high-contrast a {
    color: #ffff00 !important;
    text-decoration: underline !important;
}

/* Enhanced Focus Indicators */
.enhanced-focus *:focus {
    outline: 3px solid #0066cc !important;
    outline-offset: 2px !important;
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.3) !important;
}

.enhanced-focus button:focus,
.enhanced-focus input:focus,
.enhanced-focus select:focus,
.enhanced-focus textarea:focus {
    outline: 3px solid #0066cc !important;
    outline-offset: 2px !important;
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.3) !important;
}

/* Screen Reader Only Content */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Skip Links */
.skip-link {
    position: absolute;
    top: -40px;
    left: 6px;
    background: #000;
    color: #fff;
    padding: 8px;
    text-decoration: none;
    z-index: 10000;
}

.skip-link:focus {
    top: 6px;
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}

/* Large Text Mode */
.large-text {
    font-size: 1.2em !important;
}

.large-text h1 { font-size: 2.5em !important; }
.large-text h2 { font-size: 2em !important; }
.large-text h3 { font-size: 1.75em !important; }
.large-text h4 { font-size: 1.5em !important; }
.large-text h5 { font-size: 1.25em !important; }
.large-text h6 { font-size: 1.1em !important; }
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // High Contrast Toggle
    const highContrastToggle = document.getElementById('high-contrast-toggle');
    const body = document.body;
    
    highContrastToggle.addEventListener('click', function() {
        body.classList.toggle('high-contrast');
        const isEnabled = body.classList.contains('high-contrast');
        announceToScreenReader(isEnabled ? 'High contrast mode enabled' : 'High contrast mode disabled');
        localStorage.setItem('highContrast', isEnabled);
    });

    // Font Size Controls
    const fontDecrease = document.getElementById('font-decrease');
    const fontIncrease = document.getElementById('font-increase');
    const fontSizeIndicator = document.getElementById('font-size-indicator');
    
    let currentFontSize = parseInt(localStorage.getItem('fontSize')) || 100;
    updateFontSize();

    fontDecrease.addEventListener('click', function() {
        if (currentFontSize > 80) {
            currentFontSize -= 10;
            updateFontSize();
            announceToScreenReader(`Font size decreased to ${currentFontSize}%`);
        }
    });

    fontIncrease.addEventListener('click', function() {
        if (currentFontSize < 150) {
            currentFontSize += 10;
            updateFontSize();
            announceToScreenReader(`Font size increased to ${currentFontSize}%`);
        }
    });

    function updateFontSize() {
        body.style.fontSize = currentFontSize + '%';
        fontSizeIndicator.textContent = currentFontSize + '%';
        localStorage.setItem('fontSize', currentFontSize);
        
        if (currentFontSize >= 120) {
            body.classList.add('large-text');
        } else {
            body.classList.remove('large-text');
        }
    }

    // Focus Indicator Toggle
    const focusIndicatorToggle = document.getElementById('focus-indicator-toggle');
    
    focusIndicatorToggle.addEventListener('click', function() {
        body.classList.toggle('enhanced-focus');
        const isEnabled = body.classList.contains('enhanced-focus');
        announceToScreenReader(isEnabled ? 'Enhanced focus indicators enabled' : 'Enhanced focus indicators disabled');
        localStorage.setItem('enhancedFocus', isEnabled);
    });

    // Keyboard Help
    const keyboardHelp = document.getElementById('keyboard-help');
    
    keyboardHelp.addEventListener('click', function() {
        showKeyboardHelp();
    });

    // Screen Reader Announcements
    function announceToScreenReader(message) {
        const announcements = document.getElementById('screen-reader-announcements');
        announcements.textContent = message;
        setTimeout(() => {
            announcements.textContent = '';
        }, 1000);
    }

    // Keyboard Help Modal
    function showKeyboardHelp() {
        const helpContent = `
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
                    <h2 class="text-2xl font-bold mb-4">Keyboard Navigation Help</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span><strong>Tab</strong></span>
                            <span>Move to next interactive element</span>
                        </div>
                        <div class="flex justify-between">
                            <span><strong>Shift + Tab</strong></span>
                            <span>Move to previous interactive element</span>
                        </div>
                        <div class="flex justify-between">
                            <span><strong>Enter</strong></span>
                            <span>Activate buttons and links</span>
                        </div>
                        <div class="flex justify-between">
                            <span><strong>Space</strong></span>
                            <span>Activate buttons and checkboxes</span>
                        </div>
                        <div class="flex justify-between">
                            <span><strong>Escape</strong></span>
                            <span>Close modals and menus</span>
                        </div>
                        <div class="flex justify-between">
                            <span><strong>Alt + 1</strong></span>
                            <span>Go to main content</span>
                        </div>
                        <div class="flex justify-between">
                            <span><strong>Alt + 2</strong></span>
                            <span>Go to navigation</span>
                        </div>
                    </div>
                    <button onclick="this.closest('.fixed').remove()" 
                            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Close
                    </button>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', helpContent);
        announceToScreenReader('Keyboard help opened');
    }

    // Load saved preferences
    if (localStorage.getItem('highContrast') === 'true') {
        body.classList.add('high-contrast');
    }
    
    if (localStorage.getItem('enhancedFocus') === 'true') {
        body.classList.add('enhanced-focus');
    }

    // Skip Links
    const skipLinks = `
        <a href="#main-content" class="skip-link">Skip to main content</a>
        <a href="#navigation" class="skip-link">Skip to navigation</a>
    `;
    document.body.insertAdjacentHTML('afterbegin', skipLinks);

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Alt + 1: Go to main content
        if (e.altKey && e.key === '1') {
            e.preventDefault();
            const mainContent = document.getElementById('main-content');
            if (mainContent) {
                mainContent.focus();
                announceToScreenReader('Moved to main content');
            }
        }
        
        // Alt + 2: Go to navigation
        if (e.altKey && e.key === '2') {
            e.preventDefault();
            const navigation = document.getElementById('navigation');
            if (navigation) {
                navigation.focus();
                announceToScreenReader('Moved to navigation');
            }
        }
    });

    // Announce page changes
    announceToScreenReader('Page loaded successfully');
});
</script>
<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\accessibility-features.blade.php ENDPATH**/ ?>