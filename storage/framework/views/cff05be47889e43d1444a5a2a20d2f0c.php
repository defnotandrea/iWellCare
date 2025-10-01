

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Prescription Details</h2>
        <a href="<?php echo e(route('doctor.prescriptions.index')); ?>" class="btn btn-secondary">Back to List</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Patient:</strong> <?php echo e($prescription->patient->user->first_name); ?> <?php echo e($prescription->patient->user->last_name); ?>

                </div>
                <div class="col-md-6">
                    <strong>Doctor:</strong> <?php echo e($prescription->doctor->name ?? '-'); ?>

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Date:</strong> <?php echo e($prescription->prescription_date->format('Y-m-d')); ?>

                </div>
                <div class="col-md-6">
                    <strong>Status:</strong> <?php echo e(ucfirst($prescription->status)); ?>

                </div>
            </div>
            <div class="mb-3">
                <strong>General Instructions:</strong>
                <div><?php echo e($prescription->instructions); ?></div>
            </div>
            <div class="mb-3">
                <strong>Medications:</strong>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Dosage</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $prescription->medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($med->name); ?></td>
                            <td><?php echo e($med->dosage); ?></td>
                            <td><?php echo e($med->instructions); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\prescriptions\show.blade.php ENDPATH**/ ?>