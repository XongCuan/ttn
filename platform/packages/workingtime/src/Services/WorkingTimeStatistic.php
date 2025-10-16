<?php

namespace TCore\WorkingTime\Services;

use App\Models\Admin;
use Illuminate\Support\Carbon;
use TCore\Base\Enums\LeaveRequest\HalfDayType;
use TCore\Base\Enums\LeaveRequest\LeaveRequestType;
use TCore\Base\Enums\WorkingTimeStatus;

class WorkingTimeStatistic
{
    public function __construct(
        public Admin $admin,
        public $month,
        public $year
    )
    {
        
    }

    public function countPassDate()
    {
        $data = $this->admin->workingTimes;

        $total = 0;
        foreach($data as $item)
        {
            if($this->isOffAfternoon($item->date))
            {
                if(static::countHoursRange($item->check_in, $item->check_out) >= 3)
                {
                    $total += 0.5;
                }
            }elseif($this->isOffMorning($item->date)) {

                if(static::countHoursRange($item->check_in, $item->check_out) >= 4)
                {
                    $total += 0.5;
                }
            }elseif(Carbon::createFromTimeString('11:00:00')->lessThan($item->check_in) || static::countHoursRange($item->check_in, $item->check_out) < 8.50) {

                if(static::countHoursRange($item->check_in, $item->check_out) >= 4)
                {
                    $total += 0.5;
                }
            }else {
                $total += 1;
            }  
        }
        
        return $total;
    }

    public function isOffMorning(Carbon $date)
    {
        $data = $this->admin->leaveRequests;

        return $data->where('start_date', $date->format('Y-m-d'))->where('half_day_type', HalfDayType::Morning)->first();
    }

    public function isOffAfternoon(Carbon $date)
    {
        $data = $this->admin->leaveRequests;

        return $data->where('start_date', $date->format('Y-m-d'))->where('half_day_type', HalfDayType::Afternoon)->first();
    }

    public function dateLate()
    {
        $data = $this->admin->workingTimes;

        $date = [];

        foreach($data as $item)
        {
            if($item->status == WorkingTimeStatus::Late)
            {
                $date[] = $item->date->format('d-m-Y');
            }
        }

        return $date;
    }

    public function dateNotEnoughHours(): array
    {
        $data = $this->admin->workingTimes;

        $date = [];

        foreach($data as $item)
        {
            if(
                ($this->isOffMorning($item->date) && static::countHoursRange($item->check_in, $item->check_out) < 4.50) ||
                ($this->isOffAfternoon($item->date) && static::countHoursRange($item->check_in, $item->check_out) < 3.50) || 
                static::countHoursRange($item->check_in, $item->check_out) < 9.50
            )
            {
                $date[] = $item->date->format('d-m-Y');
            }
        }

        return $date;
    }

    public function countUnpaidLeave()
    {
        $data = $this->admin->leaveRequests;

        $total = 0;

        foreach($data as $item)
        {
            if($item->type == LeaveRequestType::UnpaidLeave)
            {
                if($item->is_half_day)
                {
                    $total += 0.5;
                }else {
                    $total += static::countDaysInMonthRange($item->start_date, $item->end_date, $this->month, $this->year);
                }
            }
        }

        return $total;
    }

    public function countRequestAddToWorkingTIme()
    {
        $data = $this->admin->leaveRequests;

        $total = 0;

        foreach($data as $item)
        {
            if($item->type == LeaveRequestType::Remote)
            {
                
                $total += static::countDaysInMonthRange($item->start_date, $item->end_date, $this->month, $this->year);

            }elseif($item->type == LeaveRequestType::AnnualLeave || $item->type == LeaveRequestType::SpecialLeave) {

                if($item->is_half_day)
                {
                    $total += 0.5;
                }else {
                    $total += static::countDaysInMonthRange($item->start_date, $item->end_date, $this->month, $this->year);
                }
            }
        }

        return $total;
    }

    public function countSpecialLeave()
    {
        $data = $this->admin->leaveRequests;

        $total = 0;

        foreach($data as $item)
        {
            if($item->type == LeaveRequestType::SpecialLeave)
            {
                $total += static::countDaysInMonthRange($item->start_date, $item->end_date, $this->month, $this->year);
            }
        }

        return $total;
    }

    public function countRemote()
    {
        $data = $this->admin->leaveRequests;

        $total = 0;

        foreach($data as $item)
        {
            if($item->type == LeaveRequestType::Remote)
            {
                $total += static::countDaysInMonthRange($item->start_date, $item->end_date, $this->month, $this->year);
            }
        }

        return $total;
    }

    public function countAnnualLeave()
    {
        $data = $this->admin->leaveRequests;

        $total = 0;

        foreach($data as $item)
        {
            if($item->type == LeaveRequestType::AnnualLeave)
            {
                if($item->is_half_day)
                {
                    $total += 0.5;
                }else {
                    $total += static::countDaysInMonthRange($item->start_date, $item->end_date, $this->month, $this->year);
                }
            }
        }

        return $total;
    }

    public static function countDaysInMonthRange($from, $to, $month, $year)
    {
        $start = Carbon::parse($from)->startOfDay();
        $end = Carbon::parse($to)->startOfDay();

        $startOfMonth = Carbon::create($year, $month, 1)->startOfDay();
        if ($start < $startOfMonth) {
            $start = $startOfMonth;
        }

        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth()->startOfDay();
        if ($end > $endOfMonth) {
            $end = $endOfMonth;
        }

        if ($start > $end) {
            return 0;
        }

        $count = 0;
        $current = $start->copy();

        while ($current <= $end) {
            // Kiểm tra nếu KHÔNG phải thứ 7 (6) và Chủ nhật (0)
            if (!in_array($current->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $count++;
            }
            $current->addDay();
        }

        return $count;
    }

    public static function countHoursRange(Carbon $from, Carbon $to)
    {
        $diffInSeconds = $from->diffInSeconds($to);
        $diffInHours = $diffInSeconds / 3600;

        return round($diffInHours, 2);
    }

    public static function convertDecimalHoursToHourMinute($decimalHours) {
        $hours = floor($decimalHours);
        $minutes = round(($decimalHours - $hours) * 60);

        return "{$hours} giờ {$minutes} phút";
    }
}