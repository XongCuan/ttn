const lang = {
  labelIdle: 'Kéo thả tệp của bạn hoặc <span class="filepond--label-action"> Tìm kiếm </span>',
  labelInvalidField: "Trường chứa các tệp không hợp lệ",
  labelFileWaitingForSize: "Đang chờ kích thước",
  labelFileSizeNotAvailable: "Kích thước không có sẵn",
  labelFileLoading: "Đang tải",
  labelFileLoadError: "Lỗi khi tải",
  labelFileProcessing: "Đang tải lên",
  labelFileProcessingComplete: "Tải lên thành công",
  labelFileProcessingAborted: "Đã huỷ tải lên",
  labelFileProcessingError: "Lỗi khi tải lên",
  labelFileProcessingRevertError: "Lỗi khi hoàn nguyên",
  labelFileRemoveError: "Lỗi khi xóa",
  labelTapToCancel: "nhấn để hủy",
  labelTapToRetry: "nhấn để thử lại",
  labelTapToUndo: "nhấn để hoàn tác",
  labelButtonRemoveItem: "Xoá",
  labelButtonAbortItemLoad: "Huỷ bỏ",
  labelButtonRetryItemLoad: "Thử lại",
  labelButtonAbortItemProcessing: "Hủy bỏ",
  labelButtonUndoItemProcessing: "Hoàn tác",
  labelButtonRetryItemProcessing: "Thử lại",
  labelButtonProcessItem: "Tải lên",
  labelMaxFileSizeExceeded: "Tập tin quá lớn",
  labelMaxFileSize: "Kích thước tệp tối đa là {filesize}",
  labelMaxTotalFileSizeExceeded: "Đã vượt quá tổng kích thước tối đa",
  labelMaxTotalFileSize: "Tổng kích thước tệp tối đa là {filesize}",
  labelFileTypeNotAllowed: "Tệp thuộc loại không hợp lệ",
  fileValidateTypeLabelExpectedTypes: "Kiểu tệp hợp lệ là {allButLastType} hoặc {lastType}",
  imageValidateSizeLabelFormatError: "Loại hình ảnh không được hỗ trợ",
  imageValidateSizeLabelImageSizeTooSmall: "Hình ảnh quá nhỏ",
  imageValidateSizeLabelImageSizeTooBig: "Hình ảnh quá lớn",
  imageValidateSizeLabelExpectedMinSize: "Kích thước tối thiểu là {minWidth} × {minHeight}",
  imageValidateSizeLabelExpectedMaxSize: "Kích thước tối đa là {maxWidth} × {maxHeight}",
  imageValidateSizeLabelImageResolutionTooLow: "Độ phân giải quá thấp",
  imageValidateSizeLabelImageResolutionTooHigh: "Độ phân giải quá cao",
  imageValidateSizeLabelExpectedMinResolution: "Độ phân giải tối thiểu là {minResolution}",
  imageValidateSizeLabelExpectedMaxResolution: "Độ phân giải tối đa là {maxResolution}"
};
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
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
  ],
  chunkUploads: true,
  chunkSize: 1e7,
  imageResizeMode: "contain",
  imageResizeTargetWidth: 1e3
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
  $(".filepond").each(function() {
    var files = $($(this).parent().data("target-file")).val();
    var filepond = FilePond.create(this);
    filepond.setOptions(filePondConfig);
    if (files) {
      files = files.split(",").map((value) => urlHome + "/" + value.replace(/^\//, ""));
      filepond.addFiles(files);
    }
  });
}
initializeFilePond();
$(document).on("shown.bs.modal", ".modal.modal-load-ajax", function() {
  initializeFilePond();
});
