<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewLoggedEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:view {--type=all : Type of emails to view (password-reset, verification, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View logged emails from Laravel log files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📧 Viewing Logged Emails...');

        $type = $this->option('type');
        $logFile = storage_path('logs/laravel.log');

        if (! File::exists($logFile)) {
            $this->error('❌ Laravel log file not found!');

            return 1;
        }

        $logContent = File::get($logFile);
        $lines = explode("\n", $logContent);

        $emailEntries = [];
        $currentEntry = null;

        foreach ($lines as $line) {
            if (str_contains($line, 'Password reset OTP') ||
                str_contains($line, 'OTP code sent') ||
                str_contains($line, 'Email verification')) {

                $timestamp = '';
                if (preg_match('/\[(.*?)\]/', $line, $matches)) {
                    $timestamp = $matches[1];
                }

                $email = '';
                if (preg_match('/"email":"([^"]+)"/', $line, $matches)) {
                    $email = $matches[1];
                }

                $type = '';
                if (str_contains($line, 'Password reset')) {
                    $type = 'Password Reset';
                } elseif (str_contains($line, 'Email verification')) {
                    $type = 'Email Verification';
                } else {
                    $type = 'OTP';
                }

                $emailEntries[] = [
                    'timestamp' => $timestamp,
                    'type' => $type,
                    'email' => $email,
                    'line' => trim($line),
                ];
            }
        }

        if (empty($emailEntries)) {
            $this->warn('⚠️  No email entries found in logs.');
            $this->info('💡 Try requesting a password reset or email verification first.');

            return 0;
        }

        $this->info("\n📋 Found ".count($emailEntries)." email entries:\n");

        foreach ($emailEntries as $entry) {
            $this->line("🕐 {$entry['timestamp']}");
            $this->line("📧 Type: {$entry['type']}");
            $this->line("📮 Email: {$entry['email']}");
            $this->line("📄 Log: {$entry['line']}");
            $this->line('─'.str_repeat('─', 80));
        }

        $this->info("\n💡 To receive actual emails:");
        $this->info('   1. Update your .env file with SMTP settings');
        $this->info('   2. Use Gmail SMTP or Mailtrap for testing');
        $this->info('   3. Run: php artisan config:clear');

        return 0;
    }
}
