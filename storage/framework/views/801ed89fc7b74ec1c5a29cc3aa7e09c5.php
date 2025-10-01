<?php
    $user = auth()->user();
    $role = $user ? $user->role : 'guest';
?>

<div class="real-time-dashboard-widget bg-white rounded-lg shadow-sm border border-gray-200 p-6" 
     x-data="realTimeDashboardWidget()"
     x-init="init()">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                Live Dashboard
            </h3>
            <p class="text-sm text-gray-500 mt-1">Real-time statistics and updates</p>
        </div>
        
        <!-- Connection Status -->
        <div class="flex items-center space-x-2">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse" id="dashboard-connection-indicator"></div>
            <span class="text-xs text-gray-500" id="dashboard-connection-status">Live</span>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6" id="stats-grid">
        <?php if($role === 'doctor'): ?>
            <!-- Doctor Statistics -->
            <div class="stat-card bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Today's Appointments</p>
                        <p class="text-2xl font-bold text-blue-800" id="counter-today_appointments">-</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Pending Appointments</p>
                        <p class="text-2xl font-bold text-green-800" id="counter-pending_appointments">-</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">Total Patients</p>
                        <p class="text-2xl font-bold text-purple-800" id="counter-total_patients">-</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>

        <?php elseif($role === 'staff'): ?>
            <!-- Staff Statistics -->
            <div class="stat-card bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Today's Appointments</p>
                        <p class="text-2xl font-bold text-blue-800" id="counter-today_appointments">-</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-600">Pending Appointments</p>
                        <p class="text-2xl font-bold text-yellow-800" id="counter-pending_appointments">-</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Total Patients</p>
                        <p class="text-2xl font-bold text-green-800" id="counter-total_patients">-</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>

        <?php elseif($role === 'patient'): ?>
            <!-- Patient Statistics -->
            <div class="stat-card bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Total Appointments</p>
                        <p class="text-2xl font-bold text-blue-800" id="counter-total_appointments">-</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Upcoming Appointments</p>
                        <p class="text-2xl font-bold text-green-800" id="counter-upcoming_appointments">-</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">Total Consultations</p>
                        <p class="text-2xl font-bold text-purple-800" id="counter-total_consultations">-</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-stethoscope text-white text-xl"></i>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Activity -->
    <div class="border-t border-gray-200 pt-6">
        <h4 class="text-md font-medium text-gray-800 mb-4">
            <i class="fas fa-history text-gray-500 mr-2"></i>
            Recent Activity
        </h4>
        
        <div class="space-y-3" id="recent-activity">
            <div class="text-center py-4 text-gray-500" id="no-activity">
                <i class="fas fa-info-circle text-2xl mb-2 text-gray-300"></i>
                <p class="text-sm">No recent activity</p>
                <p class="text-xs text-gray-400 mt-1">Updates will appear here in real-time</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="border-t border-gray-200 pt-4 mt-6">
        <div class="flex items-center justify-between text-xs text-gray-500">
            <span>Last updated: <span id="dashboard-last-update">Never</span></span>
            <span>Refresh: <span id="dashboard-refresh-countdown">30s</span></span>
        </div>
    </div>
</div>

