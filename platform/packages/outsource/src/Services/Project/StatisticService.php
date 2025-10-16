<?php

namespace TCore\Outsource\Services\Project;

use App\Enums\Project\ProjectStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class StatisticService
{
    public Collection|SupportCollection $data;

    public function __construct()
    {
    }

    public function percentLate()
    {
        if($this->countLate() == 0)
        {
            return 0;
        }

        return round(($this->countLate()/$this->countAll()) * 100);
    }

    public function percentDone()
    {
        if($this->countDone() == 0)
        {
            return 0;
        }

        return round(($this->countDone()/$this->countAll()) * 100);
    }

    public function countLate()
    {
        return $this->data
        ->whereNotNull('demo_ontime')
        ->where('demo_ontime', false)
        ->count();
    }

    public function countDone()
    {
        return $this->data->where('status', ProjectStatus::Done)->count();
    }

    public function countAll()
    {
        return $this->data->count();
    }

    public function make(Collection|SupportCollection $data): self
    {
        $this->data = $data;
        return $this;
    }
}