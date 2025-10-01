<?php
    $user = auth()->user();
    $notifications = $user ? $user->unreadNotifications()->take(5)->get() : collect();
?>

<div class="real-time-notifications" x-data="realTimeNotifications()">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-bell text-blue-500 mr-2"></i>
            Live Updates
        </h3>
        <div class="flex items-center space-x-2">
            <!-- Connection Status Indicator -->
            <div class="flex items-center space-x-1">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse" id="connection-indicator"></div>
                <span class="text-xs text-gray-500" id="connection-status">Connected</span>
            </div>
            
            <!-- Last Update Time -->
            <span class="text-xs text-gray-400" id="last-update-time"></span>
        </div>
    </div>

    <!-- Notifications Container -->
    <div class="space-y-3" id="notifications-container">
        <?php if($notifications->count() > 0): ?>
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $data = $notification->data;
                    $type = $data['type'] ?? 'info';
                    $colorClass = $this->getColorClass($type);
                    $iconClass = $this->getIconClass($type);
                ?>
                
                <div class="notification-item bg-white rounded-lg shadow-sm border-l-4 <?php echo e($colorClass); ?> p-3 hover:shadow-md transition-all duration-200 transform hover:scale-[1.02]"
                     data-notification-id="<?php echo e($notification->id); ?>"
                     x-show="true"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 flex-1">
                            <div class="flex-shrink-0 mt-1">
                                <i class="<?php echo e($iconClass); ?> text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900">
                                    <?php echo e($data['title'] ?? 'Notification'); ?>

                                </h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    <?php echo e($data['message'] ?? 'You have a new notification'); ?>

                                </p>
                                <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                                    <?php if(isset($data['doctor_name'])): ?>
                                        <span><i class="fas fa-user-md mr-1"></i><?php echo e($data['doctor_name']); ?></span>
                                    <?php endif; ?>
                                    <?php if(isset($data['appointment_date'])): ?>
                                        <span><i class="fas fa-calendar mr-1"></i><?php echo e($data['appointment_date']); ?></span>
                                    <?php endif; ?>
                                    <?php if(isset($data['appointment_time'])): ?>
                                        <span><i class="fas fa-clock mr-1"></i><?php echo e($data['appointment_time']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <!-- Action Button -->
                            <?php if(isset($data['action_url']) && isset($data['action_text'])): ?>
                                <a href="<?php echo e($data['action_url']); ?>" 
                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors duration-200">
                                    <?php echo e($data['action_text']); ?>

                                </a>
                            <?php endif; ?>
                            
                            <!-- Mark as Read Button -->
                            <button onclick="markAsRead('<?php echo e($notification->id); ?>')" 
                                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                    title="Mark as read">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Timestamp -->
                    <div class="mt-2 text-xs text-gray-400">
                        <i class="fas fa-clock mr-1"></i>
                        <?php echo e($notification->created_at->diffForHumans()); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500" id="no-notifications">
                <i class="fas fa-bell-slash text-4xl mb-3 text-gray-300"></i>
                <p class="text-sm">No new notifications</p>
                <p class="text-xs text-gray-400 mt-1">Live updates will appear here</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Loading Indicator -->
    <div class="hidden text-center py-4" id="loading-indicator">
        <div class="inline-flex items-center space-x-2">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
            <span class="text-sm text-gray-500">Checking for updates...</span>
        </div>
    </div>

    <!-- View All Link -->
    <?php if($notifications->count() > 0): ?>
        <div class="mt-4 text-center">
            <a href="<?php echo e(route('patient.notifications.index')); ?>" 
               class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200">
                View all notifications <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
function realTimeNotifications() {
    return {
        init() {
            this.initializeRealTimeService();
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
            
            // Listen for new notifications
            service.on('new_appointments', (data) => {
                this.addNotification(data, 'new_appointment');
            });

            // Listen for cancelled appointments
            service.on('cancelled_appointments', (data) => {
                this.addNotification(data, 'cancelled_appointment');
            });

            // Listen for appointment updates
            service.on('appointment_updates', (data) => {
                this.addNotification(data, 'status_change');
            });

            // Listen for general updates
            service.on('general', (data) => {
                this.updateConnectionStatus(data);
            });

            // Listen for stats updates
            service.on('stats', (data) => {
                this.updateLastUpdateTime();
            });
        },

        setupEventListeners() {
            // Update connection status periodically
            setInterval(() => {
                this.updateConnectionStatus();
            }, 5000);

            // Update last update time
            setInterval(() => {
                this.updateLastUpdateTime();
            }, 10000);
        },

        addNotification(data, type) {
            const container = document.getElementById('notifications-container');
            const noNotifications = document.getElementById('no-notifications');
            
            // Hide "no notifications" message
            if (noNotifications) {
                noNotifications.style.display = 'none';
            }

            // Create notification element
            const notification = this.createNotificationElement(data, type);
            
            // Add to container with animation
            container.insertBefore(notification, container.firstChild);
            
            // Show success toast
            if (window.realTimeService) {
                window.realTimeService.showToast(
                    this.getNotificationTitle(type),
                    this.getNotificationMessage(data, type),
                    'info'
                );
            }

            // Update notification count
            this.updateNotificationCount();
        },

        createNotificationElement(data, type) {
            const notification = document.createElement('div');
            notification.className = 'notification-item bg-white rounded-lg shadow-sm border-l-4 p-3 hover:shadow-md transition-all duration-200 transform scale-95 opacity-0';
            
            const colorClass = this.getColorClass(type);
            const iconClass = this.getIconClass(type);
            
            notification.className += ` ${colorClass}`;
            notification.setAttribute('data-notification-id', data.id || Date.now());
            
            notification.innerHTML = `
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 flex-1">
                        <div class="flex-shrink-0 mt-1">
                            <i class="${iconClass} text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900">
                                ${this.getNotificationTitle(type)}
                            </h4>
                            <p class="text-sm text-gray-600 mt-1">
                                ${this.getNotificationMessage(data, type)}
                            </p>
                            <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                                ${data.doctor_name ? `<span><i class="fas fa-user-md mr-1"></i>${data.doctor_name}</span>` : ''}
                                ${data.date ? `<span><i class="fas fa-calendar mr-1"></i>${data.date}</span>` : ''}
                                ${data.time ? `<span><i class="fas fa-clock mr-1"></i>${data.time}</span>` : ''}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                                class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                title="Dismiss">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mt-2 text-xs text-gray-400">
                    <i class="fas fa-clock mr-1"></i>
                    Just now
                </div>
            `;

            // Animate in
            setTimeout(() => {
                notification.classList.remove('scale-95', 'opacity-0');
                notification.classList.add('scale-100', 'opacity-100');
            }, 100);

            return notification;
        },

        getNotificationTitle(type) {
            const titles = {
                'new_appointment': 'New Appointment',
                'cancelled_appointment': 'Appointment Cancelled',
                'status_change': 'Appointment Updated',
                'new_consultation': 'New Consultation',
                'default': 'Notification'
            };
            return titles[type] || titles.default;
        },

        getNotificationMessage(data, type) {
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
                    return 'You have a new notification';
            }
        },

        getColorClass(type) {
            const colors = {
                'new_appointment': 'border-blue-500',
                'cancelled_appointment': 'border-red-500',
                'status_change': 'border-yellow-500',
                'new_consultation': 'border-green-500',
                'default': 'border-gray-500'
            };
            return colors[type] || colors.default;
        },

        getIconClass(type) {
            const icons = {
                'new_appointment': 'fas fa-calendar-plus text-blue-500',
                'cancelled_appointment': 'fas fa-calendar-times text-red-500',
                'status_change': 'fas fa-calendar-check text-yellow-500',
                'new_consultation': 'fas fa-stethoscope text-green-500',
                'default': 'fas fa-bell text-gray-500'
            };
            return icons[type] || icons.default;
        },

        updateConnectionStatus(data = null) {
            const indicator = document.getElementById('connection-indicator');
            const status = document.getElementById('connection-status');
            
            if (window.realTimeService) {
                const serviceStatus = window.realTimeService.getStatus();
                
                if (serviceStatus.isRunning) {
                    indicator.className = 'w-2 h-2 rounded-full bg-green-500 animate-pulse';
                    status.textContent = 'Connected';
                    status.className = 'text-xs text-green-600';
                } else {
                    indicator.className = 'w-2 h-2 rounded-full bg-red-500';
                    status.textContent = 'Disconnected';
                    status.className = 'text-xs text-red-600';
                }
            }
        },

        updateLastUpdateTime() {
            const timeElement = document.getElementById('last-update-time');
            if (window.realTimeService) {
                const status = window.realTimeService.getStatus();
                if (status.lastUpdateTime) {
                    const lastUpdate = new Date(status.lastUpdateTime);
                    timeElement.textContent = `Updated ${lastUpdate.toLocaleTimeString()}`;
                }
            }
        },

        updateNotificationCount() {
            // Update notification badge if it exists
            const badge = document.getElementById('notification-badge');
            if (badge) {
                const currentCount = parseInt(badge.textContent) || 0;
                badge.textContent = currentCount + 1;
                badge.style.display = 'block';
            }
        }
    }
}

