@php
    $notifications = auth()->user()->unreadNotifications()
        ->where('type', 'App\Notifications\AppointmentSMSNotification')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
@endphp

@if($notifications->count() > 0)
<div class="notifications-container">
    <h4 class="text-lg font-semibold mb-3 text-gray-800">
        <i class="fas fa-bell text-blue-500 mr-2"></i>
        Recent Notifications
    </h4>
    
    <div class="space-y-3">
        @foreach($notifications as $notification)
            @php
                $data = $notification->data;
                $colorClass = $this->getColorClass($data['color'] ?? 'secondary');
                $iconClass = $this->getIconClass($data['icon'] ?? 'info-circle');
            @endphp
            
            <div class="notification-item bg-white rounded-lg shadow-sm border-l-4 {{ $colorClass }} p-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas {{ $iconClass }} text-lg {{ $this->getIconColorClass($data['color'] ?? 'secondary') }}"></i>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h5 class="text-sm font-medium text-gray-900 mb-1">
                                {{ $data['title'] ?? 'Appointment Update' }}
                            </h5>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                {{ $data['message'] ?? 'Your appointment status has been updated.' }}
                            </p>
                            
                            <div class="flex flex-wrap gap-2 text-xs text-gray-500">
                                @if(isset($data['doctor_name']) && $data['doctor_name'] !== 'Your Doctor')
                                    <span class="bg-gray-100 px-2 py-1 rounded">
                                        <i class="fas fa-user-md mr-1"></i>
                                        {{ $data['doctor_name'] }}
                                    </span>
                                @endif
                                
                                @if(isset($data['appointment_date']) && $data['appointment_date'] !== 'N/A')
                                    <span class="bg-gray-100 px-2 py-1 rounded">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $data['appointment_date'] }}
                                    </span>
                                @endif
                                
                                @if(isset($data['appointment_time']) && $data['appointment_time'] !== 'N/A')
                                    <span class="bg-gray-100 px-2 py-1 rounded">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $data['appointment_time'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if(isset($data['action_url']) && isset($data['action_text']))
                            <a href="{{ $data['action_url'] }}" 
                               class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md transition-colors duration-200">
                                {{ $data['action_text'] }}
                            </a>
                        @endif
                        
                        <button onclick="markAsRead('{{ $notification->id }}')" 
                                class="text-xs text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mt-3 text-xs text-gray-400">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>
        @endforeach
    </div>
    
    @if(auth()->user()->unreadNotifications()->where('type', 'App\Notifications\AppointmentSMSNotification')->count() > 5)
        <div class="text-center mt-4">
            <a href="{{ route('patient.notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                View All Notifications
                <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    @endif
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
@else
<div class="text-center py-8 text-gray-500">
    <i class="fas fa-bell-slash text-4xl mb-3 text-gray-300"></i>
    <p class="text-sm">No new notifications</p>
    <p class="text-xs text-gray-400 mt-1">You'll see appointment updates here</p>
</div>
@endif

@php
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
@endphp
