<?php

namespace TCore\WorkingTime\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StatisticWorkingTime implements FromView
{
    public function __construct(
        public $statistic
    )
    {
        
    }
    public function view(): View
    {
        return view('packages_workingtime::dashboard.export-excel')
        
        ->with('statistic', $this->statistic);
    }
}