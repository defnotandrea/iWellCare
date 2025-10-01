<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Codes - iWellCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">
                            <i class="fas fa-key text-blue-600 mr-3"></i>
                            OTP Verification Codes
                        </h1>
                        <p class="text-gray-600 mt-2">Recent verification codes sent via email</p>
                    </div>
                    <div class="text-right">
                        <button onclick="refreshCodes()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Email Status Alert -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Email Service Notice:</strong> 
                            Email delivery is currently using fallback mode. OTP codes are logged here for verification.
                            To enable email delivery, configure Gmail SMTP with an App Password.
                        </p>
                    </div>
                </div>
            </div>

            <!-- OTP Codes List -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Recent OTP Codes</h2>
                    <p class="text-gray-600 text-sm mt-1">Codes are valid for 10 minutes from generation time</p>
                </div>
                
                <div id="otp-codes-container">
                    @if(count($otpCodes) > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($otpCodes as $otp)
                                <div class="p-6 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $otp['Name'] ?? 'Unknown User' }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $otp['Email'] ?? 'No email' }}
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        Type: {{ $otp['Type'] ?? 'Unknown' }} | 
                                                        Expires: {{ $otp['Expires'] ?? 'Unknown' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg font-mono text-lg font-bold">
                                                {{ $otp['OTP Code'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No OTP Codes Found</h3>
                            <p class="text-gray-500">No recent verification codes have been generated.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    How to Use
                </h3>
                <ul class="text-blue-800 space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-blue-600 mr-2 mt-1"></i>
                        <span>When you request an OTP code, it will appear in this list</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-blue-600 mr-2 mt-1"></i>
                        <span>Use the 6-digit code shown in the blue box for verification</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-blue-600 mr-2 mt-1"></i>
                        <span>Codes expire after 10 minutes for security</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-blue-600 mr-2 mt-1"></i>
                        <span>This page auto-refreshes every 30 seconds</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh every 30 seconds
        setInterval(function() {
            refreshCodes();
        }, 30000);

        function refreshCodes() {
            fetch('/otp-codes/refresh', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateOtpCodes(data.otp_codes);
                }
            })
            .catch(error => {
                console.error('Error refreshing codes:', error);
            });
        }

        function updateOtpCodes(otpCodes) {
            const container = document.getElementById('otp-codes-container');
            
            if (otpCodes.length === 0) {
                container.innerHTML = `
                    <div class="p-12 text-center">
                        <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No OTP Codes Found</h3>
                        <p class="text-gray-500">No recent verification codes have been generated.</p>
                    </div>
                `;
                return;
            }

            let html = '<div class="divide-y divide-gray-200">';
            otpCodes.forEach(otp => {
                html += `
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            ${otp.Name || 'Unknown User'}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            ${otp.Email || 'No email'}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Type: ${otp.Type || 'Unknown'} | 
                                            Expires: ${otp.Expires || 'Unknown'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg font-mono text-lg font-bold">
                                    ${otp['OTP Code'] || 'N/A'}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
    </script>
</body>
</html>
