
<?php $__env->startSection('title', 'Appointments - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Appointments'); ?>
<?php $__env->startSection('page-subtitle', 'Manage patient bookings'); ?>
<?php $__env->startSection('content'); ?>
<style>
.bg-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.gradient-text {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}


</style>
<div class="appointments-content">
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card p-4 flex flex-col items-center bg-gradient-to-br from-blue-100 to-blue-50 shadow-md">
        <div class="text-gray-500 text-xs mb-1">Total</div>
        <div class="text-2xl font-bold text-blue-700"><?php echo e($appointments->total()); ?></div>
        <i class="fas fa-calendar-check text-blue-600 text-xl mt-2"></i>
    </div>
    <div class="card p-4 flex flex-col items-center bg-gradient-to-br from-yellow-100 to-yellow-50 shadow-md">
        <div class="text-gray-500 text-xs mb-1">Pending</div>
        <div class="text-2xl font-bold text-yellow-700"><?php echo e($appointments->where('status', 'pending')->count()); ?></div>
        <i class="fas fa-clock text-yellow-600 text-xl mt-2"></i>
    </div>
    <div class="card p-4 flex flex-col items-center bg-gradient-to-br from-green-100 to-green-50 shadow-md">
        <div class="text-gray-500 text-xs mb-1">Confirmed</div>
        <div class="text-2xl font-bold text-green-700"><?php echo e($appointments->where('status', 'confirmed')->count()); ?></div>
        <i class="fas fa-check-circle text-green-600 text-xl mt-2"></i>
    </div>
    <div class="card p-4 flex flex-col items-center bg-gradient-to-br from-gray-100 to-gray-50 shadow-md">
        <div class="text-gray-500 text-xs mb-1">Completed</div>
        <div class="text-2xl font-bold text-gray-700"><?php echo e($appointments->where('status', 'completed')->count()); ?></div>
        <i class="fas fa-check-double text-gray-600 text-xl mt-2"></i>
    </div>
</div>

