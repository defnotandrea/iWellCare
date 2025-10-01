

<?php $__env->startSection('content'); ?>
<style>
    .modal-bg {
        position: fixed;
        inset: 0;
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0.35);
        min-height: 100vh;
    }
    .modal-box {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(30,34,90,0.12);
        padding: 2.5rem 2rem 2rem 2rem;
        width: 100%;
        max-width: 600px;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
    }
    .modal-close {
        position: absolute;
        top: 1.25rem;
        right: 1.5rem;
        font-size: 2rem;
        color: #bbb;
        background: none;
        border: none;
        font-weight: bold;
        cursor: pointer;

    }
    .modal-close:hover { color: #333; }
    .iwc-form-label { font-weight: 600; color: #333; margin-bottom: 0.5rem; display: block; }
    .iwc-form-control, .iwc-form-select {
        border-radius: 0.75rem;
        border: 1px solid #e0e0e0;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        width: 100%;
        margin-bottom: 1.5rem;
        background: #fafbfc;

    }
    .iwc-form-control:focus, .iwc-form-select:focus {
        border-color: #7c3aed;
        outline: none;
        background: #fff;
    }
    .iwc-medication-section { margin-bottom: 2rem; }
    .iwc-medication-row { display: flex; gap: 1rem; margin-bottom: 0.75rem; }
    .iwc-medication-row input { flex: 1; }
    .iwc-add-med-btn {
        background: #ede9fe;
        color: #6d28d9;
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;

    }
    .iwc-add-med-btn:hover { background: #c7d2fe; color: #312e81; }
    .iwc-btn-group { display: flex; gap: 1rem; margin-top: 2.5rem; justify-content: center; }
    @media (max-width: 600px) {
        .modal-box { padding: 1.25rem 0.5rem; max-width: 100vw; }
        .iwc-medication-row { flex-direction: column; gap: 0.5rem; }
        .iwc-btn-group { flex-direction: column; gap: 0.75rem; }
    }
</style>
<div class="modal-bg" id="prescriptionModal">
    <div class="modal-box">
        <button class="modal-close" id="closeModalBtn">&times;</button>
        <h2 class="text-center mb-5" style="font-weight:700; font-size:2rem;">New Prescription</h2>
        <form action="<?php echo e(route('doctor.prescriptions.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label for="patient_id" class="iwc-form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="iwc-form-select" required>
                    <option value="">Select Patient</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id') == $patient->id ? 'selected' : ''); ?>>
                            <?php echo e($patient->user->first_name); ?> <?php echo e($patient->user->last_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="doctor_id" class="iwc-form-label">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="iwc-form-select" required>
                    <option value="">Select Doctor</option>
                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id') == $doctor->id ? 'selected' : ''); ?>>
                            <?php echo e($doctor->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="iwc-medication-section">
                <label class="iwc-form-label">Medications</label>
                <div id="medications-section">
                    <div class="iwc-medication-row medication-row">
                        <input type="text" name="medications[0][name]" class="iwc-form-control" placeholder="Medication Name" required>
                        <input type="text" name="medications[0][dosage]" class="iwc-form-control" placeholder="Dosage" required>
                        <input type="text" name="medications[0][instructions]" class="iwc-form-control" placeholder="Instructions">
                        <button type="button" class="btn btn-danger btn-remove-medication" style="display:none;">&times;</button>
                    </div>
                </div>
                <button type="button" class="iwc-add-med-btn" id="add-medication">Add Medication</button>
            </div>
            <div class="mb-4">
                <label for="prescription_date" class="iwc-form-label">Date</label>
                <input type="date" name="prescription_date" id="prescription_date" class="iwc-form-control" value="<?php echo e(old('prescription_date', date('Y-m-d'))); ?>" required>
            </div>
            <div class="mb-4">
                <label for="status" class="iwc-form-label">Status</label>
                <select name="status" id="status" class="iwc-form-select" required>
                    <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="completed" <?php echo e(old('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="instructions" class="iwc-form-label">General Instructions</label>
                <textarea name="instructions" id="instructions" class="iwc-form-control" rows="3"><?php echo e(old('instructions')); ?></textarea>
            </div>
            <div class="iwc-btn-group">
                <button type="submit" class="btn btn-primary shadow rounded-pill px-4 py-2" style="font-weight: 500; font-size: 1rem;">Save Prescription</button>
                <a href="<?php echo e(route('doctor.prescriptions.index')); ?>" class="btn btn-secondary rounded-pill px-4 py-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    // Show modal on page load
    document.body.style.overflow = 'hidden';
    document.getElementById('closeModalBtn').onclick = function() {
        window.location.href = "<?php echo e(route('doctor.prescriptions.index')); ?>";
    };
    // Add medication logic for modal
    let medIndex = 1;
    document.getElementById('add-medication').addEventListener('click', function() {
        const section = document.getElementById('medications-section');
        const row = document.createElement('div');
        row.className = 'iwc-medication-row medication-row';
        row.innerHTML = `
            <input type="text" name="medications[${medIndex}][name]" class="iwc-form-control" placeholder="Medication Name" required>
            <input type="text" name="medications[${medIndex}][dosage]" class="iwc-form-control" placeholder="Dosage" required>
            <input type="text" name="medications[${medIndex}][instructions]" class="iwc-form-control" placeholder="Instructions">
            <button type="button" class="btn btn-danger btn-remove-medication">&times;</button>
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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\prescriptions\create.blade.php ENDPATH**/ ?>