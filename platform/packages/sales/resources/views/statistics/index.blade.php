@extends('themes_cms::layouts.master')

@push('css')
    <style>
        .chart-column {
            height: 450px;
        }

        .chart-pie {
            height: 450px;
        }

        .chart-pie-small {
            height: 205px;
        }
    </style>
@endpush

@section('content')
<div class="page-body">
    <div class="container-xl">
        @include('packages_sales::statistics.partials.filter')
        @include('packages_sales::statistics.partials.total')
        <div class="row mt-3">
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">@lang('Doanh thu')</h3>
                        <div id="chartRevenue" class="chart-column"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">@lang('Khách liên hệ')</h3>
                        <div id="chartStatusContact" class="chart-pie"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">@lang('Nguồn Data')</h3>
                        <div id="chartSource" class="chart-column"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">@lang('Phân loại khách')</h3>
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <h4 class="mb-0 text-center">@lang('Lĩnh vực')</h4>
                                <div id="chartSector" class="chart-pie-small"></div>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0 text-center">@lang('Khu vực')</h4>
                                <div id="chartArea" class="chart-pie-small"></div>
                            </div>
                            <div class="col-6">
                                <div id="chartRangePrice" class="chart-pie-small"></div>
                                <h4 class="mb-0 text-center">@lang('Tầm giá')</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('core_base::amchart.scripts')

@include('core_base::amchart.column')
@include('core_base::amchart.pie-type')

@push('js')
<x-core_base::input type="hidden" name="chart_revenue" :value="$data_chart_revenue" />
<x-core_base::input type="hidden" name="chart_source" :value="$data_chart_source" />
<x-core_base::input type="hidden" name="chart_contact_status" :value="$data_chart_contact_status" />
<x-core_base::input type="hidden" name="chart_sector" :value="$data_chart_sector" />
<x-core_base::input type="hidden" name="chart_range_price" :value="$data_chart_range_price" />
<x-core_base::input type="hidden" name="chart_area" :value="$data_chart_area" />
<script>
    amchartColumn("chartRevenue", $("input[name='chart_revenue']").val(), 'revenue_date', 'revenue_total');
    amchartColumn("chartSource", $("input[name='chart_source']").val(), 'label', 'total');
    amchartPie("chartStatusContact", $("input[name='chart_contact_status']").val(), 'status', 'total');
    amchartPieStyle2("chartSector", $("input[name='chart_sector']").val(), 'label', 'total');
    amchartPieStyle2("chartRangePrice", $("input[name='chart_range_price']").val(), 'label', 'total');
    amchartPieStyle2("chartArea", $("input[name='chart_area']").val(), 'label', 'total');
</script>
@endpush
