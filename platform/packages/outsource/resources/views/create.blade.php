@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core_base::form class="block-double-click" :action="route('outsource.project.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('packages_outsource::forms.create-left')
                    @include('packages_outsource::forms.create-right')
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

@push('js')
    <input type="hidden" name="route_info_order" value="{{ route('outsource.project.order_info') }}">
    <input type="hidden" name="route_info_requirement" value="{{ route('outsource.project.requirement_info') }}">
    <script>
        $('.select-info').on('change', function() {
            var params = {
                order_id: $(this).val()
            };

            var render = $(this).data('render'), route = $($(this).data('ip-route')).val();

            var successHandle = function(res) {
                $(render).html(res);
            }

            AjaxLibrary.get(
                route,
                params,
                successHandle,
            )
        });
    </script>
@endpush
