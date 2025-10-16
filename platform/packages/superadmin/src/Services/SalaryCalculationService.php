<?php

namespace TCore\Superadmin\Services;

use App\Models\Admin;
use App\Models\LeaveRequest;
use App\Models\WorkingTime;
use App\Models\WorkingOvertime;
use App\Models\TypeOvertime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use TCore\Base\Enums\LeaveRequest\LeaveRequestStatus;
use TCore\Base\Enums\LeaveRequest\LeaveRequestType;
use TCore\Base\Enums\WorkingTimeStatus;
use TCore\WorkingTime\Services\WorkingTimeStatistic;

class SalaryCalculationService
{
    protected $admin;
    protected $month;
    protected $year;
    protected $basicSalary;
    protected $leaveRequest;
    protected $workingTime;
    protected $workingOvertime;
    public function __construct(
        LeaveRequest $leaveRequest,
        WorkingTime $workingTime,
        WorkingOvertime $workingOvertime
    ) {
        $this->leaveRequest = $leaveRequest;
        $this->workingTime = $workingTime;
        $this->workingOvertime = $workingOvertime;
    }

    /**
     * Create a new instance of SalaryCalculationService
     */
    public static function make(Admin $admin, ?int $month = null, ?int $year = null): static
    {
        $instance = app(static::class);
        return $instance->setParameters($admin, $month, $year);
    }

    /**
     * Set calculation parameters
     */
    protected function setParameters(Admin $admin, ?int $month = null, ?int $year = null): static
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $this->admin = $admin;
        $this->month = $month ?? ($currentMonth == 1 ? 12 : $currentMonth - 1);
        $this->year = $year ?? ($currentMonth == 1 ? $currentYear - 1 : $currentYear);
        $this->basicSalary = $admin->salary;