<script>
function realTimeDashboardWidget() {
    return {
        refreshCountdown: 30,
        countdownTimer: null,

        init() {
            this.initializeRealTimeService();
            this.startCountdown();
            this.setupEventListeners();
        },

        initializeRealTimeService() {
            // Wait for real-time service to be available
            if (window.realTimeService) {
                this.setupRealTimeCallbacks();
            } else {
                // Poll for service availability
                const checkService = setInterval(() => {
                    if (window.realTimeService) {
                        clearInterval(checkService);
                        this.setupRealTimeCallbacks();
                    }
                }, 100);
            }
        },

        setupRealTimeCallbacks() {
            const service = window.realTimeService;
            
            // Listen for stats updates
            service.on('stats', (data) => {
                this.updateStatistics(data);
                this.updateLastUpdateTime();
            });

            // Listen for new appointments
            service.on('new_appointments', (data) => {
                this.addActivityItem('new_appointment', data);
            });

            // Listen for cancelled appointments
            service.on('cancelled_appointments', (data) => {
                this.addActivityItem('cancelled_appointment', data);
            });

            // Listen for appointment updates
            service.on('appointment_updates', (data) => {
                this.addActivityItem('status_change', data);
            });

            // Listen for general updates
            service.on('general', (data) => {
                this.updateConnectionStatus(data);
            });
        },

        setupEventListeners() {
            // Update connection status periodically
            setInterval(() => {
                this.updateConnectionStatus();
            }, 5000);
        },

        updateStatistics(stats) {
            Object.keys(stats).forEach(key => {
                const counter = document.getElementById(`counter-${key}`);
                if (counter) {
                    // Animate the counter change
                    const currentValue = parseInt(counter.textContent) || 0;
                    const newValue = stats[key];
                    
                    if (currentValue !== newValue) {
                        this.animateCounter(counter, currentValue, newValue);
                    }
                }
            });
        },

        animateCounter(element, start, end) {
            const duration = 1000; // 1 second
            const startTime = performance.now();
            
            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function for smooth animation
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const current = Math.round(start + (end - start) * easeOutQuart);
                
                element.textContent = current;
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };
            
            requestAnimationFrame(animate);
        },

        addActivityItem(type, data) {
            const container = document.getElementById('recent-activity');
            const noActivity = document.getElementById('no-activity');
            
            // Hide "no activity" message
            if (noActivity) {
                noActivity.style.display = 'none';
            }

            // Create activity element
            const activityItem = this.createActivityElement(type, data);
            
            // Add to container with animation
            container.insertBefore(activityItem, container.firstChild);
            
            // Limit to 5 items
            const items = container.querySelectorAll('.activity-item');
            if (items.length > 5) {
                items[items.length - 1].remove();
            }
        },

        createActivityElement(type, data) {
            const activityItem = document.createElement('div');
            activityItem.className = 'activity-item bg-gray-50 rounded-lg p-3 border-l-4 transform scale-95 opacity-0 transition-all duration-300';
            
            const borderColors = {
                'new_appointment': 'border-blue-500',
                'cancelled_appointment': 'border-red-500',
                'status_change': 'border-yellow-500',
                'new_consultation': 'border-green-500'
            };
            
            activityItem.className += ` ${borderColors[type] || 'border-gray-500'}`;
            
            const icons = {
                'new_appointment': 'fas fa-calendar-plus text-blue-500',
                'cancelled_appointment': 'fas fa-calendar-times text-red-500',
                'status_change': 'fas fa-calendar-check text-yellow-500',
                'new_consultation': 'fas fa-stethoscope text-green-500'
            };
            
            const icon = icons[type] || 'fas fa-info-circle text-gray-500';
            
            activityItem.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        <i class="${icon}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900">
                            ${this.getActivityMessage(type, data)}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            ${this.getActivityTime(data)}
                        </p>
                    </div>
                </div>
            `;

            // Animate in
            setTimeout(() => {
                activityItem.classList.remove('scale-95', 'opacity-0');
                activityItem.classList.add('scale-100', 'opacity-100');
            }, 100);

            return activityItem;
        },

        getActivityMessage(type, data) {
            switch (type) {
                case 'new_appointment':
                    return `New appointment with ${data.patient_name || 'patient'}`;
                case 'cancelled_appointment':
                    return `Appointment with ${data.patient_name || 'patient'} was cancelled`;
                case 'status_change':
                    return `Appointment status changed to ${data.new_status || 'updated'}`;
                case 'new_consultation':
                    return `New consultation with ${data.patient_name || 'patient'}`;
                default:
                    return 'Activity update';
            }
        },

        getActivityTime(data) {
            if (data.timestamp) {
                const time = new Date(data.timestamp);
                return time.toLocaleTimeString();
            } else if (data.updated_at) {
                const time = new Date(data.updated_at);
                return time.toLocaleTimeString();
            } else {
                return 'Just now';
            }
        },

        updateConnectionStatus(data = null) {
            const indicator = document.getElementById('dashboard-connection-indicator');
            const status = document.getElementById('dashboard-connection-status');
            
            if (window.realTimeService) {
                const serviceStatus = window.realTimeService.getStatus();
                
                if (serviceStatus.isRunning) {
                    indicator.className = 'w-2 h-2 rounded-full bg-green-500 animate-pulse';
                    status.textContent = 'Live';
                    status.className = 'text-xs text-green-600';
                } else {
                    indicator.className = 'w-2 h-2 rounded-full bg-red-500';
                    status.textContent = 'Offline';
                    status.className = 'text-xs text-red-600';
                }
            }
        },

        updateLastUpdateTime() {
            const timeElement = document.getElementById('dashboard-last-update');
            const now = new Date();
            timeElement.textContent = now.toLocaleTimeString();
        },

        startCountdown() {
            this.countdownTimer = setInterval(() => {
                this.refreshCountdown--;
                
                if (this.refreshCountdown <= 0) {
                    this.refreshCountdown = 30;
                }
                
                const countdownElement = document.getElementById('dashboard-refresh-countdown');
                if (countdownElement) {
                    countdownElement.textContent = `${this.refreshCountdown}s`;
                }
            }, 1000);
        },

        stopCountdown() {
            if (this.countdownTimer) {
                clearInterval(this.countdownTimer);
                this.countdownTimer = null;
            }
        }
    }
}

// Cleanup when component is destroyed
document.addEventListener('beforeunload', () => {
    if (window.realTimeService) {
        window.realTimeService.stop();
    }
});
</script>
<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\real-time-dashboard-widget.blade.php ENDPATH**/ ?>