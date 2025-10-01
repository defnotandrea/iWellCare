
<?php $__env->startSection('title', 'Appointment Details - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Appointment Details'); ?>
<?php $__env->startSection('page-subtitle', 'View your appointment information'); ?>
<?php $__env->startSection('content'); ?>

<div class="max-w-2xl mx-auto">
    <div class="card p-6">
        <div class="space-y-6">
            <!-- Appointment Header -->
            <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Appointment Details</h3>
                    <p class="text-gray-600"><?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('l, M d, Y')); ?> at <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A')); ?></p>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Status:</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    <?php if($appointment->status === 'confirmed'): ?> bg-green-100 text-green-700
                    <?php elseif($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-700
                    <?php elseif($appointment->status === 'cancelled'): ?> bg-red-100 text-red-700
                    <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                    <?php echo e(ucfirst($appointment->status)); ?>

                </span>
            </div>

            <!-- Doctor Information -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Doctor Information</h4>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-blue-600"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800">Dr. <?php echo e($appointment->doctor && $appointment->doctor->user ? $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name : 'Unknown Doctor'); ?></div>
                        <div class="text-sm text-gray-600"><?php echo e($appointment->doctor ? $appointment->doctor->specialization : ''); ?></div>
                        <div class="text-sm text-gray-600"><?php echo e($appointment->doctor ? $appointment->doctor->email : ''); ?></div>
                    </div>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="space-y-4">
                <h4 class="font-semibold text-gray-800">Appointment Details</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Date</div>
                            <div class="font-medium text-gray-800"><?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('l, M d, Y')); ?></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Time</div>
                            <div class="font-medium text-gray-800"><?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A')); ?></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Type</div>
                            <div class="font-medium text-gray-800"><?php echo e(ucfirst($appointment->type)); ?></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-orange-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Priority</div>
                            <div class="font-medium text-gray-800"><?php echo e(ucfirst($appointment->priority)); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <?php if($appointment->notes): ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-semibold text-yellow-800 mb-2">Notes</h4>
                <p class="text-yellow-700"><?php echo e($appointment->notes); ?></p>
            </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <?php if(in_array($appointment->status, ['pending', 'confirmed'])): ?>
                    <button type="button" onclick="showCancelModal()" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancel Appointment
                    </button>
                <?php endif; ?>
                
                <a href="<?php echo e(route('patient.appointments.index')); ?>" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Appointments
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Appointment Modal -->
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="px-8 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Cancel Appointment</h3>
                        <p class="text-gray-600 text-sm mt-1">Are you sure you want to cancel this appointment?</p>
                    </div>
                </div>
                <button onclick="closeCancelModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="mb-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-red-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-red-800">Appointment Details</p>
                            <p class="text-sm text-red-700">
                                <strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('l, M d, Y')); ?><br>
                                <strong>Time:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A')); ?><br>
                                <strong>Doctor:</strong> Dr. <?php echo e($appointment->doctor && $appointment->doctor->user ? $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name : 'Unknown Doctor'); ?>

                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-yellow-800">Important Notice</p>
                            <p class="text-sm text-yellow-700">Cancelling this appointment will free up the time slot for other patients. You can reschedule for a later date if needed.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="<?php echo e(route('patient.appointments.cancel', $appointment)); ?>" method="POST" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Yes, Cancel Appointment
                    </button>
                </form>
                <button onclick="closeCancelModal()" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    No, Keep Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showCancelModal() {
    const modal = document.getElementById('cancelModal');
    modal.classList.remove('hidden');
    
    // Add animation
    modal.querySelector('.bg-white').style.transform = 'scale(0.9)';
    setTimeout(() => {
        modal.querySelector('.bg-white').style.transform = 'scale(1)';
    }, 10);
}

function closeCancelModal() {
    const modal = document.getElementById('cancelModal');
    modal.querySelector('.bg-white').style.transform = 'scale(0.9)';
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

// Close modal when clicking outside
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCancelModal();
    }
});
</script>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\appointments\show.blade.php ENDPATH**/ ?>