<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckMembershipStatus extends Command
{

    protected $signature = 'membership:check-status {--force : Force update even if already checked today}';
    protected $description = 'Check and update membership status based on expiration dates';

    public function handle()
    {
        $this->info('Starting membership status check...');

        $startTime = now();
        $now = Carbon::now();
        $twoMonthsAgo = $now->copy()->subMonths(2);

        try {

            // ACTIVE → FROZEN (jika expired)
            $this->info('Checking expired active members...');

            $expiredActiveMembers = User::where('role', 'member')
                ->where('status', 'active')
                ->where('membership_expiration_date', '<', $now)
                ->get();

            $expiredCount = 0;

            foreach ($expiredActiveMembers as $member) {
                $member->update(['status' => 'frozen']);
                $expiredCount++;

                $this->line("   {$member->name} ({$member->email}) → FROZEN");

                Log::info('Member status changed to frozen', [
                    'user_id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'expired_date' => $member->membership_expiration_date,
                    'changed_at' => now()
                ]);
            }


            // FROZEN → INACTIVE (jika sudah 2 bulan)
            $this->info('Checking frozen members who have been frozen for more than 2 months...');

            $longFrozenMembers = User::where('role', 'member')
                ->where('status', 'frozen')
                ->where('membership_expiration_date', '<', $twoMonthsAgo)  // ✅ PERBAIKAN INI
                ->get();

            $inactiveCount = 0;

            foreach ($longFrozenMembers as $member) {
                $member->update([
                    'status' => 'inactive',
                    'membership_started_date' => null,
                    'membership_expiration_date' => null
                ]);
                $inactiveCount++;

                $this->line("  ❌ {$member->name} ({$member->email}) → INACTIVE");

                Log::info("Member status changed to inactive", [
                    'user_id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'previous_expired_date' => $member->membership_expiration_date,
                    'changed_at' => now()
                ]);
            }


            // log the results
            $totalMembers = User::where('role', 'member')->count();
            $activeMembers = User::where('role', 'member')->where('status', 'active')->count();
            $frozenMembers = User::where('role', 'member')->where('status', 'frozen')->count();
            $inactiveMembers = User::where('role', 'member')->where('status', 'inactive')->count();

            $duration = $startTime->diffInSeconds(now());

            $this->info('');
            $this->info('✨ Membership status check completed!');
            $this->info("📊 Summary:");
            $this->info("   • Total Members: {$totalMembers}");
            $this->info("   • Active: {$activeMembers}");
            $this->info("   • Frozen: {$frozenMembers}");
            $this->info("   • Inactive: {$inactiveMembers}");
            $this->info("   • Changed to Frozen: {$expiredCount}");
            $this->info("   • Changed to Inactive: {$inactiveCount}");
            $this->info("   • Duration: {$duration}s");

            // Log summary
            Log::info("Membership status check completed", [
                'total_members' => $totalMembers,
                'active_members' => $activeMembers,
                'frozen_members' => $frozenMembers,
                'inactive_members' => $inactiveMembers,
                'changed_to_frozen' => $expiredCount,
                'changed_to_inactive' => $inactiveCount,
                'duration_seconds' => $duration,
                'executed_at' => now()
            ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error during membership status check:');
            $this->error($e->getMessage());

            Log::error("Membership status check failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'executed_at' => now()
            ]);

            return Command::FAILURE;
        }
    }
}
