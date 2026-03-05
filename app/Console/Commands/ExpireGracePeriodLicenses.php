<?php

namespace App\Console\Commands;

use App\Models\License;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireGracePeriodLicenses extends Command
{
    protected $signature   = 'licenses:expire-grace-period';
    protected $description = 'Move past_due licenses whose grace period has ended to expired status and soft-downgrade to free limits.';

    public function handle(): int
    {
        $expired = License::where('status', 'past_due')
            ->whereNotNull('grace_period_ends_at')
            ->whereDate('grace_period_ends_at', '<', today())
            ->get();

        if ($expired->isEmpty()) {
            $this->info('No grace-period licenses to expire.');
            return self::SUCCESS;
        }

        foreach ($expired as $license) {
            try {
                $license->markExpired();
                Log::info("ExpireGrace: License {$license->id} (business {$license->business_id}) expired and soft-downgraded.");
                $this->line("  ✓ License #{$license->id} — business #{$license->business_id} expired.");
            } catch (\Throwable $e) {
                Log::error("ExpireGrace: Failed to expire license {$license->id}", ['error' => $e->getMessage()]);
                $this->error("  ✗ License #{$license->id} failed: {$e->getMessage()}");
            }
        }

        $this->info("Done. {$expired->count()} license(s) expired.");
        return self::SUCCESS;
    }
}
