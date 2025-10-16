import lang from "../libs/filepond/locale/vi-vi.js";

FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginImageResize,
    FilePondPluginFileValidateType
);

var filePondConfig = $.extend(lang, {
    // allowMultiple: true,
    maxFileSize: "50MB",
    // maxFiles: 5,
    acceptedFileTypes: [
        "image/*",
        "application/pdf",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    ],
    chunkUploads: true,
    chunkSize: 10000000,

    imageResizeMode: "contain",
    imageResizeTargetWidth: 1000,
    // imageResizeTargetHeight: 750,
    // imagePreviewHeight: 400,
    // imagePreviewMaxHeight: 750,
});

$.fn.filepond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginImageResize,
    FilePondPluginFileValidateType
);

$.fn.filepond.setDefaults(filePondConfig);


function initializeFilePond() {
    $(".filepond").each(function () {
        var files = $($(this).parent().data("target-file")).val();

        var filepond = FilePond.create(this);

        filepond.setOptions(filePondConfig);

        if (files) {
            files = files
                .split(",")
                .map((value) => urlHome + "/" + value.replace(/^\//, ""));

            filepond.addFiles(files);
        }
    });
}

initializeFilePond();

$(document).on("shown.bs.modal", ".modal.modal-load-ajax", function () {
    initializeFilePond();
});
