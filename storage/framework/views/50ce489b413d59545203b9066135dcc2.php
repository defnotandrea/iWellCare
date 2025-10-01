

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2>Edit Prescription</h2>
    <form action="<?php echo e(route('doctor.prescriptions.update', $prescription)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="patient_id" class="form-label">Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control" required>
                            <option value="">Select Patient</option>
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id', $prescription->patient_id) == $patient->id ? 'selected' : ''); ?>>
                                    <?php echo e($patient->user->first_name); ?> <?php echo e($patient->user->last_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="doctor_id" class="form-label">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-control" required>
                            <option value="">Select Doctor</option>
                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id', $prescription->doctor_id) == $doctor->id ? 'selected' : ''); ?>>
                                    <?php echo e($doctor->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div id="medications-section">
                    <label class="form-label">Medications</label>
                    <?php $__currentLoopData = $prescription->medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row mb-2 medication-row">
                        <div class="col-md-5">
                            <input type="text" name="medications[<?php echo e($i); ?>][name]" class="form-control" placeholder="Medication Name" value="<?php echo e($med->name); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="medications[<?php echo e($i); ?>][dosage]" class="form-control" placeholder="Dosage" value="<?php echo e($med->dosage); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="medications[<?php echo e($i); ?>][instructions]" class="form-control" placeholder="Instructions" value="<?php echo e($med->instructions); ?>">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-remove-medication" <?php echo e($i == 0 ? 'style=display:none;' : ''); ?>>&times;</button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button type="button" class="btn btn-secondary mb-3" id="add-medication">Add Medication</button>
                <div class="mb-3">
                    <label for="prescription_date" class="form-label">Date</label>
                    <input type="date" name="prescription_date" id="prescription_date" class="form-control" value="<?php echo e(old('prescription_date', $prescription->prescription_date->format('Y-m-d'))); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="instructions" class="form-label">General Instructions</label>
                    <textarea name="instructions" id="instructions" class="form-control" rows="3"><?php echo e(old('instructions', $prescription->instructions)); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" <?php echo e(old('status', $prescription->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="completed" <?php echo e(old('status', $prescription->status) == 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e(old('status', $prescription->status) == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Prescription</button>
                <a href="<?php echo e(route('doctor.prescriptions.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let medIndex = <?php echo e(count($prescription->medications)); ?>;
    document.getElementById('add-medication').addEventListener('click', function() {
        const section = document.getElementById('medications-section');
        const row = document.createElement('div');
        row.className = 'row mb-2 medication-row';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="medications[${medIndex}][name]" class="form-control" placeholder="Medication Name" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="medications[${medIndex}][dosage]" class="form-control" placeholder="Dosage" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="medications[${medIndex}][instructions]" class="form-control" placeholder="Instructions">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-remove-medication">&times;</button>
            </div>
        `;
        section.appendChild(row);
        medIndex++;
    });
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-medication')) {
            e.target.closest('.medication-row').remove();
        }
    });
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\prescriptions\edit.blade.php ENDPATH**/ ?>