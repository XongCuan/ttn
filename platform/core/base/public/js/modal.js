var initialModalLibrary = {
    target: $(".open-modal-form"),
    modalTarger: "",
    parent: $("body"),
    route: "",
    data: {},
    ajax: true,
    beforeOpen: function () {},
    afterOpen: function () {},
    beforeHandle: function () {},
    afterHandle: function () {},
    openAjax: function (modal) {
        
        if(modal.error == true)
        {
            msgError(modal.msg);
            return;
        }
        
        var id = generateUID("modal");

        modal = $(modal).attr("id", id);

        this.parent.append(modal);

        this.modalTarger = $(`#${id}`);

        this.beforeOpen();

        if (this.modalTarger.find('.ckeditor').length > 0) {
            
            this.modalTarger.find('.ckeditor').ckeditor();
        }

        if (this.modalTarger.find(".select2-bs5-ajax-many").length > 0) {
            select2LoadDataMany('.select2-bs5-ajax-many', '#' + id);
        }

        this.modalTarger.modal("show");

        this.afterOpen();
    },
    open: function () {
        this.beforeOpen();

        this.modalTarger.modal("show");

        this.afterOpen();
    },
    close: function () {
        this.modalTarger.modal("hide");

        if (this.ajax) {
            this.modalTarger.remove();
        }
    },
    setRoute: function () {
        if (this.target.data("route")) {
            this.route = this.target.data("route");
        }
    },
    getRoute: function () {
        this.setRoute();
        return this.route;
    },
    handleAjax: function () {
        this.beforeHandle();
        AjaxLibrary.get(
            this.getRoute(),
            this.data,
            this.openAjax.bind(ModalLibrary)
        );
        this.afterHandle();
    },
    handle: function () {
        this.beforeHandle();

        this.modalTarger = $(this.target.data("target"));

        var form = this.modalTarger.find("form");

        form.attr("action", this.getRoute());

        if (this.target.data("custom-handle")) {
            form.addClass(this.target.data("custom-handle"));
            form.removeClass("ajax-modal-form");
        }

        if (this.target.data("load-dt")) {
            form.data("load-dt", this.target.data("load-dt"));
        }
        if (this.target.data("table-id")) {
            form.data("table-id", this.target.data("table-id"));
        }

        this.open();

        this.afterHandle();
    },
};

var ModalLibrary = { ...initialModalLibrary };

// Hàm để reset lại đối tượng ModalLibrary
function resetModalLibrary() {
    ModalLibrary = { ...initialModalLibrary };
}

$(document).on("click", ".open-modal-form", function (e) {
    resetModalLibrary();
    ModalLibrary.target = $(this);
    ModalLibrary.handleAjax();
});

// xu ly mo modal xoa du lieu
$(document).on(
    "click",
    ".open-modal-delete, .open-modal-confirm-update",
    function () {
        resetModalLibrary();
        ModalLibrary.target = $(this);
        ModalLibrary.ajax = false;
        ModalLibrary.handle();
    }
);

$(document).on("shown.bs.modal", ".modal.modal-load-ajax", function () {
    if ($(this).find("form").length > 0) {
        $(this).find("form").parsley();
    }
});

$(document).on("hidden.bs.modal", ".modal.modal-load-ajax", function () {
    $(this).remove();
});
