@push('js')
<script>
    $(document).on('click', '.btn-delete-item-pay', function(e) {
        e.preventDefault();
    
        const parent = $(this).parents('tr');
    
        parent.remove();
        
        if ($("#listPayment tbody tr.item-pay").length == 0)
        {
            $("#listPayment tbody tr.norecord").show();
        }
    });
    
    $(document).on('submit', '.ajax-modal-form-add-payment', function(e) {
        e.preventDefault();
        resetAjaxFormLibrary();
        AjaxFormLibrary.target = $(this);
    
        AjaxFormLibrary.beforeSuccess = function(response) {
            $("#listPayment tbody").append(response.data.html);
            $("#listPayment tbody tr.norecord").hide();
        }
    
        AjaxFormLibrary.ajaxRequest();
    })
</script>
@endpush