
<div id="browser-compatibility-check" class="hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
            <h2 class="text-2xl font-bold mb-4">Browser Compatibility Check</h2>
            <div id="compatibility-results"></div>
            <button onclick="closeCompatibilityCheck()" 
                    class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Continue Anyway
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    checkBrowserCompatibility();
});

function checkBrowserCompatibility() {
    const userAgent = navigator.userAgent;
    const capabilities = detectBrowserCapabilities(userAgent);
    
    if (!capabilities.compatibility.supported) {
        showCompatibilityWarning(capabilities);
    }
}

function detectBrowserCapabilities(userAgent) {
    const browser = detectBrowser(userAgent);
    const version = detectBrowserVersion(userAgent);
    const os = detectOperatingSystem(userAgent);
    const device = detectDevice(userAgent);
    
    const compatibility = checkCompatibility(browser, version);
    
    return {
        browser: browser,
        version: version,
        os: os,
        device: device,
        compatibility: compatibility
    };
}

function detectBrowser(userAgent) {
    if (userAgent.indexOf('Chrome') !== -1) return 'Chrome';
    if (userAgent.indexOf('Firefox') !== -1) return 'Firefox';
    if (userAgent.indexOf('Safari') !== -1) return 'Safari';
    if (userAgent.indexOf('Edge') !== -1) return 'Edge';
    if (userAgent.indexOf('Opera') !== -1) return 'Opera';
    return 'Unknown';
}

function detectBrowserVersion(userAgent) {
    const patterns = {
        'Chrome': /Chrome\/([0-9.]+)/,
        'Firefox': /Firefox\/([0-9.]+)/,
        'Safari': /Version\/([0-9.]+)/,
        'Edge': /Edge\/([0-9.]+)/,
        'Opera': /Opera\/([0-9.]+)/
    };

    for (const [browser, pattern] of Object.entries(patterns)) {
        const match = userAgent.match(pattern);
        if (match) return match[1];
    }
    return 'Unknown';
}

function detectOperatingSystem(userAgent) {
    if (userAgent.indexOf('Windows') !== -1) return 'Windows';
    if (userAgent.indexOf('Mac') !== -1) return 'macOS';
    if (userAgent.indexOf('Linux') !== -1) return 'Linux';
    if (userAgent.indexOf('Android') !== -1) return 'Android';
    if (userAgent.indexOf('iOS') !== -1) return 'iOS';
    return 'Unknown';
}

function detectDevice(userAgent) {
    if (userAgent.indexOf('Mobile') !== -1 || userAgent.indexOf('Android') !== -1) return 'Mobile';
    if (userAgent.indexOf('Tablet') !== -1 || userAgent.indexOf('iPad') !== -1) return 'Tablet';
    return 'Desktop';
}

function checkCompatibility(browser, version) {
    const minVersions = {
        'Chrome': '70.0',
        'Firefox': '65.0',
        'Safari': '12.0',
        'Edge': '79.0',
        'Opera': '57.0'
    };

    const compatibility = {
        supported: true,
        level: 'full',
        warnings: [],
        recommendations: []
    };

    if (minVersions[browser]) {
        if (compareVersions(version, minVersions[browser]) < 0) {
            compatibility.supported = false;
            compatibility.level = 'unsupported';
            compatibility.warnings.push(`Your browser version is outdated. Please update to version ${minVersions[browser]} or higher.`);
            compatibility.recommendations.push('Update your browser to the latest version for the best experience.');
        }
    }

    if (browser === 'Unknown') {
        compatibility.supported = false;
        compatibility.level = 'unknown';
        compatibility.warnings.push('Your browser is not recognized. Some features may not work properly.');
        compatibility.recommendations.push('Please use a modern browser like Chrome, Firefox, Safari, or Edge.');
    }

    return compatibility;
}

function compareVersions(version1, version2) {
    const v1parts = version1.split('.').map(Number);
    const v2parts = version2.split('.').map(Number);
    
    for (let i = 0; i < Math.max(v1parts.length, v2parts.length); i++) {
        const v1part = v1parts[i] || 0;
        const v2part = v2parts[i] || 0;
        
        if (v1part < v2part) return -1;
        if (v1part > v2part) return 1;
    }
    
    return 0;
}

function showCompatibilityWarning(capabilities) {
    const checkDiv = document.getElementById('browser-compatibility-check');
    const resultsDiv = document.getElementById('compatibility-results');
    
    let html = `
        <div class="mb-4">
            <h3 class="text-lg font-semibold mb-2">Browser Information</h3>
            <p><strong>Browser:</strong> ${capabilities.browser} ${capabilities.version}</p>
            <p><strong>Operating System:</strong> ${capabilities.os}</p>
            <p><strong>Device:</strong> ${capabilities.device}</p>
        </div>
    `;
    
    if (capabilities.compatibility.warnings.length > 0) {
        html += `
            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2 text-red-600">Warnings</h3>
                <ul class="list-disc list-inside space-y-1">
                    ${capabilities.compatibility.warnings.map(warning => `<li class="text-red-600">${warning}</li>`).join('')}
                </ul>
            </div>
        `;
    }
    
    if (capabilities.compatibility.recommendations.length > 0) {
        html += `
            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2 text-blue-600">Recommendations</h3>
                <ul class="list-disc list-inside space-y-1">
                    ${capabilities.compatibility.recommendations.map(rec => `<li class="text-blue-600">${rec}</li>`).join('')}
                </ul>
            </div>
        `;
    }
    
    resultsDiv.innerHTML = html;
    checkDiv.classList.remove('hidden');
}

function closeCompatibilityCheck() {
    document.getElementById('browser-compatibility-check').classList.add('hidden');
}

// Progressive Web App features
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful');
            })
            .catch(function(err) {
                console.log('ServiceWorker registration failed');
            });
    });
}

// Offline detection
window.addEventListener('online', function() {
    showNotification('You are back online', 'success');
});

window.addEventListener('offline', function() {
    showNotification('You are offline. Some features may not be available.', 'warning');
});

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-black'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}
</script>
<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\browser-compatibility-check.blade.php ENDPATH**/ ?>