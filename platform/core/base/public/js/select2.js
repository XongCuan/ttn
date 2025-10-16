function addSelect2(elm = '.select2-bs5', dropParent = null){
    if($(elm).length){
        $(elm).select2({
            placeholder: window.__trans('choose'),
            language: "vi",
            theme: 'bootstrap-5',
            dropdownParent: dropParent,
            allowClear: true
        });
    }
}

function select2LoadDataMany(target = '.select2-bs5-ajax-many', dropParent = null){
    var elm = $(target);
    if(elm.length > 0){
        elm.each(function () { 
            select2LoadData('', this, dropParent);
        });
    }
}

function select2LoadData(url = '', target = '.select2-bs5-ajax', dropParent = null){
    if($(target).length > 0){
        if(!url){
            url = $(target).data('url');
        }
    
        $(target).select2({
            placeholder: window.__trans('choose'),
            language: "vi",
            theme: 'bootstrap-5',
            dropdownParent: dropParent,
            allowClear: true,
            ajax: {
                delay: 250,  // wait 250 milliseconds before triggering the request
                url: url,
                dataType: 'json',
                processResults: function (data, params) {
                    return data;
                }
            }
        });
    }
}

$(document).on('change', '.select2-condition', function(e) {

    var val = $(this).val(),
        target = $(this).data('condition');
        
    $(target).val(null).trigger('change');
    select2LoadData($(target).data('url').replace(/\/[^\/]*$/, "/") + (val ? val : 0), target);
})