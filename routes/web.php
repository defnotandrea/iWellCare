 <?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Auth\SimpleLoginController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OtpDisplayController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Invoice routes
Route::prefix('invoices')->name('invoices.')->group(function () {
    Route::get('/create', [App\Http\Controllers\InvoiceController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\InvoiceController::class, 'store'])->name('store');
    Route::get('/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [App\Http\Controllers\InvoiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\InvoiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\InvoiceController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/generate-pdf', [App\Http\Controllers\InvoiceController::class, 'generatePdf'])->name('generate-pdf');
    Route::get('/{id}/download-pdf', [App\Http\Controllers\InvoiceController::class, 'downloadPdf'])->name('download-pdf');
});

// Legal pages
Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

// Appointment booking routes
Route::get('/book-appointment', [App\Http\Controllers\AppointmentBookingController::class, 'showBookingForm'])->name('book.appointment');
Route::post('/book-appointment', [App\Http\Controllers\AppointmentBookingController::class, 'bookAppointment'])->name('book.appointment.store');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [SimpleLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SimpleLoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// OTP Verification routes
Route::get('/verify-email', [OtpVerificationController::class, 'showVerificationForm'])->name('otp.verify.form');
Route::post('/send-otp', [OtpVerificationController::class, 'sendOtp'])->name('otp.send');
Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [OtpVerificationController::class, 'resendOtp'])->name('otp.resend');
Route::post('/check-verification', [OtpVerificationController::class, 'checkVerificationStatus'])->name('otp.check');

// OTP Management routes (admin only)
Route::middleware(['auth', 'role:doctor', 'prevent.back'])->group(function () {
    Route::post('/admin/clear-expired-otp', [OtpVerificationController::class, 'clearExpiredOtpCodes'])->name('otp.clear-expired');
    Route::get('/admin/otp-stats', [OtpVerificationController::class, 'getOtpStats'])->name('otp.stats');
});

