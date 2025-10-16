@push('libs-js')
    <script src="{{ asset('public/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).on('click', '.btn-delete-item-serv', function(e) {
        e.preventDefault();

        const parent = $(this).parents('tr');

        parent.remove();
        
        if ($("#listService tbody tr.item-serv").length == 0)
        {
            $("#listService tbody tr.norecord").show();
        }
    });

    $(document).on('submit', '.ajax-modal-form-add-service', function(e) {
        e.preventDefault();
        resetAjaxFormLibrary();
        AjaxFormLibrary.target = $(this);

        AjaxFormLibrary.beforeSuccess = function(response) {
            $("#listService tbody").append(response.data.html);
            $("#listService tbody tr.norecord").hide();
        }

        AjaxFormLibrary.ajaxRequest();
    })

    $(document).on('click', '.open-modal-add-service', function(e) {
        
        var serviceType = $('select[name="service_type"]').val();

        resetModalLibrary();
        ModalLibrary.target = $(this);
        ModalLibrary.data = {service_type: serviceType};

        ModalLibrary.handleAjax();
    });

    $(document).on('change', 'input.toggle-elm', function() {
        if ($(this).prop('checked') == true)
        {
            $($(this).data('target')).show();
        }else {
            $($(this).data('target')).hide();
        }
    })
</script>
@endpush
