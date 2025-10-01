<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CompatibilityService
{
    /**
     * Detect browser and device capabilities
     */
    public static function detectBrowserCapabilities($userAgent)
    {
        $cacheKey = 'browser_capabilities_'.md5($userAgent);

        return Cache::remember($cacheKey, 1440, function () use ($userAgent) {
            $capabilities = [
                'browser' => self::detectBrowser($userAgent),
                'version' => self::detectBrowserVersion($userAgent),
                'os' => self::detectOperatingSystem($userAgent),
                'device' => self::detectDevice($userAgent),
                'features' => self::detectFeatures($userAgent),
                'compatibility' => self::checkCompatibility($userAgent),
            ];

            return $capabilities;
        });
    }

    /**
     * Detect browser type
     */
    private static function detectBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Edge';
        } elseif (strpos($userAgent, 'Opera') !== false) {
            return 'Opera';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Detect browser version
     */
    private static function detectBrowserVersion($userAgent)
    {
        $patterns = [
            'Chrome' => '/Chrome\/([0-9.]+)/',
            'Firefox' => '/Firefox\/([0-9.]+)/',
            'Safari' => '/Version\/([0-9.]+)/',
            'Edge' => '/Edge\/([0-9.]+)/',
            'Opera' => '/Opera\/([0-9.]+)/',
        ];

        foreach ($patterns as $browser => $pattern) {
            if (preg_match($pattern, $userAgent, $matches)) {
                return $matches[1];
            }
        }

        return 'Unknown';
    }

    /**
     * Detect operating system
     */
    private static function detectOperatingSystem($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) {
            return 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            return 'macOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            return 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            return 'Android';
        } elseif (strpos($userAgent, 'iOS') !== false) {
            return 'iOS';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Detect device type
     */
    private static function detectDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            return 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

    /**
     * Detect browser features
     */
    private static function detectFeatures($userAgent)
    {
        $features = [
            'localStorage' => true,
            'sessionStorage' => true,
            'geolocation' => true,
            'webgl' => true,
            'websockets' => true,
            'service_workers' => false,
            'push_notifications' => false,
            'web_assembly' => false,
        ];

        // Detect service workers support
        if (strpos($userAgent, 'Chrome') !== false && version_compare(self::detectBrowserVersion($userAgent), '45.0', '>=')) {
            $features['service_workers'] = true;
        }

        // Detect push notifications support
        if (strpos($userAgent, 'Chrome') !== false && version_compare(self::detectBrowserVersion($userAgent), '42.0', '>=')) {
            $features['push_notifications'] = true;
        }

        // Detect WebAssembly support
        if (strpos($userAgent, 'Chrome') !== false && version_compare(self::detectBrowserVersion($userAgent), '57.0', '>=')) {
            $features['web_assembly'] = true;
        }

        return $features;
    }

    /**
     * Check browser compatibility
     */
    private static function checkCompatibility($userAgent)
    {
        $browser = self::detectBrowser($userAgent);
        $version = self::detectBrowserVersion($userAgent);

        $compatibility = [
            'supported' => true,
            'level' => 'full',
            'warnings' => [],
            'recommendations' => [],
        ];

        // Check minimum version requirements
        $minVersions = [
            'Chrome' => '70.0',
            'Firefox' => '65.0',
            'Safari' => '12.0',
            'Edge' => '79.0',
            'Opera' => '57.0',
        ];

        if (isset($minVersions[$browser])) {
            if (version_compare($version, $minVersions[$browser], '<')) {
                $compatibility['supported'] = false;
                $compatibility['level'] = 'unsupported';
                $compatibility['warnings'][] = "Your browser version is outdated. Please update to version {$minVersions[$browser]} or higher.";
                $compatibility['recommendations'][] = 'Update your browser to the latest version for the best experience.';
            }
        }

        // Check for unsupported browsers
        if ($browser === 'Unknown') {
            $compatibility['supported'] = false;
            $compatibility['level'] = 'unknown';
            $compatibility['warnings'][] = 'Your browser is not recognized. Some features may not work properly.';
            $compatibility['recommendations'][] = 'Please use a modern browser like Chrome, Firefox, Safari, or Edge.';
        }

        return $compatibility;
    }

    /**
     * Get responsive breakpoints
     */
    public static function getResponsiveBreakpoints()
    {
        return [
            'mobile' => [
                'min' => 0,
                'max' => 767,
                'description' => 'Mobile devices',
            ],
            'tablet' => [
                'min' => 768,
                'max' => 1023,
                'description' => 'Tablet devices',
            ],
            'desktop' => [
                'min' => 1024,
                'max' => 1439,
                'description' => 'Desktop devices',
            ],
            'large_desktop' => [
                'min' => 1440,
                'max' => 9999,
                'description' => 'Large desktop devices',
            ],
        ];
    }

    /**
     * Get device-specific optimizations
     */
    public static function getDeviceOptimizations($device)
    {
        $optimizations = [
            'Mobile' => [
                'touch_optimized' => true,
                'reduced_animations' => true,
                'simplified_navigation' => true,
                'large_touch_targets' => true,
                'swipe_gestures' => true,
            ],
            'Tablet' => [
                'touch_optimized' => true,
                'hybrid_navigation' => true,
                'medium_touch_targets' => true,
                'swipe_gestures' => true,
                'landscape_optimized' => true,
            ],
            'Desktop' => [
                'keyboard_navigation' => true,
                'hover_effects' => true,
                'full_animations' => true,
                'multi_column_layout' => true,
                'advanced_interactions' => true,
            ],
        ];

        return $optimizations[$device] ?? $optimizations['Desktop'];
    }

    /**
     * Generate compatibility report
     */
    public static function generateCompatibilityReport($userAgent)
    {
        $capabilities = self::detectBrowserCapabilities($userAgent);
        $breakpoints = self::getResponsiveBreakpoints();
        $optimizations = self::getDeviceOptimizations($capabilities['device']);

        return [
            'browser_info' => $capabilities,
            'responsive_breakpoints' => $breakpoints,
            'device_optimizations' => $optimizations,
            'recommendations' => self::getRecommendations($capabilities),
            'timestamp' => now(),
        ];
    }

    /**
     * Get recommendations based on capabilities
     */
    private static function getRecommendations($capabilities)
    {
        $recommendations = [];

        if (! $capabilities['compatibility']['supported']) {
            $recommendations[] = 'Update your browser to the latest version';
        }

        if ($capabilities['device'] === 'Mobile') {
            $recommendations[] = 'Use the mobile app for the best experience';
        }

        if (! $capabilities['features']['service_workers']) {
            $recommendations[] = 'Enable service workers for offline functionality';
        }

        if (! $capabilities['features']['push_notifications']) {
            $recommendations[] = 'Enable push notifications for important updates';
        }

        return $recommendations;
    }

    /**
     * Check if feature is supported
     */
    public static function isFeatureSupported($feature, $userAgent)
    {
        $capabilities = self::detectBrowserCapabilities($userAgent);

        return $capabilities['features'][$feature] ?? false;
    }

    /**
     * Get fallback options for unsupported features
     */
    public static function getFallbackOptions($feature)
    {
        $fallbacks = [
            'localStorage' => 'sessionStorage',
            'sessionStorage' => 'cookies',
            'geolocation' => 'manual_location_input',
            'webgl' => 'canvas_2d',
            'websockets' => 'polling',
            'service_workers' => 'regular_caching',
            'push_notifications' => 'email_notifications',
            'web_assembly' => 'javascript_fallback',
        ];

        return $fallbacks[$feature] ?? null;
    }
}
