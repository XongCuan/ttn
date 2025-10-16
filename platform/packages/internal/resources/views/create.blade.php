@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core_base::form class="block-double-click" :action="route('internal.project.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('packages_internal::forms.create-left')
                    @include('packages_internal::forms.create-right')
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
    <input type="hidden" name="route_info_order" value="{{ route('internal.project.order_info') }}">
    <script>
        $('select[name="order_id"]').on('change', function() {
            var params = {
                order_id: $(this).val()
            };
            var successHandle = function(res) {
                $('.order-info').html(res);
            }
            AjaxLibrary.get(
                $('input[name="route_info_order"]').val(),
                params,
                successHandle,
            )
        });
    </script>
@endpush
