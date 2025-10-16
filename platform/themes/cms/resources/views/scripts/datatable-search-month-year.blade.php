
<script>
$(document).ready(function() {
    if($("input[name=id_table]").val())
    {
        var currenDatatable = window.LaravelDataTables[$("input[name=id_table]").val()];
            
        var urlAjaxDatatable = currenDatatable.ajax.url();
    
        $(document).on('click', '.btn-action-filter', function(e) {
        
            var filter_month = $('select[name=filter_month]').val();
    
            console.log(filter_month);
    
            var filter_year = $('select[name=filter_year]').val();
    
            if((filter_month && filter_year == '')) {
                msgWarning('Vui lòng chọn thêm năm để lọc dữ liệu');
                return;
            }
    
            var newUrlAjaxDatatable = urlAjaxDatatable + '/?filter_month=' + filter_month + '&filter_year=' + filter_year;
    
            window.LaravelDataTables[$("input[name=id_table]").val()].ajax.url(newUrlAjaxDatatable).load();
    
        });
    }
})
    
</script>