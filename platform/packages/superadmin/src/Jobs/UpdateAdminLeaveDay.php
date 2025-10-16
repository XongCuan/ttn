<?php

namespace TCore\Superadmin\Jobs;

use App\Models\Admin;
use App\Models\LeaveHistory;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use TCore\Base\Enums\LeaveRequest\LeaveRequestStatus;

class UpdateAdminLeaveDay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */

    public function handle()
    {
        $admins = Admin::all();

        foreach ($admins as $admin) {
            $startDate = Carbon::parse($admin->created_at);
            $now = Carbon::now();
            
            if ($startDate->year < $now->year) {
                LeaveHistory::where('admin_id', $admin->id)
                    ->where('year', $startDate->year)
                    ->delete();
                $startDate = Carbon::parse($now->startOfYear());
            }

            $addedCount = LeaveHistory::where('admin_id', $admin->id)
                ->where('year', $now->year)
                ->count();

            if ($addedCount < 12) {
                $monthsDiff = $startDate->diffInMonths($now);
                
                // Lọc ra những tháng chưa được cộng
                $processedMonths = LeaveHistory::where('admin_id', $admin->id)
                    ->where('year', $now->year)
                    ->pluck('month')
                    ->toArray();

                for ($i = 0; $i <= $monthsDiff; $i++) {
                    $currentMonth = $startDate->copy()->addMonths($i);
                    
                    if (!in_array($currentMonth->month, $processedMonths) && 
                        $currentMonth->year == $now->year && 
                        $addedCount < 12) {
                        
                        $admin->leave_days += 1;
                        $admin->save();

                        LeaveHistory::create([
                            'admin_id' => $admin->id,
                            'month' => $currentMonth->month,
                            'year' => $currentMonth->year,
                            'days_added' => 1
                        ]);

                        $addedCount++;
                    }
                }
            }
        }
    }
}
