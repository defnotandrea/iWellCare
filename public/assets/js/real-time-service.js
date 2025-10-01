/**
 * Real-Time Service for iWellCare
 * Provides real-time updates for appointments, notifications, and dashboard data
 */

class RealTimeService {
    constructor() {
        this.updateInterval = 10000; // 10 seconds
        this.statsInterval = 30000; // 30 seconds
        this.isRunning = false;
        this.updateTimer = null;
        this.statsTimer = null;
        this.callbacks = new Map();
        this.lastUpdateTime = null;
        this.lastStatsTime = null;
        this.retryCount = 0;
        this.maxRetries = 3;
        this.retryDelay = 5000;
        
        // Initialize CSRF token
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Bind methods
        this.start = this.start.bind(this);
        this.stop = this.stop.bind(this);
        this.fetchUpdates = this.fetchUpdates.bind(this);
        this.fetchStats = this.fetchStats.bind(this);
        this.handleUpdate = this.handleUpdate.bind(this);
        this.handleStats = this.handleStats.bind(this);
        this.handleError = this.handleError.bind(this);
    }

    /**
     * Start real-time updates
     */
    start() {
        if (this.isRunning) {
            console.log('Real-time service is already running');
            return;
        }

        console.log('Starting real-time service...');
        this.isRunning = true;

        // Start update polling
        this.updateTimer = setInterval(this.fetchUpdates, this.updateInterval);
        
        // Start stats polling
        this.statsTimer = setInterval(this.fetchStats, this.statsInterval);

        // Fetch initial data
        this.fetchUpdates();
        this.fetchStats();

        // Add event listener for page visibility changes
        document.addEventListener('visibilitychange', this.handleVisibilityChange.bind(this));
        
        // Add event listener for online/offline status
        window.addEventListener('online', this.handleOnline.bind(this));
        window.addEventListener('offline', this.handleOffline.bind(this));
    }

    /**
     * Stop real-time updates
     */
    stop() {
        if (!this.isRunning) {
            return;
        }

        console.log('Stopping real-time service...');
        this.isRunning = false;

        if (this.updateTimer) {
            clearInterval(this.updateTimer);
            this.updateTimer = null;
        }

        if (this.statsTimer) {
            clearInterval(this.statsTimer);
            this.statsTimer = null;
        }

        // Remove event listeners
        document.removeEventListener('visibilitychange', this.handleVisibilityChange.bind(this));
        window.removeEventListener('online', this.handleOnline.bind(this));
        window.removeEventListener('offline', this.handleOffline.bind(this));
    }

    /**
     * Fetch real-time updates
     */
    async fetchUpdates() {
        try {
            const response = await fetch('/api/real-time/updates', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                this.handleUpdate(data);
                this.retryCount = 0; // Reset retry count on success
            } else {
                throw new Error(data.message || 'Failed to fetch updates');
            }

        } catch (error) {
            this.handleError('updates', error);
        }
    }

    /**
     * Fetch dashboard statistics
     */
    async fetchStats() {
        try {
            const response = await fetch('/api/real-time/stats', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                this.handleStats(data);
                this.retryCount = 0; // Reset retry count on success
            } else {
                throw new Error(data.message || 'Failed to fetch stats');
            }

        } catch (error) {
            this.handleError('stats', error);
        }
    }

    /**
     * Handle update data
     */
    handleUpdate(data) {
        this.lastUpdateTime = new Date();
        
        // Trigger callbacks for different update types
        if (data.updates) {
            Object.keys(data.updates).forEach(updateType => {
                const updateData = data.updates[updateType];
                this.triggerCallbacks(updateType, updateData);
            });
        }

        // Trigger general update callback
        this.triggerCallbacks('general', data);
        
        // Update notification badge if available
        this.updateNotificationBadge(data);
        
        // Show toast notifications for important updates
        this.showToastNotifications(data);
    }

    /**
     * Handle statistics data
     */
    handleStats(data) {
        this.lastStatsTime = new Date();
        
        // Trigger stats callbacks
        this.triggerCallbacks('stats', data.stats);
        
        // Update dashboard counters if available
        this.updateDashboardCounters(data.stats);
    }

    /**
     * Handle errors
     */
    handleError(type, error) {
        console.error(`Real-time ${type} error:`, error);
        
        this.retryCount++;
        
        if (this.retryCount <= this.maxRetries) {
            console.log(`Retrying ${type} in ${this.retryDelay}ms... (${this.retryCount}/${this.maxRetries})`);
            
            setTimeout(() => {
                if (type === 'updates') {
                    this.fetchUpdates();
                } else if (type === 'stats') {
                    this.fetchStats();
                }
            }, this.retryDelay);
        } else {
            console.error(`Max retries reached for ${type}. Stopping real-time service.`);
            this.stop();
        }
    }

    /**
     * Handle page visibility changes
     */
    handleVisibilityChange() {
        if (document.hidden) {
            // Page is hidden, reduce update frequency
            this.pauseUpdates();
        } else {
            // Page is visible, resume normal updates
            this.resumeUpdates();
        }
    }

    /**
     * Handle online status
     */
    handleOnline() {
        console.log('Connection restored. Resuming real-time updates...');
        this.retryCount = 0;
        this.resumeUpdates();
    }

