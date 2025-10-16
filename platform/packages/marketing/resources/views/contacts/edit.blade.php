@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core_base::form class="block-double-click" :action="route('marketing.contact.update')" type="put" :validate="true">
                <x-core_base::input type="hidden" name="id" :value="$data->id" />
                <div class="row justify-content-center">
                    @include('packages_marketing::contacts.forms.edit-left')
                    @include('packages_marketing::contacts.forms.edit-right')
                </div>
                @include('themes_cms::common.actions-fixed')
            </x-core_base::form>
        </div>
    </div>
@endsection

@push('js')

@endpush
