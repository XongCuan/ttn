@extends('themes_cms::layouts.master')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <x-core_base::form class="block-double-click" :action="route('sales.enq.update')" type="put" :validate="true">
            <x-core_base::input type="hidden" name="id" :value="$data->id" />
            <div class="row justify-content-center">
                @include('packages_sales::enqs.forms.edit-left')
                @include('packages_sales::enqs.forms.edit-right')
            </div>
            @include('themes_cms::common.actions-fixed')
        </x-core_base::form>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
@include('ckfinder::setup')
@endpush