    /**
     * Handle offline status
     */
    handleOffline() {
        console.log('Connection lost. Pausing real-time updates...');
        this.pauseUpdates();
    }

    /**
     * Pause updates when page is not visible
     */
    pauseUpdates() {
        if (this.updateTimer) {
            clearInterval(this.updateTimer);
            this.updateTimer = null;
        }
    }

    /**
     * Resume updates when page becomes visible
     */
    resumeUpdates() {
        if (this.isRunning && !this.updateTimer) {
            this.updateTimer = setInterval(this.fetchUpdates, this.updateInterval);
            // Fetch immediately
            this.fetchUpdates();
        }
    }

    /**
     * Register callback for specific update types
     */
    on(eventType, callback) {
        if (!this.callbacks.has(eventType)) {
            this.callbacks.set(eventType, []);
        }
        this.callbacks.get(eventType).push(callback);
    }

    /**
     * Remove callback for specific update types
     */
    off(eventType, callback) {
        if (this.callbacks.has(eventType)) {
            const callbacks = this.callbacks.get(eventType);
            const index = callbacks.indexOf(callback);
            if (index > -1) {
                callbacks.splice(index, 1);
            }
        }
    }

    /**
     * Trigger callbacks for specific event type
     */
    triggerCallbacks(eventType, data) {
        if (this.callbacks.has(eventType)) {
            this.callbacks.get(eventType).forEach(callback => {
                try {
                    callback(data);
                } catch (error) {
                    console.error(`Error in ${eventType} callback:`, error);
                }
            });
        }
    }

    /**
     * Update notification badge
     */
    updateNotificationBadge(data) {
        const badge = document.getElementById('notification-badge');
        if (badge && data.updates && data.updates.unread_notifications_count !== undefined) {
            const count = data.updates.unread_notifications_count;
            badge.textContent = count > 0 ? count : '';
            badge.style.display = count > 0 ? 'block' : 'none';
        }
    }

    /**
     * Update dashboard counters
     */
    updateDashboardCounters(stats) {
        Object.keys(stats).forEach(key => {
            const counter = document.getElementById(`counter-${key}`);
            if (counter) {
                counter.textContent = stats[key];
            }
        });
    }

    /**
     * Show toast notifications for important updates
     */
    showToastNotifications(data) {
        if (!data.updates) return;

        // Show notifications for new appointments
        if (data.updates.new_appointments) {
            data.updates.new_appointments.forEach(appointment => {
                this.showToast('New Appointment', `New appointment with ${appointment.patient_name}`, 'info');
            });
        }

        // Show notifications for cancelled appointments
        if (data.updates.cancelled_appointments) {
            data.updates.cancelled_appointments.forEach(appointment => {
                this.showToast('Appointment Cancelled', `Appointment with ${appointment.patient_name} was cancelled`, 'warning');
            });
        }

        // Show notifications for status changes
        if (data.updates.appointment_updates) {
            data.updates.appointment_updates.forEach(update => {
                this.showToast('Appointment Update', `Appointment status changed to ${update.new_status}`, 'info');
            });
        }
    }

    /**
     * Show toast notification
     */
    showToast(title, message, type = 'info') {
        // Check if toast container exists, create if not
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `bg-white border-l-4 p-4 shadow-lg rounded-lg max-w-sm transform transition-all duration-300 ease-in-out translate-x-full`;
        
        // Set border color based on type
        const borderColors = {
            'info': 'border-blue-500',
            'success': 'border-green-500',
            'warning': 'border-yellow-500',
            'error': 'border-red-500'
        };
        toast.className += ` ${borderColors[type] || borderColors.info}`;

        // Set icon based on type
        const icons = {
            'info': 'fas fa-info-circle text-blue-500',
            'success': 'fas fa-check-circle text-green-500',
            'warning': 'fas fa-exclamation-triangle text-yellow-500',
            'error': 'fas fa-times-circle text-red-500'
        };

        toast.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="${icons[type] || icons.info}"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h4 class="text-sm font-medium text-gray-900">${title}</h4>
                    <p class="text-sm text-gray-500 mt-1">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button class="text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;

        // Add to container
        toastContainer.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 5000);
    }

    /**
     * Get service status
     */
    getStatus() {
        return {
            isRunning: this.isRunning,
            lastUpdateTime: this.lastUpdateTime,
            lastStatsTime: this.lastStatsTime,
            retryCount: this.retryCount,
            maxRetries: this.maxRetries
        };
    }

    /**
     * Set update intervals
     */
    setIntervals(updateInterval = null, statsInterval = null) {
        if (updateInterval !== null) {
            this.updateInterval = updateInterval;
        }
        if (statsInterval !== null) {
            this.statsInterval = statsInterval;
        }

        // Restart service if running to apply new intervals
        if (this.isRunning) {
            this.stop();
            this.start();
        }
    }
}

// Create global instance
window.realTimeService = new RealTimeService();

// Auto-start when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Start real-time service if user is authenticated
    if (document.querySelector('meta[name="user-id"]')) {
        window.realTimeService.start();
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = RealTimeService;
}