<div class="card p-6 mb-6">
    <div class="font-semibold text-lg mb-4 flex items-center gap-2">
        <i class="fas fa-search text-blue-500"></i> Search & Filter
    </div>
    
    <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
        <div>
            <label class="block text-gray-700 font-semibold text-sm mb-2">Patient Name</label>
            <div class="relative">
                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="patient" class="form-input w-full pl-10" value="<?php echo e(request('patient')); ?>" placeholder="Search patient...">
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold text-sm mb-2">Doctor Name</label>
            <div class="relative">
                <i class="fas fa-user-md absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="doctor" class="form-input w-full pl-10" value="<?php echo e(request('doctor')); ?>" placeholder="Search doctor...">
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold text-sm mb-2">Appointment Date</label>
            <div class="relative">
                <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="date" name="date" class="form-input w-full pl-10" value="<?php echo e(request('date')); ?>">
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold text-sm mb-2">Status</label>
            <div class="relative">
                <i class="fas fa-filter absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <select name="status" class="form-input w-full pl-10">
                    <option value="">All Status</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn btn-primary flex items-center gap-2">
                <i class="fas fa-search"></i> Search
            </button>
            <a href="<?php echo e(route('staff.appointments.index')); ?>" class="btn btn-secondary flex items-center gap-2">
                <i class="fas fa-undo"></i> Reset
            </a>
        </div>
    </form>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        <?php if(str_contains(session('success'), 'approved')): ?>
            <div class="ml-2 text-sm text-green-600">
                📧 Email confirmation sent to patient automatically!
            </div>
        <?php endif; ?>
        <?php if(str_contains(session('success'), 'background')): ?>
            <div class="ml-2 text-sm text-blue-600">
                ⚡ Action completed instantly! Emails are being sent in the background.
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if(session('warning')): ?>
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('warning')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="bg-red-100 text-red-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-times-circle"></i> <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="card p-6">
    <div class="font-semibold text-lg mb-4 flex items-center gap-2">
        <i class="fas fa-calendar-check text-blue-500"></i> Appointment List
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm rounded-lg shadow-lg border border-gray-200">
            <thead>
                <tr class="text-left text-gray-600 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Patient</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Doctor</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Date</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Time</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Status</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full text-blue-600 font-bold text-lg flex-shrink-0">
                                    <?php echo e(strtoupper(substr($appointment->patient->first_name ?? '-', 0, 1))); ?>

                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="font-medium truncate"><?php echo e($appointment->patient->first_name ?? '-'); ?> <?php echo e($appointment->patient->last_name ?? ''); ?></div>
                                    <div class="text-xs text-gray-500 truncate"><?php echo e($appointment->patient->email ?? ''); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-green-100 rounded-full text-green-600 font-bold text-lg flex-shrink-0">
                                    <?php echo e(strtoupper(substr($appointment->doctor->user->first_name ?? '-', 0, 1))); ?>

                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="font-medium truncate">Dr. <?php echo e($appointment->doctor->user->first_name ?? '-'); ?> <?php echo e($appointment->doctor->user->last_name ?? ''); ?></div>
                                    <div class="text-xs text-gray-500 truncate"><?php echo e($appointment->doctor->specialization ?? ''); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <div class="font-medium"><?php echo e($appointment->appointment_date ? $appointment->appointment_date->format('M d, Y') : '-'); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($appointment->appointment_date ? $appointment->appointment_date->format('l') : ''); ?></div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <div class="font-medium"><?php echo e($appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : '-'); ?></div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <?php
                                    $badge = match($appointment->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'confirmed' => 'bg-green-100 text-green-700 border-green-200',
                                        'completed' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200',
                                    };
                                ?>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border-2 <?php echo e($badge); ?> shadow-sm">
                                    <i class="fas fa-circle mr-2 text-[6px]"></i> <?php echo e(ucfirst($appointment->status)); ?>

                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2">
                                <?php if($appointment->status === 'pending'): ?>
                                    <form method="POST" action="/staff/appointments/<?php echo e($appointment->id); ?>/confirm" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                        <i class="fas fa-check mr-1.5"></i> Approve
                                    </button>
                                    </form>
                                    <form method="POST" action="/staff/appointments/<?php echo e($appointment->id); ?>/decline" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                        <i class="fas fa-times mr-1.5"></i> Decline
                                    </button>
                                    </form>
                                <?php elseif($appointment->status === 'confirmed'): ?>
                                    <form method="POST" action="/staff/appointments/<?php echo e($appointment->id); ?>/complete" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        <i class="fas fa-check-double mr-1.5"></i> Complete
                                    </button>
                                    </form>
                                <?php endif; ?>
                                <form method="POST" action="/staff/appointments/<?php echo e($appointment->id); ?>" class="inline-block delete-appointment-form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            data-appointment-id="<?php echo e($appointment->id); ?>"
                                            data-patient-name="<?php echo e($appointment->patient->first_name ?? ''); ?> <?php echo e($appointment->patient->last_name ?? ''); ?>"
                                            data-appointment-date="<?php echo e($appointment->appointment_date ? $appointment->appointment_date->format('M d, Y') : ''); ?>"
                                            data-appointment-time="<?php echo e($appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : ''); ?>"
                                            onclick="return false;"
                                            id="delete-btn-<?php echo e($appointment->id); ?>"
                                            class="delete-appointment-btn inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                    <i class="fas fa-trash mr-1.5"></i> Delete
                                </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-calendar-times text-4xl text-gray-300"></i>
                                <div class="text-lg font-medium">No appointments found</div>
                                <div class="text-sm">Try adjusting your search criteria</div>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        <?php echo e($appointments->links()); ?>

    </div>
</div>










</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Delete Appointment</h3>
        </div>
        <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete this appointment? This action cannot be undone.</p>
        <div class="bg-gray-50 rounded-lg p-3 mb-4 text-sm text-gray-700" id="delete-summary"></div>
        <div class="flex justify-end gap-3">
            <button type="button" id="cancel-delete" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</button>
            <button type="button" id="confirm-delete" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Delete</button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('delete-modal');
    const summary = document.getElementById('delete-summary');
    const cancelBtn = document.getElementById('cancel-delete');
    const confirmBtn = document.getElementById('confirm-delete');
    let targetForm = null;

    document.querySelectorAll('.delete-appointment-form .delete-appointment-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('form');
            targetForm = form;
            const name = this.getAttribute('data-patient-name') || 'Unknown';
            const date = this.getAttribute('data-appointment-date') || '';
            const time = this.getAttribute('data-appointment-time') || '';
            summary.innerHTML = `<strong>Patient:</strong> ${name}<br><strong>Date:</strong> ${date}<br><strong>Time:</strong> ${time}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    cancelBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        targetForm = null;
    });

    confirmBtn.addEventListener('click', function () {
        if (!targetForm) return;
        targetForm.submit();
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        targetForm = null;
    });
});
</script>
<?php $__env->stopPush(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\appointments\index.blade.php ENDPATH**/ ?>