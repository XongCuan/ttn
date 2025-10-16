@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header fs-1 fw-bold">
                            {{ $data->title }}
                        </div>
                        <div class="card-body">
                            {!! $data->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
