
var initialAjaxFormLibrary = {
    target: $('.ajax-modal-form'), // form hiện tại
    modalTarget: $('.modal'), // modal hiện tại
    method: 'GET', // phương thức call
    url: '', // url call lên server
    loadDatatable: false, // true: sẽ load lại datatable
    closeModal: true, // true: sẽ đóng modal khi thành công
    // Lấy dữ liệu từ form
    getData: function() {
        return this.target.serialize();
    },
    //set modal form khi người dùng thao tác
    setModalTarger: function() {
        this.modalTarget = this.target.parents('.modal');
    },
    //get modal form khi người dùng thao tác
    getModalTarger: function() {
        this.setModalTarger();
        return this.modalTarget;
    },
    setMethod: function() {
        if(this.target.attr('method').toUpperCase() == 'POST')
        {
            this.method = 'POST';

            if(this.target.find('input[name="_method"]').length == 1)
            {
                this.method = this.target.find('input[name="_method"]').val();
            }
        }
        this.method = this.method.toUpperCase();
    },
    getMethod: function() {
        this.setMethod();
        return this.method;
    },
    setUrl: function() {
        this.url = this.target.attr('action');
    },
    getUrl: function() {
        this.setUrl();
        return this.url;
    },
    setLoadDatatable: function() {
        if(this.target.data('load-dt') && this.target.data('load-dt') == true)
        {
            this.loadDatatable = true;
        }else {
            this.loadDatatable = false;
        }

    },
    getLoadDatatable: function() {
        this.setLoadDatatable();
        return this.loadDatatable;
    },
    getCloseModal: function() {
        if(this.target.data('close-modal') == '' || this.target.data('close-modal') == null)
        {
            this.closeModal = true;   
        }else {
            this.closeModal = this.target.data('close-modal');
        }
        return this.closeModal;
    },
    // gọi trước khi send
    beforeRequest: function() {
        addOverlayLoading(this.target);
        this.target.parsley();
    },
    //gọi trước khi thành công response kết quả
    beforeSuccess: function(response) {},
    //gọi sau khi thành công response kết quả
    afterSuccess: function(response) {},
    
    //gọi khi thành công response kết quả
    success: function(response) {

        this.beforeSuccess(response);
        
        if(response.error == true)
        {
            msgError(response.msg);

            return;
        }

        msgSuccess(response.msg);

        if(response.url_redirect)
        {
            window.location.href = response.url_redirect;
        }
        
        if(this.getModalTarger().length > 0 && this.getCloseModal() == true)
        {
            ModalLibrary.close();
        }

        if(this.getLoadDatatable())
        {
            this.handleLoadDatatable();
        }

        this.afterSuccess(response);
    },

    beforeComplete: function(response) {},

    afterComplete: function(response) {},

    complete: function(response) {

        this.beforeComplete(response);

        removeOverlayLoading(this.target);

        this.afterComplete(response);
    },
    handleLoadDatatable: function(tableId = null) {

        var typeDraw = false;

        if(this.getMethod() == 'POST')
        {
            typeDraw = true;
        }

        if(tableId == null)
        {
            tableId = this.target.data('table-id');
        }

        if ($('#' + tableId).length == 0)
        {
            location.reload();
        }
        
        var dt = window.LaravelDataTables[tableId];
        
        if(typeDraw)
        {
            dt.search('');
            dt.columns().search('');
        }

        dt.draw(typeDraw);
    },
    ajaxRequest: function() {
        
        this.beforeRequest();
        
        AjaxLibrary.ajaxRequest(
            this.getUrl(), 
            this.getMethod(), 
            this.getData(), 
            this.success.bind(AjaxFormLibrary), 
            handleAjaxError, 
            this.complete.bind(AjaxFormLibrary)
        );
    }
};

var AjaxFormLibrary = {...initialAjaxFormLibrary};

function resetAjaxFormLibrary() {
    AjaxFormLibrary = {...initialAjaxFormLibrary};
}

$(document).on('submit', '.ajax-modal-form', function(e) {
    e.preventDefault();
    resetAjaxFormLibrary();
    AjaxFormLibrary.target = $(this);
    AjaxFormLibrary.ajaxRequest();
})