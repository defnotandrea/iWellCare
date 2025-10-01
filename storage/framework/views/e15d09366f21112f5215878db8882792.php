<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'id' => 'modal',
    'title' => '',
    'type' => 'default', // default, success, warning, danger, info
    'size' => 'modal-dialog-centered', // modal-sm, modal-lg, modal-xl, modal-dialog-centered
    'closeButton' => true,
    'footer' => true
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'id' => 'modal',
    'title' => '',
    'type' => 'default', // default, success, warning, danger, info
    'size' => 'modal-dialog-centered', // modal-sm, modal-lg, modal-xl, modal-dialog-centered
    'closeButton' => true,
    'footer' => true
]); ?>
<?php foreach (array_filter(([
    'id' => 'modal',
    'title' => '',
    'type' => 'default', // default, success, warning, danger, info
    'size' => 'modal-dialog-centered', // modal-sm, modal-lg, modal-xl, modal-dialog-centered
    'closeButton' => true,
    'footer' => true
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $typeClasses = [
        'default' => ['header' => 'bg-primary text-white', 'icon' => 'fas fa-info-circle'],
        'success' => ['header' => 'bg-success text-white', 'icon' => 'fas fa-check-circle'],
        'warning' => ['header' => 'bg-warning text-dark', 'icon' => 'fas fa-exclamation-triangle'],
        'danger' => ['header' => 'bg-danger text-white', 'icon' => 'fas fa-exclamation-circle'],
        'info' => ['header' => 'bg-info text-white', 'icon' => 'fas fa-info-circle']
    ];
    
    $currentType = $typeClasses[$type] ?? $typeClasses['default'];
?>

<div class="modal fade" id="<?php echo e($id); ?>" tabindex="-1" aria-labelledby="<?php echo e($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog <?php echo e($size); ?>">
        <div class="modal-content">
            <div class="modal-header <?php echo e($currentType['header']); ?>">
                <h5 class="modal-title" id="<?php echo e($id); ?>Label">
                    <i class="<?php echo e($currentType['icon']); ?> me-2"></i><?php echo e($title); ?>

                </h5>
                <?php if($closeButton): ?>
                    <button type="button" class="btn-close <?php echo e($type === 'warning' ? '' : 'btn-close-white'); ?>" data-bs-dismiss="modal" aria-label="Close"></button>
                <?php endif; ?>
            </div>
            <div class="modal-body">
                <?php echo e($slot); ?>

            </div>
            <?php if($footer): ?>
                <div class="modal-footer">
                    <?php echo e($footer ?? ''); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\modal.blade.php ENDPATH**/ ?>