        return $this;
    }

    /**
     * Lấy thông tin nghỉ phép trong tháng
     */
    protected function getLeaveInfo(): array
    {
        $startDate = Carbon::create($this->year, $this->month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $unpaidLeaveFilter = [
            'admin_id' => $this->admin->id,
            'status' => LeaveRequestStatus::Approved,
            'type' => LeaveRequestType::UnpaidLeave,
            ['start_date', 'BETWEEN', [$startDate, $endDate]]
        ];

        $paidLeaveFilter = [
            'admin_id' => $this->admin->id,
            'status' => LeaveRequestStatus::Approved,
            ['type', 'IN', [LeaveRequestType::AnnualLeave, LeaveRequestType::SpecialLeave]],
            ['start_date', 'BETWEEN', [$startDate, $endDate]]
        ];

        $unpaidLeaveRequests = $this->leaveRequest->getBy($unpaidLeaveFilter);
        $paidLeaveRequests = $this->leaveRequest->getBy($paidLeaveFilter);


        $unpaidLeaveDays = 0;
        $paidLeaveDays = 0;
        $leaveDetails = [];

        // Process unpaid leave requests
        foreach ($unpaidLeaveRequests as $leave) {
            $this->processLeaveRequest($leave, $leaveDetails, $unpaidLeaveDays);
        }

        // Process paid leave requests
        foreach ($paidLeaveRequests as $leave) {
            $this->processLeaveRequest($leave, $leaveDetails, $paidLeaveDays);
        }

        return [
            'total_unpaid_leave_days' => $unpaidLeaveDays,
            'total_paid_leave_days' => $paidLeaveDays,
            'details' => $leaveDetails
        ];
    }

    protected function processLeaveRequest($leave, &$leaveDetails, &$leaveDays): void
    {
        if ($leave->is_half_day) {
            if (!in_array(Carbon::parse($leave->start_date)->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $leaveDays += 0.5;
                $leaveDetails[] = [
                    'date' => $leave->start_date,
                    'type' => $leave->type,
                    'is_half_day' => true,
                    'half_day_type' => $leave->half_day_type
                ];
            }
        } else {
            $startLeaveDate = Carbon::parse($leave->start_date);
            $endLeaveDate = Carbon::parse($leave->end_date);

            if ($startLeaveDate->month != $this->month) {
                $startLeaveDate = Carbon::create($this->year, $this->month, 1);
            }
            if ($endLeaveDate->month != $this->month) {
                $endLeaveDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();
            }

            $period = CarbonPeriod::create($startLeaveDate, $endLeaveDate);

            foreach ($period as $date) {
                if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                    $leaveDays += 1;
                    $leaveDetails[] = [
                        'date' => $date->format('Y-m-d'),
                        'type' => $leave->type,
                        'is_half_day' => false
                    ];
                }
            }
        }
    }

    // Tinh luong nghi phep co luong
    protected function calculatePaidLeaveSalary(): float
    {
        $leaveInfo = $this->getLeaveInfo();
        $dailySalary = $this->getDailySalary();
        
        return $leaveInfo['total_paid_leave_days'] * $dailySalary;
    }



    /**
     * Lấy tất cả ngày làm việc trong tháng (trừ T7, CN)
     */
    protected function getWorkingDaysInMonth(): array
    {
        $startDate = Carbon::create($this->year, $this->month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $workingDays = [];
        foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
            if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $workingDays[] = $date->format('Y-m-d');
            }
        }

        return $workingDays;
    }

    /**
     * Lấy số ngày đi làm thực tế và số ngày đi trễ
     */
    protected function getAttendanceData(): array
    {
        $workingDays = $this->getWorkingDaysInMonth();

        $filter = [
            'admin_id' => $this->admin->id,
            [
                'date',
                'BETWEEN',
                [
                    Carbon::create($this->year, $this->month, 1),
                    Carbon::create($this->year, $this->month, 1)->endOfMonth()
                ]
            ],
            ['check_in', '!=', null],
            ['check_out', '!=', null]
        ];

        // $attendance = $this->workingTime->getBy($filter)->count();
        $statistic = new WorkingTimeStatistic($this->admin, $this->month, $this->year);

        $attendance = $statistic->countPassDate() + $statistic->countAnnualLeave();

        $lateFilter = [
            'admin_id' => $this->admin->id,
            [
                'date',
                'BETWEEN',
                [
                    Carbon::create($this->year, $this->month, 1),
                    Carbon::create($this->year, $this->month, 1)->endOfMonth()
                ]
            ],
            'status' => WorkingTimeStatus::Late
        ];

        $lateDays = $this->workingTime->getBy($lateFilter)->count();

        return [
            'total_working_days' => count($workingDays),
            'actual_working_days' => $attendance,
            'late_days' => $lateDays
        ];
    }

    /**
     * Tính lương 1 ngày
     */
    protected function getDailySalary(): float
    {
        $workingDays = $this->getWorkingDaysInMonth();
        return count($workingDays) > 0 ? $this->basicSalary / count($workingDays) : 0;
    }

    /**
     * Tính lương 1 giờ
     */
    protected function getHourlySalary(): float
    {
        return $this->getDailySalary() / 8;
    }

    /**
     * Tính lương OT
     */
    protected function calculateOvertimeSalary(): array
    {

        $filter = [
            'admin_id' => $this->admin->id,
            [
                'date',
                'BETWEEN',
                [
                    Carbon::create($this->year, $this->month, 1),
                    Carbon::create($this->year, $this->month, 1)->endOfMonth()
                ]
            ]
        ];

        $overtimeRecords = $this->workingOvertime->getBy($filter, ['type']);

        $hourlySalary = $this->getHourlySalary();

        $overtimeDetails = [];
        $totalOvertimeSalary = 0;

        foreach ($overtimeRecords as $record) {
            $amount = $hourlySalary * $record->hour * $record->type->value;

            $overtimeDetails[] = [
                'type' => $record->type->name,
                'rate' => $record->type->value,
                'hours' => $record->hour,
                'amount' => $amount
            ];

            $totalOvertimeSalary += $amount;
        }

        return [
            'details' => $overtimeDetails,
            'total' => $totalOvertimeSalary
        ];
    }

    /**
     * Tính tổng lương cơ bản ( chưa trừ ngày đi trễ, với nghỉ phép )
     */
    protected function calculateBasicSalary(): float
    {
        $attendanceData = $this->getAttendanceData();
        $dailySalary = $this->getDailySalary();
        // $leaveInfo = $this->getLeaveInfo();

        return ($attendanceData['actual_working_days']) * $dailySalary;
    }

    /**
     * Lấy toàn bộ thông tin lương
     */
    public function calculateSalary(): array
    {
        $attendanceData = $this->getAttendanceData();
        $overtimeData = $this->calculateOvertimeSalary();
        $basicSalary = $this->calculateBasicSalary();
        $leaveInfo = $this->getLeaveInfo();
        $paidLeaveSalary = $this->calculatePaidLeaveSalary();

        $isBirthdayMonth = false;
        if ($this->admin->birthday) {
            $isBirthdayMonth = Carbon::parse($this->admin->birthday)->month == $this->month;
        }
        $birthdayBonus = $isBirthdayMonth ? 500000 : 0;

        return [
            'admin_id' => $this->admin->id,
            'month' => $this->month,
            'year' => $this->year,
            'basic_salary' => $this->basicSalary,
            'working_days' => [
                'total' => $attendanceData['total_working_days'],
                'actual' => $attendanceData['actual_working_days'],
                'late' => $attendanceData['late_days']
            ],
            'leave_info' => [
                'paid_leave_days' => $leaveInfo['total_paid_leave_days'],
                'unpaid_leave_days' => $leaveInfo['total_unpaid_leave_days'],
                'details' => $leaveInfo['details']
            ],
            'salary_rates' => [
                'daily' => $this->getDailySalary(),
                'hourly' => $this->getHourlySalary()
            ],
            'overtime' => $overtimeData['details'],
            'salary_calculation' => [
                'basic_salary' => $basicSalary,
                'paid_leave_salary' => $paidLeaveSalary,
                'overtime_salary' => $overtimeData['total'],
                'total_salary' => $basicSalary + $overtimeData['total'] + $birthdayBonus + $paidLeaveSalary
            ]
        ];
    }
}
