@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core_base::form class="block-double-click" :action="route('sales.order.update')" type="put" :validate="true">
                <x-core_base::input type="hidden" name="order[id]" :value="$order->id" />
                <div class="row justify-content-center">
                    @include('packages_sales::orders.forms.edit-left')
                    @include('packages_sales::orders.forms.edit-right')
                </div>
                @include('themes_cms::common.actions-fixed')
            </x-core_base::form>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
@endpush

