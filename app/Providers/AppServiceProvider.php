<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default string length for MySQL
        Schema::defaultStringLength(191);

        // Register custom Blade directives
        $this->registerBladeDirectives();

        // Register custom Gates
        $this->registerGates();
    }

    /**
     * Register custom Blade directives.
     */
    protected function registerBladeDirectives(): void
    {
        // Role directive
        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });

        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });

        // Permission directive
        Blade::directive('permission', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasPermissionTo({$expression})): ?>";
        });

        Blade::directive('endpermission', function () {
            return '<?php endif; ?>';
        });

        // Active menu directive
        Blade::directive('active', function ($expression) {
            return "<?php echo request()->is({$expression}) ? 'active' : ''; ?>";
        });
    }

    /**
     * Register custom Gates.
     */
    protected function registerGates(): void
    {
        // Admin gate
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        // Doctor gate
        Gate::define('doctor', function ($user) {
            return $user->isDoctor();
        });

        // Staff gate
        Gate::define('staff', function ($user) {
            return $user->isStaff();
        });

        // Patient gate
        Gate::define('patient', function ($user) {
            return $user->isPatient();
        });

        // Manage appointments gate
        Gate::define('manage-appointments', function ($user) {
            return in_array($user->role, ['admin', 'doctor', 'staff']);
        });

        // Manage patients gate
        Gate::define('manage-patients', function ($user) {
            return in_array($user->role, ['admin', 'doctor', 'staff']);
        });

        // Manage consultations gate
        Gate::define('manage-consultations', function ($user) {
            return in_array($user->role, ['admin', 'doctor']);
        });

        // Manage billing gate
        Gate::define('manage-billing', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        // Manage inventory gate
        Gate::define('manage-inventory', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        // View reports gate
        Gate::define('view-reports', function ($user) {
            return in_array($user->role, ['admin', 'doctor', 'staff']);
        });
    }
}
