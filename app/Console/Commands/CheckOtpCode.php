<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use Illuminate\Console\Command;

class CheckOtpCode extends Command
{
    protected $signature = 'check:otp-code {code}';

    protected $description = 'Check status of a specific OTP code';

    public function handle()
    {
        $code = $this->argument('code');

        $this->info("Checking OTP code: {$code}");

        $otp = OtpCode::where('code', $code)->first();

        if (! $otp) {
            $this->error('OTP code not found!');

            return 1;
        }

        $this->info("Email: {$otp->email}");
        $this->info("Type: {$otp->type}");
        $this->info('Used: '.($otp->is_used ? 'Yes' : 'No'));
        $this->info("Expires: {$otp->expires_at}");
        $this->info('Valid: '.($otp->expires_at > now() ? 'Yes' : 'No'));
        $this->info('Can be used: '.(! $otp->is_used && $otp->expires_at > now() ? 'Yes' : 'No'));

        return 0;
    }
}
