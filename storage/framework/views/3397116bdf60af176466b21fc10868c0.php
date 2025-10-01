<?php
    $notifications = auth()->user()->unreadNotifications()
        ->where('type', 'App\Notifications\AppointmentSMSNotification')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
?>

<?php if($notifications->count() > 0): ?>
<div class="notifications-container">
    <h4 class="text-lg font-semibold mb-3 text-gray-800">
        <i class="fas fa-bell text-blue-500 mr-2"></i>
        Recent Notifications
    </h4>
    
    <div class="space-y-3">
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $data = $notification->data;
                $colorClass = $this->getColorClass($data['color'] ?? 'secondary');
                $iconClass = $this->getIconClass($data['icon'] ?? 'info-circle');
            ?>
            
            <div class="notification-item bg-white rounded-lg shadow-sm border-l-4 <?php echo e($colorClass); ?> p-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas <?php echo e($iconClass); ?> text-lg <?php echo e($this->getIconColorClass($data['color'] ?? 'secondary')); ?>"></i>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h5 class="text-sm font-medium text-gray-900 mb-1">
                                <?php echo e($data['title'] ?? 'Appointment Update'); ?>

                            </h5>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                <?php echo e($data['message'] ?? 'Your appointment status has been updated.'); ?>

                            </p>
                            
                            <div class="flex flex-wrap gap-2 text-xs text-gray-500">
                                <?php if(isset($data['doctor_name']) && $data['doctor_name'] !== 'Your Doctor'): ?>
                                    <span class="bg-gray-100 px-2 py-1 rounded">
                                        <i class="fas fa-user-md mr-1"></i>
                                        <?php echo e($data['doctor_name']); ?>

                                    </span>
                                <?php endif; ?>
                                
                                <?php if(isset($data['appointment_date']) && $data['appointment_date'] !== 'N/A'): ?>
                                    <span class="bg-gray-100 px-2 py-1 rounded">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <?php echo e($data['appointment_date']); ?>

                                    </span>
                                <?php endif; ?>
                                
                                <?php if(isset($data['appointment_time']) && $data['appointment_time'] !== 'N/A'): ?>
                                    <span class="bg-gray-100 px-2 py-1 rounded">
                                        <i class="fas fa-clock mr-1"></i>
                                        <?php echo e($data['appointment_time']); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <?php if(isset($data['action_url']) && isset($data['action_text'])): ?>
                            <a href="<?php echo e($data['action_url']); ?>" 
                               class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md transition-colors duration-200">
                                <?php echo e($data['action_text']); ?>

                            </a>
                        <?php endif; ?>
                        
                        <button onclick="markAsRead('<?php echo e($notification->id); ?>')" 
                                class="text-xs text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mt-3 text-xs text-gray-400">
                    <?php echo e($notification->created_at->diffForHumans()); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <?php if(auth()->user()->unreadNotifications()->where('type', 'App\Notifications\AppointmentSMSNotification')->count() > 5): ?>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('patient.notifications.index')); ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                View All Notifications
                <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/patient/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the notification from the DOM
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.remove();
            }
            
            // Update notification count if it exists
            const countElement = document.getElementById('notification-count');
            if (countElement) {
                const currentCount = parseInt(countElement.textContent) - 1;
                countElement.textContent = currentCount > 0 ? currentCount : '';
            }
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}
</script>
<?php else: ?>
<div class="text-center py-8 text-gray-500">
    <i class="fas fa-bell-slash text-4xl mb-3 text-gray-300"></i>
    <p class="text-sm">No new notifications</p>
    <p class="text-xs text-gray-400 mt-1">You'll see appointment updates here</p>
</div>
<?php endif; ?>

<?php
class NotificationHelper {
    public function getColorClass($color) {
        $classes = [
            'success' => 'border-green-500',
            'danger' => 'border-red-500',
            'warning' => 'border-yellow-500',
            'info' => 'border-blue-500',
            'primary' => 'border-purple-500',
            'secondary' => 'border-gray-500'
        ];
        
        return $classes[$color] ?? $classes['secondary'];
    }
    
    public function getIconClass($icon) {
        $classes = [
            'check-circle' => 'fa-check-circle',
            'x-circle' => 'fa-times-circle',
            'calendar-plus' => 'fa-calendar-plus',
            'calendar-x' => 'fa-calendar-times',
            'bell' => 'fa-bell',
            'info-circle' => 'fa-info-circle'
        ];
        
        return $classes[$icon] ?? 'fa-info-circle';
    }
    
    public function getIconColorClass($color) {
        $classes = [
            'success' => 'text-green-500',
            'danger' => 'text-red-500',
            'warning' => 'text-yellow-500',
            'info' => 'text-blue-500',
            'primary' => 'text-purple-500',
            'secondary' => 'text-gray-500'
        ];
        
        return $classes[$color] ?? $classes['secondary'];
    }
}

$helper = new NotificationHelper();
?>
<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\patient-notifications.blade.php ENDPATH**/ ?>