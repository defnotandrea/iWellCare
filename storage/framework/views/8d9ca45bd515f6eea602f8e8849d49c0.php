<?php if(session('success') || session('error') || session('warning') || session('info')): ?>
<div id="alertModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
        <div class="px-8 py-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <?php if(session('success')): ?>
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Success</h3>
                            <p class="text-gray-600 text-sm">Operation completed successfully</p>
                        </div>
                    <?php elseif(session('error')): ?>
                        <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-exclamation-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Error</h3>
                            <p class="text-gray-600 text-sm">Something went wrong</p>
                        </div>
                    <?php elseif(session('warning')): ?>
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Warning</h3>
                            <p class="text-gray-600 text-sm">Please take note</p>
                        </div>
                    <?php elseif(session('info')): ?>
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Information</h3>
                            <p class="text-gray-600 text-sm">Important information</p>
                        </div>
                    <?php endif; ?>
                </div>
                <button onclick="closeAlertModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <?php if(session('success')): ?>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                        <p class="text-green-700"><?php echo e(session('success')); ?></p>
                    </div>
                <?php elseif(session('error')): ?>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                        <p class="text-red-700"><?php echo e(session('error')); ?></p>
                    </div>
                <?php elseif(session('warning')): ?>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <p class="text-yellow-700"><?php echo e(session('warning')); ?></p>
                    </div>
                <?php elseif(session('info')): ?>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                        <p class="text-blue-700"><?php echo e(session('info')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="flex justify-end">
                <button onclick="closeAlertModal()" 
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function showAlertModal() {
        const modal = document.getElementById('alertModal');
        if (modal) {
            modal.style.display = 'flex';

        }
    }
    
    function closeAlertModal() {
        const modal = document.getElementById('alertModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        showAlertModal();
    });
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('alertModal');
        if (modal && e.target === modal) {
            closeAlertModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAlertModal();
        }
    });
</script>
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\staff\partials\alert-modal.blade.php ENDPATH**/ ?>