// Password Reset routes
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/password/resend-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resendOtp'])->name('password.resend-otp');
Route::get('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password/verify-otp', [App\Http\Controllers\Auth\ResetPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/password/check-verification', [App\Http\Controllers\Auth\ResetPasswordController::class, 'checkVerificationStatus'])->name('password.check-verification');

// Email Verification routes (for Laravel's default verification system)
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::post('/email/verification-notification', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');

Route::post('/logout', [SimpleLoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard redirect route
Route::get('/dashboard', function () {
    $user = auth()->user();

    if (! $user) {
        return redirect('/');
    }

    switch ($user->role) {
        case 'doctor':
        case 'admin':
            // Doctors and admins share the same dashboard
            return redirect()->route('admin.dashboard');
        case 'staff':
            return redirect()->route('staff.dashboard');
        case 'patient':
            return redirect()->route('patient.dashboard');
        default:
            return redirect('/');
    }
})->middleware(['auth', 'prevent.back'])->name('dashboard');

// Doctor routes (includes admin functionality)
Route::middleware(['auth', 'role:doctor', 'prevent.back'])->prefix('doctor')->name('doctor.')->group(function () {
	// Dashboard (alias to admin dashboard)
	Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Staff management
    Route::get('/staff-test', function () {
        $user = auth()->user();

        return "Current user: {$user->username}, Role: {$user->role}";
    })->name('staff.test');
    Route::resource('staff', \App\Http\Controllers\Doctor\StaffController::class);
    Route::patch('/staff/{id}/toggle-status', [\App\Http\Controllers\Doctor\StaffController::class, 'toggleStatus'])->name('staff.toggle-status');
    Route::resource('patients', \App\Http\Controllers\Doctor\PatientController::class)->except(['create', 'store']);

    // Appointment management (read-only for doctors)
    Route::get('/appointments', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/confirm', [\App\Http\Controllers\Doctor\AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::get('/appointments/{appointment}/confirm', function ($appointment) {
        return redirect()->route('doctor.appointments.index')->with('error', 'Please use the confirm button on the appointments page. Direct URL access is not allowed.');
    })->name('appointments.confirm.get');
    Route::post('/appointments/{appointment}/cancel', [\App\Http\Controllers\Doctor\AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/appointments/{appointment}/cancel', function ($appointment) {
        return redirect()->route('doctor.appointments.index')->with('error', 'Please use the cancel button on the appointments page. Direct URL access is not allowed.');
    })->name('appointments.cancel.get');
    Route::post('/appointments/{appointment}/complete', [\App\Http\Controllers\Doctor\AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::get('/appointments/by-date', [\App\Http\Controllers\Doctor\AppointmentController::class, 'getAppointmentsByDate'])->name('appointments.by-date');
    Route::get('/appointments/stats', [\App\Http\Controllers\Doctor\AppointmentController::class, 'getStats'])->name('appointments.stats');
    Route::get('/appointments/cancelled', [\App\Http\Controllers\Doctor\AppointmentController::class, 'getCancelledAppointments'])->name('appointments.cancelled');

    // Prescriptions
    Route::resource('prescriptions', \App\Http\Controllers\Doctor\PrescriptionController::class);
    Route::post('/prescriptions/{prescription}/complete', [\App\Http\Controllers\Doctor\PrescriptionController::class, 'complete'])->name('prescriptions.complete');
    Route::post('/prescriptions/{prescription}/cancel', [\App\Http\Controllers\Doctor\PrescriptionController::class, 'cancel'])->name('prescriptions.cancel');

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Doctor\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/monthly-sales', [\App\Http\Controllers\Doctor\ReportController::class, 'monthlySales'])->name('reports.monthly-sales');
    Route::get('/reports/patient-report', [\App\Http\Controllers\Doctor\ReportController::class, 'patientReport'])->name('reports.patient-report');
    Route::get('/reports/consultation-report', [\App\Http\Controllers\Doctor\ReportController::class, 'consultationReport'])->name('reports.consultation-report');
    Route::get('/reports/inventory-report', [\App\Http\Controllers\Doctor\ReportController::class, 'inventoryReport'])->name('reports.inventory-report');
    Route::post('/reports/export-pdf', [\App\Http\Controllers\Doctor\ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::post('/reports/export-excel', [\App\Http\Controllers\Doctor\ReportController::class, 'exportExcel'])->name('reports.export-excel');

    // Doctor Availability Management (Staff)
    Route::resource('doctor-availability', \App\Http\Controllers\Doctor\AvailabilityController::class)->names('staff.doctor-availability');
    Route::post('/doctor-availability/{doctor}/toggle', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'toggleAvailability'])->name('staff.doctor-availability.toggle');
    Route::post('/doctor-availability/{doctor}/set-unavailable', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'setUnavailable'])->name('staff.doctor-availability.set-unavailable');
    Route::post('/doctor-availability/{doctor}/set-available', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'setAvailable'])->name('staff.doctor-availability.set-available');
    Route::get('/doctor-availability/status', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'getAvailabilityStatus'])->name('staff.doctor-availability.status');

    // Patients
    Route::resource('patients', \App\Http\Controllers\Doctor\PatientController::class)->except(['create', 'store']);
    Route::get('/patients/{patient}/history', [\App\Http\Controllers\Doctor\PatientController::class, 'history'])->name('patients.history');

    // Inventory management (admin functions)
    Route::resource('inventory', \App\Http\Controllers\Doctor\InventoryController::class);
    Route::post('/inventory/{inventory}/adjust-stock', [\App\Http\Controllers\Doctor\InventoryController::class, 'adjustStock'])->name('inventory.adjust-stock');
    Route::post('/inventory/{inventory}/toggle-status', [\App\Http\Controllers\Doctor\InventoryController::class, 'toggleStatus'])->name('inventory.toggle-status');
    Route::post('/inventory/{inventory}/archive', [\App\Http\Controllers\Doctor\InventoryController::class, 'archive'])->name('inventory.archive');
    Route::delete('/inventory/{inventory}', [\App\Http\Controllers\Doctor\InventoryController::class, 'destroy'])->name('inventory.destroy');

    // Settings (admin functions)
    Route::get('/settings', [\App\Http\Controllers\Doctor\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Doctor\SettingController::class, 'update'])->name('settings.update');

    // Availability
    Route::get('/availability', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'index'])->name('availability.index');
    Route::post('/availability', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'update'])->name('availability.update');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\Doctor\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [\App\Http\Controllers\Doctor\ProfileController::class, 'update'])->name('profile.update');
});

// Patient routes
Route::middleware(['auth', 'role:patient', 'prevent.back'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboard::class, 'index'])->name('dashboard');

    // Appointments
    Route::get('/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [\App\Http\Controllers\Patient\AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [\App\Http\Controllers\Patient\AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [\App\Http\Controllers\Patient\AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/cancel', [\App\Http\Controllers\Patient\AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Consultations
    Route::get('/consultations', [\App\Http\Controllers\Patient\ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/{consultation}', [\App\Http\Controllers\Patient\ConsultationController::class, 'show'])->name('consultations.show');

    // Prescriptions
    Route::get('/prescriptions', [\App\Http\Controllers\Patient\PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('/prescriptions/{prescription}', [\App\Http\Controllers\Patient\PrescriptionController::class, 'show'])->name('prescriptions.show');

    // Medical records
    Route::get('/medical-records', [\App\Http\Controllers\Patient\MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/{record}', [\App\Http\Controllers\Patient\MedicalRecordController::class, 'show'])->name('medical-records.show');

    // Invoice
    Route::get('/invoice', [\App\Http\Controllers\Patient\InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/{invoice}', [\App\Http\Controllers\Patient\InvoiceController::class, 'show'])->name('invoice.show');

    // Invoice download route
    Route::get('/invoice/{invoice}/download', [App\Http\Controllers\Patient\InvoiceController::class, 'download'])->name('invoice.download');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [\App\Http\Controllers\Patient\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\Patient\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Patient\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [\App\Http\Controllers\Patient\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\Patient\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\Patient\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
});

// Staff routes
Route::middleware(['auth', 'role:staff', 'prevent.back'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');

    // Patients
    Route::resource('patients', \App\Http\Controllers\Staff\PatientController::class);
    Route::get('/patients/{patient}/history', [\App\Http\Controllers\Staff\PatientController::class, 'history'])->name('patients.history');

    // Appointments
    Route::resource('appointments', \App\Http\Controllers\Staff\AppointmentController::class);
    Route::post('/appointments/{appointment}/confirm', [\App\Http\Controllers\Staff\AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/decline', [\App\Http\Controllers\Staff\AppointmentController::class, 'decline'])->name('appointments.decline');
    Route::post('/appointments/{appointment}/complete', [\App\Http\Controllers\Staff\AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::get('/appointments/{appointment}/reschedule', [\App\Http\Controllers\Staff\AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
    Route::post('/appointments/{appointment}/reschedule', [\App\Http\Controllers\Staff\AppointmentController::class, 'updateReschedule'])->name('appointments.update-reschedule');

    // Consultations
    Route::resource('consultations', \App\Http\Controllers\Staff\ConsultationController::class);
    Route::get('/consultations/fetch-patient-data', [\App\Http\Controllers\Staff\ConsultationController::class, 'fetchPatientData'])->name('consultations.fetch-patient-data');

    // Invoice management (existing names)
    Route::get('/invoice', [\App\Http\Controllers\Staff\BillingController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/create', [\App\Http\Controllers\Staff\BillingController::class, 'create'])->name('invoice.create');
    Route::post('/invoice', [\App\Http\Controllers\Staff\BillingController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{id}/generate-pdf', [\App\Http\Controllers\Staff\BillingController::class, 'generatePdf'])->name('invoice.generate-pdf');
    Route::post('/invoice/{id}/mark-as-paid', [\App\Http\Controllers\Staff\BillingController::class, 'markAsPaid'])->name('invoice.mark-as-paid');
    Route::delete('/invoice/{id}', [\App\Http\Controllers\Staff\BillingController::class, 'destroy'])->name('invoice.destroy');

    // Billing route name aliases for views expecting staff.billing.*
    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Staff\BillingController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Staff\BillingController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Staff\BillingController::class, 'store'])->name('store');
    });

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Staff\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/appointments', [\App\Http\Controllers\Staff\ReportController::class, 'appointments'])->name('reports.appointments');
    Route::get('/reports/consultations', [\App\Http\Controllers\Staff\ReportController::class, 'consultations'])->name('reports.consultations');
    Route::get('/reports/inventory', [\App\Http\Controllers\Staff\ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/patients', [\App\Http\Controllers\Staff\ReportController::class, 'patients'])->name('reports.patients');
    Route::post('/reports/export', [\App\Http\Controllers\Staff\ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/export-pdf', [\App\Http\Controllers\Staff\ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    Route::get('/reports/export-inventory-pdf', [\App\Http\Controllers\Staff\ReportController::class, 'exportInventoryPdf'])->name('reports.exportInventoryPdf');

    // Inventory management
    Route::resource('inventory', \App\Http\Controllers\Staff\InventoryController::class);

    // Prescriptions
    Route::resource('prescriptions', \App\Http\Controllers\Staff\PrescriptionController::class);

    // Doctor Availability Management
    Route::resource('doctor-availability', \App\Http\Controllers\Staff\DoctorAvailabilityController::class);
    Route::post('/doctor-availability/{id}/toggle-status', [\App\Http\Controllers\Staff\DoctorAvailabilityController::class, 'toggleStatus'])->name('doctor-availability.toggle-status');
    Route::get('/doctor-availability/get-availability', [\App\Http\Controllers\Staff\DoctorAvailabilityController::class, 'getAvailability'])->name('doctor-availability.get-availability');
    Route::post('/doctor-availability/bulk-update', [\App\Http\Controllers\Staff\DoctorAvailabilityController::class, 'bulkUpdate'])->name('doctor-availability.bulk-update');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\Staff\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [\App\Http\Controllers\Staff\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\Staff\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\Staff\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Other staff routes can be added here as needed
});

// Admin routes
Route::middleware(['auth', 'role:doctor', 'prevent.back'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/', [AdminDashboard::class, 'index'])->name('index');

    // Team Management (Staff)
    Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);
    Route::patch('/staff/{staff}/toggle-status', [\App\Http\Controllers\Admin\StaffController::class, 'toggleStatus'])->name('staff.toggle-status');
    // Accept POST as well to avoid MethodNotAllowed if method spoofing fails on some clients
    Route::post('/staff/{staff}/toggle-status', [\App\Http\Controllers\Admin\StaffController::class, 'toggleStatus']);

    // Use Doctor controllers for consistency (no duplication)
    Route::resource('patients', \App\Http\Controllers\Doctor\PatientController::class)->except(['create', 'store']);
    Route::get('/patients/{patient}/history', [\App\Http\Controllers\Doctor\PatientController::class, 'history'])->name('patients.history');

    Route::get('/appointments', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/confirm', [\App\Http\Controllers\Doctor\AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/cancel', [\App\Http\Controllers\Doctor\AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{appointment}/complete', [\App\Http\Controllers\Doctor\AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::get('/appointments/by-date', [\App\Http\Controllers\Doctor\AppointmentController::class, 'getAppointmentsByDate'])->name('appointments.by-date');
    Route::get('/appointments/stats', [\App\Http\Controllers\Doctor\AppointmentController::class, 'getStats'])->name('appointments.stats');
    Route::get('/appointments/cancelled', [\App\Http\Controllers\Doctor\AppointmentController::class, 'getCancelledAppointments'])->name('appointments.cancelled');

    Route::resource('consultations', \App\Http\Controllers\Doctor\ConsultationController::class);
    Route::resource('prescriptions', \App\Http\Controllers\Doctor\PrescriptionController::class);
    Route::post('/prescriptions/{prescription}/complete', [\App\Http\Controllers\Doctor\PrescriptionController::class, 'complete'])->name('prescriptions.complete');
    Route::post('/prescriptions/{prescription}/cancel', [\App\Http\Controllers\Doctor\PrescriptionController::class, 'cancel'])->name('prescriptions.cancel');

    // Reports (using doctor report controller)
    Route::get('/reports', [\App\Http\Controllers\Doctor\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/monthly-sales', [\App\Http\Controllers\Doctor\ReportController::class, 'monthlySales'])->name('reports.monthly-sales');
    Route::get('/reports/patient-report', [\App\Http\Controllers\Doctor\ReportController::class, 'patientReport'])->name('reports.patient-report');
    Route::get('/reports/consultation-report', [\App\Http\Controllers\Doctor\ReportController::class, 'consultationReport'])->name('reports.consultation-report');
    Route::get('/reports/inventory-report', [\App\Http\Controllers\Doctor\ReportController::class, 'inventoryReport'])->name('reports.inventory-report');
    Route::post('/reports/export-pdf', [\App\Http\Controllers\Doctor\ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::post('/reports/export-excel', [\App\Http\Controllers\Doctor\ReportController::class, 'exportExcel'])->name('reports.export-excel');

    // Inventory management (using doctor inventory controller)
    Route::resource('inventory', \App\Http\Controllers\Doctor\InventoryController::class);
    Route::post('/inventory/{inventory}/adjust-stock', [\App\Http\Controllers\Doctor\InventoryController::class, 'adjustStock'])->name('inventory.adjust-stock');
    Route::post('/inventory/{inventory}/toggle-status', [\App\Http\Controllers\Doctor\InventoryController::class, 'toggleStatus'])->name('inventory.toggle-status');
    Route::post('/inventory/{inventory}/archive', [\App\Http\Controllers\Doctor\InventoryController::class, 'archive'])->name('inventory.archive');
    Route::delete('/inventory/{inventory}', [\App\Http\Controllers\Doctor\InventoryController::class, 'destroy'])->name('inventory.destroy');

    // Invoice management
    Route::get('/invoice', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/create', [\App\Http\Controllers\Admin\InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice', [\App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{id}/pdf', [\App\Http\Controllers\Admin\InvoiceController::class, 'generatePdf'])->name('invoice.generate-pdf');
    Route::get('/invoice/{id}/mark-as-paid', [\App\Http\Controllers\Admin\InvoiceController::class, 'markAsPaid'])->name('invoice.mark-as-paid');
    Route::delete('/invoice/{id}', [\App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('invoice.destroy');

    // Doctor Availability Management
    Route::resource('doctor-availability', \App\Http\Controllers\Doctor\AvailabilityController::class);
    Route::post('/doctor-availability/{doctor}/toggle', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'toggleAvailability'])->name('doctor-availability.toggle');
    Route::post('/doctor-availability/{doctor}/set-unavailable', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'setUnavailable'])->name('doctor-availability.set-unavailable');
    Route::post('/doctor-availability/{doctor}/set-available', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'setAvailable'])->name('doctor-availability.set-available');
    Route::get('/doctor-availability/status', [\App\Http\Controllers\Doctor\AvailabilityController::class, 'getAvailabilityStatus'])->name('doctor-availability.status');
});

Route::middleware(['auth', 'prevent.back'])->prefix('api')->name('api.')->group(function () {
    Route::get('/doctors/available', [\App\Http\Controllers\Api\DoctorController::class, 'available'])->name('doctors.available');
    Route::get('/appointments/calendar', [\App\Http\Controllers\Api\AppointmentController::class, 'calendar'])->name('appointments.calendar');
    Route::get('/patients/search', [\App\Http\Controllers\Api\PatientController::class, 'search'])->name('patients.search');
    Route::get('/medications/search', [\App\Http\Controllers\Api\MedicationController::class, 'search'])->name('medications.search');

    // Real-time updates
    Route::get('/real-time/updates', [\App\Http\Controllers\RealTimeController::class, 'getUpdates'])->name('real-time.updates');
    Route::get('/real-time/stats', [\App\Http\Controllers\RealTimeController::class, 'getDashboardStats'])->name('real-time.stats');
    Route::post('/real-time/notifications/mark-read', [\App\Http\Controllers\RealTimeController::class, 'markNotificationsAsRead'])->name('real-time.notifications.mark-read');
});

// Test route for verification page
Route::get('/test-verification', function () {
    $email = session('verification_email');

    return view('test-verification', compact('email'));
})->name('test.verification');

// OTP Display routes
Route::get('/otp-codes', [OtpDisplayController::class, 'index'])->name('otp.codes');
Route::get('/otp-codes/refresh', [OtpDisplayController::class, 'getOtpCodes'])->name('otp.codes.refresh');
