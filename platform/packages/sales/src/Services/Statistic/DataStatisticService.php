<?php

namespace TCore\Sales\Services\Statistic;

use App\Enums\Contact\ContactStatus;
use App\Enums\Customer\CustomerReturnStatus;
use App\Enums\Customer\CustomerType;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\OrderArise;
use App\Models\RangePrice;
use App\Models\Sector;
use App\Models\Source;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use TCore\Sales\Models\CustomerReturn;
use TCore\Sales\Repositories\Order\OrderRepositoryInterface;

class DataStatisticService
{
    public CustomerType|null $customerType;
    public Carbon $startDate;
    public Carbon $endDate;
    public Carbon $startDateSamePeriod;
    public Carbon $endDateSamePeriod;
    public $source_id;

    public function __construct(
        public OrderRepositoryInterface $repoOrder
    )
    {
        
    }

    public function areaCountData()
    {
        $filter = [
            ['created_at', 'between', [$this->startDate, $this->endDate]]
        ];

        if($this->source_id)
        {
            $filter['source_id'] = $this->source_id;
        }

        switch ($this->customerType) {
            
            case CustomerType::New:

                return Contact::makeQuery(filter: $filter, sort: [])->select('area', DB::raw('count(*) as total'))
                ->groupBy('area')
                ->get();

                break;
            case CustomerType::Old:
                return Customer::makeQuery(filter: $filter, sort: [])->select('area', DB::raw('count(*) as total'))
                ->groupBy('area')
                ->get();

                break;
            default:
                
                return Contact::makeQuery(filter: $filter, sort: [])->select('area', DB::raw('count(*) as total'))->groupBy('area')
                ->unionAll(Customer::makeQuery(filter: $filter, sort: [])->select('area', DB::raw('count(*) as total'))->groupBy('area'))
                ->get();

                break;
        }
    }

    public function rangePriceCountData()
    {
        $filter = [];

        if($this->source_id)
        {
            $filter['id'] = $this->source_id;
        }

        $source = RangePrice::makeQuery(filter: $filter);

        switch ($this->customerType) {
            
            case CustomerType::New:

                $source = $source->withCount(['contacts' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])]);

                break;
            case CustomerType::Old:

