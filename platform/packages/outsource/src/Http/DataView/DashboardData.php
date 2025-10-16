<?php

namespace TCore\Outsource\Http\DataView;

use App\Enums\Project\ProjectStatus;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use TCore\Outsource\Models\Employee;
use TCore\Outsource\Repositories\Project\ProjectRepositoryInterface;
use TCore\Outsource\Services\Project\StatisticService;

class DashboardData
{
    public Request $request;

    public $period;

    public $data;

    public $startDate;

    public $endDate;

    public $employees;

    public function __construct(
        public ProjectRepositoryInterface $repo,
        public Employee $modelEmployee,
        public StatisticService $pStatisticService
    )
    {
        
    }

    private function handleRequestDate()
    {
        if($this->request->date('start_date'))
        {
            $this->startDate = $this->request->date('start_date')->startOfDay();
        }else {
            $this->startDate = now()->startOfMonth();
        }

        if($this->request->date('end_date'))
        {
            $this->endDate = $this->request->date('end_date')->endOfDay();
        }else {
            $this->endDate = now()->endOfMonth();
        }
    }

    public function getDataCalc(): StatisticService
    {
        return $this->pStatisticService->make($this->getData());
    }

    public function getData(): Collection
    {
        return $this->data;
    }

    public function getEmployees()
    {
        return $this->employees->map(function($employee) {
            
            $calc = $this->pStatisticService->make($employee->projects);

            return (object) [
                'fullname' => $employee->fullname,
                'total_p' => $calc->countAll(),
                'percent_p_done' => $calc->percentDone(),
                'count_p_done' => $calc->countDone(),
                'count_p_late' => $calc->countLate(),
                'percent_p_late' => $calc->percentLate()
            ];
        });
    }

    public function make(Request $request)
    {
        $this->request = $request;

        $this->handleRequestDate();

        $this->data = $this->repo->getBy(
            [
                ['created_at', 'BETWEEN', [$this->startDate, $this->endDate]]
            ]
        );

        $this->employees = $this->modelEmployee->makeQuery([], 
        [
            'projects' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])
        ])
        ->withoutGlobalScope('employee_outsource')
        ->currentHasManager()
        ->get();

        // $this->period = CarbonPeriod::create($this->startDate, $this->endDate);

        return $this;
    }
}