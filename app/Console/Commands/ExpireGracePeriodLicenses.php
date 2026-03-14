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
        // ── 1. Expire past_due licenses whose grace period has ended ──────────
        $expired = License::where('status', 'past_due')
            ->whereNotNull('grace_period_ends_at')
            ->whereDate('grace_period_ends_at', '<', today())
            ->get();

        if ($expired->isEmpty()) {
            $this->info('No grace-period licenses to expire.');
        }

        foreach ($expired as $license) {
            try {
                $license->markExpired();
                Log::info("ExpireGrace: License {$license->id} (business {$license->business_id}) expired and soft-downgraded.");
                $this->line("  ✓ License #{$license->id} — business #{$license->business_id} expired (grace period).");
            } catch (\Throwable $e) {
                Log::error("ExpireGrace: Failed to expire license {$license->id}", ['error' => $e->getMessage()]);
                $this->error("  ✗ License #{$license->id} failed: {$e->getMessage()}");
            }
        }

        // ── 2. Expire active cancelled licenses past their expiry date ────────
        // These are subscriptions where the user cancelled (auto_renew = false)
        // and the plan period has now ended — downgrade to Free.
        $cancelled = License::where('status', 'active')
            ->where('auto_renew', false)
            ->whereNotIn('plan', ['free'])
            ->whereNotNull('expires_at')
            ->whereDate('expires_at', '<', today())
            ->get();

        foreach ($cancelled as $license) {
            try {
                $license->markExpired();
                Log::info("ExpireGrace: Cancelled license {$license->id} (business {$license->business_id}) expired and soft-downgraded.");
                $this->line("  ✓ License #{$license->id} — business #{$license->business_id} expired (cancelled subscription).");
            } catch (\Throwable $e) {
                Log::error("ExpireGrace: Failed to expire cancelled license {$license->id}", ['error' => $e->getMessage()]);
                $this->error("  ✗ License #{$license->id} failed: {$e->getMessage()}");
            }
        }

        $total = $expired->count() + $cancelled->count();
        $this->info("Done. {$total} license(s) expired.");
        return self::SUCCESS;
    }
}
