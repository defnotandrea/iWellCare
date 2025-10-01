<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['message' => 'Loading...', 'subtitle' => 'Please wait...', 'size' => 'default']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['message' => 'Loading...', 'subtitle' => 'Please wait...', 'size' => 'default']); ?>
<?php foreach (array_filter((['message' => 'Loading...', 'subtitle' => 'Please wait...', 'size' => 'default']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $sizeClasses = [
        'small' => 'w-8 h-8 border-2',
        'default' => 'w-12 h-12 border-3',
        'large' => 'w-16 h-16 border-4',
        'xl' => 'w-20 h-20 border-4'
    ];
    
    $textSizes = [
        'small' => 'text-sm',
        'default' => 'text-base',
        'large' => 'text-lg',
        'xl' => 'text-xl'
    ];
    
    $subtitleSizes = [
        'small' => 'text-xs',
        'default' => 'text-sm',
        'large' => 'text-base',
        'xl' => 'text-lg'
    ];
?>

<div class="flex flex-col items-center justify-center p-6">
    <div class="loading-spinner <?php echo e($sizeClasses[$size]); ?> border-gray-300 border-t-blue-600 rounded-full animate-spin"></div>
    
    <?php if($message): ?>
        <div class="mt-4 text-center">
            <div class="font-semibold text-gray-700 <?php echo e($textSizes[$size]); ?>"><?php echo e($message); ?></div>
            <?php if($subtitle): ?>
                <div class="text-gray-500 <?php echo e($subtitleSizes[$size]); ?> mt-1"><?php echo e($subtitle); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .loading-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\loading.blade.php ENDPATH**/ ?>