                $source = $source->withCount(['customers' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])]);

                break;
            default:
                $source = $source->withCount([
                    'contacts' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]),
                    'customers' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])
                ]);

                break;
        }

        return $source->get();
    }

    public function sectorCountData()
    {
        $filter = [];

        if($this->source_id)
        {
            $filter['id'] = $this->source_id;
        }

        $source = Sector::makeQuery(filter: $filter, sort: []);

        switch ($this->customerType) {
            
            case CustomerType::New:

                $source = $source->withCount(['contacts' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])]);

                break;
            case CustomerType::Old:

                $source = $source->withCount(['customers' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])]);

                break;
            default:
                $source = $source->withCount([
                    'contacts' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]),
                    'customers' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])
                ]);

                break;
        }

        return $source->get();
    }

    public function sourceCountData()
    {
        $filter = [];

        if($this->source_id)
        {
            $filter['id'] = $this->source_id;
        }

        $source = Source::makeQuery(filter: $filter, sort: []);

        switch ($this->customerType) {
            
            case CustomerType::New:

                $source = $source->withCount(['contacts' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])]);

                break;
            case CustomerType::Old:

                $source = $source->withCount(['customers' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])]);

                break;
            default:
                $source = $source->withCount([
                    'contacts' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]),
                    'customers' => fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate])
                ]);

                break;
        }

        return $source->get();
    }

    public function contactGroupByStatus()
    {
        $filterContact = $filterCustomerReturn = [
            ['created_at', 'between', [$this->startDate, $this->endDate]]
        ];

        if($this->source_id)
        {
            $filterContact['source_id'] = $this->source_id;
            $filterCustomerReturn[] = ['customer', 'relation', ['source_id', $this->source_id]];
        }

        switch ($this->customerType) {
            
            case CustomerType::New:
                return Contact::makeQuery(filter: $filterContact, sort: [])->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();

                break;
            case CustomerType::Old:
                return CustomerReturn::makeQuery(filter: $filterCustomerReturn, sort: [])->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();

                break;
            default:
                
                return Contact::makeQuery(filter: $filterContact, sort: [])->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->unionAll(CustomerReturn::makeQuery(filter: $filterCustomerReturn, sort: [])->select('status', DB::raw('count(*) as total'))
                ->groupBy('status'))->get();

                break;
        }
    }

    public function revenueFollowDate()
    {
        $filterOrder = $filterArise = [
            ['created_at', 'between', [$this->startDate, $this->endDate]]
        ];

        if($this->customerType)
        {
            $filterOrder['customer_type'] = $this->customerType;
            $filterArise[] = ['order', 'relation', ['customer_type', $this->customerType]];
        }

        if($this->source_id)
        {
            $filterOrder[] = ['customer', 'relation', ['source_id', $this->source_id]];
            $filterArise[] = ['order', 'has', fn($q) => $q->whereRelation('customer', 'source_id', $this->source_id)];
        }

        $order = $this->repoOrder->getByQueryBuilder(filter: $filterOrder, sort: ['revenue_date', 'asc'])
        ->selectRaw('DATE_FORMAT(created_at, "%d-%m-%Y") as revenue_date, SUM(sub_total) as revenue')
        ->groupByRaw('DATE_FORMAT(created_at, "%d-%m-%Y")');
        $orderArise = OrderArise::makeQuery(filter: $filterArise, sort: ['revenue_date', 'asc'])
        ->selectRaw('DATE_FORMAT(created_at, "%d-%m-%Y") as revenue_date, SUM(amount) as revenue')
        ->groupByRaw('DATE_FORMAT(created_at, "%d-%m-%Y")');

        $revenues = $order->unionAll($orderArise)
        ->groupByRaw('revenue_date')
        ->orderBy('revenue_date')
        ->get();

        return $revenues;
    }

    public function totalOrder(bool $samePeriod = false)
    {
        $filter = [$this->filterPeriodTime($samePeriod)];

        if($this->customerType)
        {
            $filter['customer_type'] = $this->customerType;
        }

        return $this->repoOrder->getByQueryBuilder(filter: $filter)->count();
    }

    public function totalRenueve(bool $samePeriod = false)
    {
        $filterOrder = $filterArise = [$this->filterPeriodTime($samePeriod)];

        if($this->customerType)
        {
            $filterOrder['customer_type'] = $this->customerType;
            $filterArise[] = ['order', 'relation', ['customer_type', $this->customerType]];
        }

        if($this->source_id)
        {
            $filterOrder[] = ['customer', 'relation', ['source_id', $this->source_id]];
            $filterArise[] = ['order', 'has', fn($q) => $q->whereRelation('customer', 'source_id', $this->source_id)];
        }

        $totalOrder = $this->repoOrder->getByQueryBuilder(filter: $filterOrder)->sum('sub_total');

        $totalOrderArise = OrderArise::makeQuery($filterArise)->sum('amount');

        return $totalOrder + $totalOrderArise;
    }

    public function totalContact(ContactStatus|null $contactStatus = null, CustomerReturnStatus|null $customerReturnStatus = null, bool $samePeriod = false)
    {
        switch ($this->customerType) {
            
            case CustomerType::New:
                return $this->totalContactNew($contactStatus, $samePeriod);
                break;
            case CustomerType::Old:
                return $this->totalCustomerReturn($customerReturnStatus, $samePeriod);
                break;
            default:
                return $this->totalContactNew($contactStatus, $samePeriod) + $this->totalCustomerReturn($customerReturnStatus, $samePeriod);
                break;
        }
    }

    public function totalContactNew(ContactStatus|null $status = null, bool $samePeriod = false)
    {
        $filter = [$this->filterPeriodTime($samePeriod)];

        if($status)
        {
            $filter['status'] = $status;
        }

        if($this->source_id)
        {
            $filter['source_id'] = $this->source_id;
        }

        return Contact::makeQuery(filter: $filter, sort: [])->count();
    }

    public function totalCustomerReturn(CustomerReturnStatus|null $status = null, bool $samePeriod = false)
    {
        $filter = [$this->filterPeriodTime($samePeriod)];

        if($status)
        {
            $filter['status'] = $status;
        }

        if($this->source_id)
        {
            $filter[] = ['customer', 'relation', ['source_id', $this->source_id]];
        }
        return CustomerReturn::makeQuery(filter: $filter, sort: [])->count();
    }

    protected function filterPeriodTime(bool $samePeriod = false): array
    {
        return $samePeriod ? ['created_at', 'between', [$this->startDateSamePeriod, $this->endDateSamePeriod]]
            : ['created_at', 'between', [$this->startDate, $this->endDate]];
    }

    public function make(CustomerType|null $customerType = null, $source_id = null, Carbon $startDate, Carbon $endDate, Carbon $startDateSamePeriod, Carbon $endDateSamePeriod)
    {
        $this->customerType = $customerType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startDateSamePeriod = $startDateSamePeriod;
        $this->endDateSamePeriod = $endDateSamePeriod;
        $this->source_id = $source_id;
        return $this;
    }
}