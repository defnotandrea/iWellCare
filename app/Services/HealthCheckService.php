<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HealthCheckService
{
    /**
     * Perform comprehensive system health check
     */
    public static function performHealthCheck()
    {
        $healthStatus = [
            'overall_status' => 'healthy',
            'timestamp' => now(),
            'checks' => [],
        ];

        // Database connectivity check
        $healthStatus['checks']['database'] = self::checkDatabase();

        // Cache system check
        $healthStatus['checks']['cache'] = self::checkCache();

        // Storage check
        $healthStatus['checks']['storage'] = self::checkStorage();

        // Email system check
        $healthStatus['checks']['email'] = self::checkEmail();

        // Memory usage check
        $healthStatus['checks']['memory'] = self::checkMemory();

        // Disk space check
        $healthStatus['checks']['disk_space'] = self::checkDiskSpace();

        // Determine overall status
        $failedChecks = array_filter($healthStatus['checks'], function ($check) {
            return $check['status'] === 'failed';
        });

        if (count($failedChecks) > 0) {
            $healthStatus['overall_status'] = 'unhealthy';
        }

        return $healthStatus;
    }

    /**
     * Check database connectivity and performance
     */
    private static function checkDatabase()
    {
        try {
            $startTime = microtime(true);
            DB::select('SELECT 1');
            $responseTime = (microtime(true) - $startTime) * 1000;

            return [
                'status' => 'healthy',
                'response_time_ms' => round($responseTime, 2),
                'message' => 'Database connection successful',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'message' => 'Database connection failed',
            ];
        }
    }

    /**
     * Check cache system
     */
    private static function checkCache()
    {
        try {
            $testKey = 'health_check_'.time();
            $testValue = 'test_value';

            Cache::put($testKey, $testValue, 60);
            $retrievedValue = Cache::get($testKey);
            Cache::forget($testKey);

            if ($retrievedValue === $testValue) {
                return [
                    'status' => 'healthy',
                    'message' => 'Cache system working correctly',
                ];
            } else {
                return [
                    'status' => 'failed',
                    'message' => 'Cache system not working correctly',
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'message' => 'Cache system failed',
            ];
        }
    }

    /**
     * Check storage system
     */
    private static function checkStorage()
    {
        try {
            $testFile = 'health_check_'.time().'.txt';
            $testContent = 'Health check test content';

            Storage::put($testFile, $testContent);
            $retrievedContent = Storage::get($testFile);
            Storage::delete($testFile);

            if ($retrievedContent === $testContent) {
                return [
                    'status' => 'healthy',
                    'message' => 'Storage system working correctly',
                ];
            } else {
                return [
                    'status' => 'failed',
                    'message' => 'Storage system not working correctly',
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'message' => 'Storage system failed',
            ];
        }
    }

    /**
     * Check email system
     */
    private static function checkEmail()
    {
        try {
            // Test email configuration without sending
            $mailer = app('mailer');
            $transport = $mailer->getSwiftMailer()->getTransport();

            return [
                'status' => 'healthy',
                'message' => 'Email system configured correctly',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'message' => 'Email system configuration failed',
            ];
        }
    }

    /**
     * Check memory usage
     */
    private static function checkMemory()
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = ini_get('memory_limit');
        $memoryLimitBytes = self::convertToBytes($memoryLimit);
        $usagePercentage = ($memoryUsage / $memoryLimitBytes) * 100;

        $status = $usagePercentage > 90 ? 'warning' : 'healthy';

        return [
            'status' => $status,
            'usage_mb' => round($memoryUsage / 1024 / 1024, 2),
            'limit_mb' => round($memoryLimitBytes / 1024 / 1024, 2),
            'usage_percentage' => round($usagePercentage, 2),
            'message' => $status === 'warning' ? 'High memory usage detected' : 'Memory usage normal',
        ];
    }

    /**
     * Check disk space
     */
    private static function checkDiskSpace()
    {
        $freeBytes = disk_free_space(storage_path());
        $totalBytes = disk_total_space(storage_path());
        $usedBytes = $totalBytes - $freeBytes;
        $usagePercentage = ($usedBytes / $totalBytes) * 100;

        $status = $usagePercentage > 90 ? 'warning' : 'healthy';

        return [
            'status' => $status,
            'free_gb' => round($freeBytes / 1024 / 1024 / 1024, 2),
            'total_gb' => round($totalBytes / 1024 / 1024 / 1024, 2),
            'usage_percentage' => round($usagePercentage, 2),
            'message' => $status === 'warning' ? 'Low disk space detected' : 'Disk space normal',
        ];
    }

    /**
     * Convert memory limit string to bytes
     */
    private static function convertToBytes($memoryLimit)
    {
        $memoryLimit = trim($memoryLimit);
        $last = strtolower($memoryLimit[strlen($memoryLimit) - 1]);
        $memoryLimit = (int) $memoryLimit;

        switch ($last) {
            case 'g':
                $memoryLimit *= 1024;
            case 'm':
                $memoryLimit *= 1024;
            case 'k':
                $memoryLimit *= 1024;
        }

        return $memoryLimit;
    }

    /**
     * Get system metrics
     */
    public static function getSystemMetrics()
    {
        return [
            'uptime' => self::getUptime(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_time' => now()->toISOString(),
            'timezone' => config('app.timezone'),
            'environment' => config('app.env'),
        ];
    }

    /**
     * Get system uptime
     */
    private static function getUptime()
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();

            return [
                'load_1min' => $load[0],
                'load_5min' => $load[1],
                'load_15min' => $load[2],
            ];
        }

        return null;
    }
}