// Mark notification as read function
function markAsRead(notificationId) {
    fetch(`/api/real-time/notifications/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            notification_ids: [notificationId]
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the notification from the DOM
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.style.transform = 'scale(95)';
                notificationElement.style.opacity = '0';
                setTimeout(() => {
                    notificationElement.remove();
                    
                    // Show "no notifications" if none left
                    const container = document.getElementById('notifications-container');
                    if (container.children.length === 0) {
                        const noNotifications = document.getElementById('no-notifications');
                        if (noNotifications) {
                            noNotifications.style.display = 'block';
                        }
                    }
                }, 300);
            }
            
            // Update notification count
            const badge = document.getElementById('notification-badge');
            if (badge) {
                const currentCount = parseInt(badge.textContent) || 0;
                const newCount = Math.max(0, currentCount - 1);
                badge.textContent = newCount > 0 ? newCount : '';
                badge.style.display = newCount > 0 ? 'block' : 'none';
            }
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}
</script>

<?php
class NotificationHelper {
    public function getColorClass($type) {
        $colors = [
            'new_appointment' => 'border-blue-500',
            'cancelled_appointment' => 'border-red-500',
            'status_change' => 'border-yellow-500',
            'new_consultation' => 'border-green-500',
            'default' => 'border-gray-500'
        ];
        return $colors[$type] ?? $colors['default'];
    }
    
    public function getIconClass($type) {
        $icons = [
            'new_appointment' => 'fas fa-calendar-plus text-blue-500',
            'cancelled_appointment' => 'fas fa-calendar-times text-red-500',
            'status_change' => 'fas fa-calendar-check text-yellow-500',
            'new_consultation' => 'fas fa-stethoscope text-green-500',
            'default' => 'fas fa-bell text-gray-500'
        ];
        return $icons[$type] ?? $icons['default'];
    }
}

$helper = new NotificationHelper();
?>
<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\real-time-notifications.blade.php ENDPATH**/ ?>