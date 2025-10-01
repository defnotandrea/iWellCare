/**
 * Logout Handler for iWellCare
 * Handles logout functionality and prevents access to dashboard after logout
 */

class LogoutHandler {
    /**
     * Initialize logout handlers
     */
    static init() {
        // Handle logout form submissions
        document.addEventListener('DOMContentLoaded', function() {
            const logoutForms = document.querySelectorAll('form[action*="logout"]');
            
            logoutForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    LogoutHandler.handleLogout(this);
                });
            });
        });

        // Prevent back button after logout
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page was loaded from back-forward cache
                window.location.reload();
            }
        });

        // Clear any cached data on page unload
        window.addEventListener('beforeunload', function() {
            LogoutHandler.clearCache();
        });
    }

    /**
     * Handle logout form submission
     */
    static handleLogout(form) {
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Logging out...';
        submitBtn.disabled = true;

        // Clear any cached data
        LogoutHandler.clearCache();

        // Submit the form
        form.submit();
    }

    /**
     * Clear browser cache and local storage
     */
    static clearCache() {
        // Clear localStorage
        if (typeof localStorage !== 'undefined') {
            localStorage.clear();
        }

        // Clear sessionStorage
        if (typeof sessionStorage !== 'undefined') {
            sessionStorage.clear();
        }

        // Clear any cached data
        if ('caches' in window) {
            caches.keys().then(function(names) {
                for (let name of names) {
                    caches.delete(name);
                }
            });
        }
    }

    /**
     * Check if user is authenticated
     */
    static isAuthenticated() {
        // Check for authentication token or session
        const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
        return !!token;
    }

    /**
     * Force redirect to login if not authenticated
     */
    static checkAuth() {
        if (!LogoutHandler.isAuthenticated()) {
            window.location.href = '/login';
        }
    }
}

// Initialize logout handler
LogoutHandler.init();

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LogoutHandler;
} 