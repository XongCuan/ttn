<?php

namespace TCore\Marketing\Http\DataView;

use App\Enums\Contact\ContactStatus;
use App\Enums\Customer\CustomerReturnStatus;
use App\Enums\Customer\CustomerType;
use App\Models\Setting;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use TCore\Marketing\Services\Statistic\DataStatisticService;

class StatisticData
{
    public Request $request;

    public $data;
    
    public $totalContact;

    public $period;

    public function __construct(
        public DataStatisticService $service
    )
    {
        
    }

    public function getDataChartArea()
    {
        return $this->getData()->areaCountData()
        ->groupBy('area')
        ->map(fn($item) => ['label' => $item->first()->area->description(), 'total' => $item->sum('total')])
        ->values();
    }

    public function getDataChartRangePrice()
    {
        return $this->getData()->rangePriceCountData()->map(fn($item) => ['label' => $item->name, 'total' => ($item->contacts_count ?: 0) + ($item->customers_count ?: 0)]);
    }

    public function getDataChartSector()
    {
        return $this->getData()->sectorCountData()->map(fn($item) => ['label' => $item->name, 'total' => ($item->contacts_count ?: 0) + ($item->customers_count ?: 0)]);
    }

    public function getDataChartSource()
    {
        return $this->getData()->sourceCountData()->map(fn($item) => ['label' => $item->name, 'total' => ($item->contacts_count ?: 0) + ($item->customers_count ?: 0)]);
    }

    public function getDataChartContactStatus()
    {
        return $this->getData()->contactGroupByStatus()
        ->groupBy('status')
        ->map(fn($item) => ['status' => $item->first()->status->description(), 'total' => $item->sum('total')])
        ->values();
    }

    public function getDataChartRevenue()
    {
        $data = $this->getData()->revenueFollowDate()
        ->groupBy('revenue_date')
        ->map(fn($item) => ['revenue_date' => $item->first()->revenue_date, 'revenue_total' => $item->sum('revenue')])
        ->toArray();

        $arr = [];

        foreach($this->period->toArray() as $date)
        {
            array_push($arr, [
                'revenue_date' => $date->format('d-m-Y'),
                'revenue_total' => $data[$date->format('d-m-Y')]['revenue_total'] ?? 0
            ]);
        }
        return json_encode($arr);
    }

    public function getDataChartSales()
    {
        $data = $this->getData()->revenueFollowDate()
        ->groupBy('revenue_date')
        ->map(fn($item) => ['revenue_date' => $item->first()->revenue_date, 'revenue_total' => $item->sum('revenue')])
        ->toArray();

        $arr = [];

        foreach($this->period->toArray() as $date)
        {
            array_push($arr, [
                'revenue_date' => $date->format('d-m-Y'),
                'revenue_total' => $data[$date->format('d-m-Y')]['revenue_total'] ?? 0
            ]);
        }
        return json_encode($arr);
    }

    public function totalContactWithSamePeriod()
    {
        $total = $this->totalContact;

        $totalSamePeriod = $this->getData()->totalContact(samePeriod: true);

        $setting_kpi_target = Setting::getValue('mkt_kpi_target_contact');

        return [
            'total' => $total,
            'kpi_target' => round(($total - $setting_kpi_target) / ($setting_kpi_target ?: 1) * 100),
            'same_period' => round(($total - $totalSamePeriod) / ($totalSamePeriod ?: 1) * 100)
        ];
    }

    public function totalRenueveWithSamePeriod()
    {
        $total = $this->getData()->totalRenueve();

        $totalSamePeriod = $this->getData()->totalRenueve(true);

        return [
            'total' => $total,
            'same_period' => round(($total - $totalSamePeriod) / ($totalSamePeriod ?: 1) * 100)
        ];
    }

    public function totalSalesWithSamePeriod()
    {
        $total = $this->getData()->totalRenueve();

        $totalSamePeriod = $this->getData()->totalRenueve(true);

        return [
            'total' => $total,
            'same_period' => round(($total - $totalSamePeriod) / ($totalSamePeriod ?: 1) * 100)
        ];
    }

    public function totalOrderWithSamePeriod()
    {
        $total = $this->getData()->totalOrder();

        $totalSamePeriod = $this->getData()->totalOrder(true);

        return [
            'total' => $total,
            'same_period' => round(($total - $totalSamePeriod) / ($totalSamePeriod ?: 1) * 100)
        ];
    }

    public function conversionRate()
    {
        $total = $this->getData()->totalContact(ContactStatus::Completed, CustomerReturnStatus::Completed);
        
        $totalSamePeriod = $this->getData()->totalContact(ContactStatus::Completed, CustomerReturnStatus::Completed, true);

        return [
            'total' => $total,
            'same_period' => round(($total - $totalSamePeriod) / ($totalSamePeriod ?: 1) * 100)
        ];
    }

    public function getData(): DataStatisticService
    {
        return $this->data;
    }

    public function make(Request $request)
    {
        $this->request = $request;

        $startDate = ($request->date('start_date') ?: now())->startOfDay();

        $endDate = ($request->date('end_date') ?: now())->endOfDay();

        $startDateSamePeriod = ($request->date('start_date') ?: now())->startOfDay()->subMonth();
        
        $endDateSamePeriod = ($request->date('end_date') ?: now())->endOfDay()->subMonth();


        $this->data = $this->service->make(
            $request->enum('type', CustomerType::class), 

            $request->input('source_id', null), 

            $startDate,

            $endDate, 
            $startDateSamePeriod, 
            $endDateSamePeriod
        );

        $this->totalContact = $this->getData()->totalContact();

        $this->period = CarbonPeriod::create($startDate, $endDate);

        return $this;
    }
}