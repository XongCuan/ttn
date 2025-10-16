@extends('themes_cms::layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div id="ckfinderWidget"></div>
        </div>
    </div>
@endsection

@push('libs-js')
    @include('ckfinder::setup')
@endpush

@push('js')
<script>
	CKFinder.widget( 'ckfinderWidget', {
        width: '100%',
        height: 700
    });
</script>
@endpush
