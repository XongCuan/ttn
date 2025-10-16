<?php

namespace TCore\Marketing\Http\Controllers\Statistic;

use App\Enums\Customer\CustomerType;
use App\Models\Source;
use Illuminate\Http\Request;
use TCore\Marketing\Http\DataView\StatisticData;
use Theme\Cms\Http\Controllers\Controller;

class StatisticController extends Controller
{
    public function __construct(
        public StatisticData $data,
        public Source $modelSource
    )
    {
    }
    public function index(Request $request)
    {
        $data = $this->data->make($request);

        return view('packages_marketing::statistics.index')

        ->with('sources', $this->modelSource->all())

        ->with('total_contact', $data->totalContactWithSamePeriod())

        ->with('total_revenue', $data->totalRenueveWithSamePeriod())

        ->with('total_order', $data->totalOrderWithSamePeriod())

        ->with('conversion_rate', $data->conversionRate())

        ->with('data_chart_area', $data->getDataChartArea())

        ->with('data_chart_range_price', $data->getDataChartRangePrice())
        
        ->with('data_chart_sector', $data->getDataChartSector())

        ->with('data_chart_source', $data->getDataChartSource())

        ->with('data_chart_revenue', $data->getDataChartRevenue())

        ->with('data_chart_contact_status', $data->getDataChartContactStatus())

        ->with('customer_type', CustomerType::asSelectArray())

        ->with('breadcrumbs', $this->breadcrumbs()->add(trans('Thống kê')));
    }
}