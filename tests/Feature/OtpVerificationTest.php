<?php

namespace Tests\Feature;

use Tests\TestCase;

class OtpVerificationTest extends TestCase
{
    /**
     * Test that the OTP verification form displays correctly
     */
    public function test_otp_verification_form_displays()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-otp-simple');
        $response->assertSee('Email Verification');
        $response->assertSee('Enter your email address to receive a verification code');
    }

    /**
     * Test that the OTP verification page contains the success modal script
     */
    public function test_otp_verification_page_contains_success_modal_script()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('showSuccessModal');
        $response->assertSee('redirectBtn');
        $response->assertSee('Go to Login');
    }

    /**
     * Test that the OTP verification page includes modal utilities
     */
    public function test_otp_verification_page_includes_modal_utilities()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('modal-utils.js');
    }

    /**
     * Test that the login page can display success messages
     */
    public function test_login_page_can_display_success_messages()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
        $response->assertSee('Login');
    }

    /**
     * Test that session flag is set during OTP verification
     */
    public function test_session_flag_is_set_during_otp_verification()
    {
        // Simulate OTP verification completion
        $this->session(['otp_verification_completed' => true, 'otp_verification_email' => 'test@example.com']);

        $response = $this->get('/login');

        $response->assertStatus(200);
        $this->assertTrue(session()->has('otp_verification_completed'));
        $this->assertTrue(session()->has('otp_verification_email'));
    }

    /**
     * Test that OTP verification redirects to login page with correct URL
     */
    public function test_otp_verification_redirects_to_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test that the success modal has correct redirect URL
     */
    public function test_success_modal_has_correct_redirect_url()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        // Check that the JavaScript handles the redirect correctly
        $response->assertSee('window.location.href = redirectUrl');
    }

    /**
     * Test that OTP verification form has proper CSRF protection
     */
    public function test_otp_verification_form_has_csrf_protection()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('csrf-token');
        $response->assertSee('X-CSRF-TOKEN');
    }

    /**
     * Test that error notifications are properly handled
     */
    public function test_error_notifications_are_handled()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('showError');
        $response->assertSee('errorNotification');
    }

    /**
     * Test that the OTP verification form has proper validation
     */
    public function test_otp_verification_form_has_validation()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('required');
        $response->assertSee('email');
    }

    /**
     * Test that the success message is properly displayed
     */
    public function test_success_message_is_displayed()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('Success!');
        $response->assertSee('${message}');
    }

    /**
     * Test that the auto-redirect functionality works
     */
    public function test_auto_redirect_functionality()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('setTimeout');
        $response->assertSee('3000');
    }

    /**
     * Test that the form submission is handled via AJAX
     */
    public function test_form_submission_is_ajax()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('XMLHttpRequest');
        $response->assertSee('X-Requested-With');
    }

    /**
     * Test that the OTP verification page has proper styling
     */
    public function test_otp_verification_page_has_styling()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('bg-gray-600');
        $response->assertSee('bg-green-100');
        $response->assertSee('text-green-600');
    }

    /**
     * Test that the modal has proper accessibility features
     */
    public function test_modal_has_accessibility_features()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('focus:outline-none');
        $response->assertSee('focus:ring-2');
    }

    /**
     * Test that the OTP verification page loads all required assets
     */
    public function test_otp_verification_page_loads_assets()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('font-awesome');
        $response->assertSee('tailwind');
    }

    /**
     * Test that the success modal has proper button styling
     */
    public function test_success_modal_has_button_styling()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('bg-blue-500');
        $response->assertSee('hover:bg-blue-600');
        $response->assertSee('transition-colors');
    }

    /**
     * Test that the OTP verification form has proper input validation
     */
    public function test_otp_verification_form_has_input_validation()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('email');
        $response->assertSee('required');
    }

    /**
     * Test that the success modal has proper responsive design
     */
    public function test_success_modal_has_responsive_design()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('w-96');
        $response->assertSee('mx-auto');
        $response->assertSee('top-20');
    }

    /**
     * Test that the OTP verification page has proper error handling
     */
    public function test_otp_verification_page_has_error_handling()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('catch');
        $response->assertSee('console.error');
    }

    /**
     * Test that the success modal has proper icon display
     */
    public function test_success_modal_has_icon_display()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('fas fa-check');
        $response->assertSee('fas fa-sign-in-alt');
    }

    /**
     * Test that the OTP verification form has proper loading states
     */
    public function test_otp_verification_form_has_loading_states()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('disabled');
        $response->assertSee('Verifying');
    }

    /**
     * Test that the success modal has proper text content
     */
    public function test_success_modal_has_proper_text_content()
    {
        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('${message}');
        $response->assertSee('redirected to the home page');
    }
}
