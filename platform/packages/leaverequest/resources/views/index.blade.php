@extends('themes_cms::layouts.datatable')

@push('libs-css')

<link rel="stylesheet" href="{{ asset('public/libs/filepond/dist/filepond.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/filepond/plugins/image-preview/dist/filepond-plugin-image-preview.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/libs/filepond/plugins/file-poster/filepond-plugin-file-poster.min.css') }}">

@endpush

@push('css')
    <style>
        .insufficient-hours {
            background-color: #fee2e2 !important;
            color: #7f1d1d;
        }
    </style>
@endpush

@section('datatable')
    <div class="card">
        <div class="card-header justify-content-between">
            <h2 class="mb-0">@lang('Danh sách')</h2>
            <div class="col-auto">
                <div class="card-header-action">
                    <div class="modal-button-container d-flex justify-content-end gap-1">
                        <button class="btn btn-primary open-modal-form" data-route="{{ route('leave_request.create') }}">
                            <i class="icon ti ti-plus"></i>
                            <span>@lang('Gửi đơn')</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="row justify-content-end mb-3">
                {{-- <div class="col-md-6">

                    @include('themes_cms::common.datatable-filter')
                </div> --}}
            </div>
            <div class="table-responsive position-relative">
                @include('core_datatable::common.toggle_column.show')
                {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('libs/filepond/dist/filepond.min.js') }}"></script>
    <script
        src="{{ asset('libs/filepond/plugins/image-preview/dist/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ asset('libs/filepond/plugins/file-validate-size/dist/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('libs/filepond/plugins/file-validate-type/dist/filepond-plugin-file-validate-type.min.js') }}">
    </script>

    <script
        src="{{ asset('libs/filepond/plugins/image-resize/dist/filepond-plugin-image-resize.min.js') }}">
    </script>
    <script
        src="{{ asset('libs/filepond/plugins/file-encode/dist/filepond-plugin-file-encode.min.js') }}">
    </script>
    <script src="{{ asset('libs/filepond/dist/filepond.jquery.js') }}"></script>
@endpush

@push('js')
    <script type="module" src="{{ vite_asset(core_public_asset('base', 'js/filepond.js')) }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on("shown.bs.modal", ".modal.modal-load-ajax", function() {

                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);

                var formattedTomorrow = tomorrow.toISOString().split('T')[0];

                // $('#startDate').prop('min', formattedTomorrow);

                $("#leaveType").change(function() {
                    if($(this).val() == '40')
                    {
                        $("#halfDay").hide();
                        $('#halfDayCheck').prop('checked', false).trigger('change');
                    }else {
                        $("#halfDay").show();
                    }
                })

                $('#halfDayCheck').change(function() {
                    if ($(this).is(':checked')) {
                        $('#halfDaySection').show();
                        $('#endDateSection').hide();
                        $('#endDate').val('');
                    } else {
                        $('#halfDaySection').hide();
                        $('#endDateSection').show();
                    }
                });

                $('#startDate').change(function() {
                    $('#endDate').attr('min', $(this).val());
                });

                // tu choi
                $('.btn-danger').on('click', function(e) {
                    e.preventDefault();

                    const rejectSection = $('#rejectReasonSection');

                    if (rejectSection.hasClass('d-none')) {
                        rejectSection.removeClass('d-none');
                        $('html, body').animate({
                            scrollTop: rejectSection.offset().top - 100,
                        }, 500);

                        $(this).text('@lang('Gửi')');
                        return;
                    }

                    const reason = $('#rejectReason').val().trim();
                    if (!reason) {
                        alert('@lang('Vui lòng nhập lý do từ chối!')');
                        return;
                    }

                    $('<input>').attr({
                        type: 'hidden',
                        name: 'submitter',
                        value: 'reject',
                    }).appendTo('#leaveRequestUpdate');

                    $('#leaveRequestUpdate').submit();
                });

            });
        });
    </script>
@endpush
