@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <x-core_base::form class="block-double-click" :action="route('auth.profile.update')" type="put" enctype="multipart/form-data" :validate="true">
                    <div class="card">
                        <div class="card-body">
                            <!-- fullname -->
                            <div class="mb-3">
                                <label class="form-label">@lang('Họ và tên'):</label>
                                <x-core_base::input name="fullname" :value="$auth->fullname" :required="true" placeholder="{{ __('Họ và tên') }}"/>
                            </div>
                            <!-- phone -->
                            <div class="mb-3">
                                <label class="form-label">@lang('Số điện thoại'):</label>
                                <x-core_base::input.phone name="phone" :value="$auth->phone" :required="true" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('Ngày sinh'):</label>
                                <x-core_base::input type="date" name="birthday" :value="$auth->birthday" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('Giới tính'):</label>
                                <x-core_base::select name="gender">
                                    @foreach ($gender as $key => $value)
                                        <x-core_base::select.option :selected="$auth->gender->value" :value="$key" :title="$value" />
                                    @endforeach
                                </x-core_base::select>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-center">
                                <button type="submit" class="btn btn-primary">@lang('Cập nhật')</button>
                            </div>
                        </div>
                    </div>
                    </x-core_base::form>
                </div>
            </div>
        </div>
    </div>
@endsection
