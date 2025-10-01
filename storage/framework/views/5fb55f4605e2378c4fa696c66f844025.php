<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Verification Page</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/icon.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('assets/img/icon.png')); ?>">
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h1 class="text-2xl font-bold text-center mb-6">Test Verification Page</h1>
            
            <div class="space-y-4">
                <div class="bg-blue-100 p-4 rounded">
                    <h2 class="font-semibold">Debug Information:</h2>
                    <p>Email: <?php echo e($email ?? 'No email'); ?></p>
                    <p>Authenticated: <?php echo e(auth()->check() ? 'Yes' : 'No'); ?></p>
                    <?php if(auth()->check()): ?>
                        <p>User: <?php echo e(auth()->user()->email); ?></p>
                    <?php endif; ?>
                </div>
                
                <?php if($email): ?>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Enter OTP Code:</label>
                            <input type="text" class="w-full p-3 border rounded" placeholder="000000" maxlength="6">
                        </div>
                        <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">
                            Verify Email
                        </button>
                    </form>
                <?php else: ?>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Enter Email:</label>
                            <input type="email" class="w-full p-3 border rounded" placeholder="your@email.com">
                        </div>
                        <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">
                            Send Verification Code
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\test-verification.blade.php ENDPATH**/ ?>