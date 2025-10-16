@extends('themes_cms::layouts.master')

@push('css')
    <style>
        .wrap-loop-input .add-image-ckfinder{
            width: auto !important;
        }
        #site_logo {
            width: 200px !important;
        }

    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core_base::form :action="$url_update" type="put" :validate="true">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9">
                        @include('packages_setting::forms.edit-left')
                    </div>
                    @include('packages_setting::forms.edit-right')
                </div>
            </x-core_base::form>
        </div>
    </div>
@endsection

@push('libs-js')

@endpush

@push('js')

@endpush
