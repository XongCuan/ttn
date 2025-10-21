function selectImageCKFinder(preview, in_value, type) {
  CKFinder.popup({
    chooseFiles: true,
    width: 800,
    height: 600,
    onInit: function(finder) {
      finder.on("files:choose", function(evt) {
        if (type == "MULTIPLE") {
          var files = evt.data.files;
          var html = "", url_file;
          var value = $(in_value).val() ? $(in_value).val() + "," : "";
          files.forEach(function(file2, i) {
            url_file = file2.getUrl().replace(urlHome, "");
            html += `<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                                    <span data-route="0" data-url="${url_file}" class="delete-image-ckfinder">
                                        <i class="ti ti-x"></i>
                                    </span>
                                    <img src="${file2.getUrl()}" width="100%">
                                </div>`;
            if (i < files.length - 1) {
              value += url_file + ",";
            } else {
              value += url_file;
            }
          });
          $(preview).append(html);
          $(in_value).val(value);
        } else {
          var file = evt.data.files.first();
          $(preview).attr("src", file.getUrl());
          $(in_value).val(file.getUrl().replace(urlHome, ""));
        }
      });
    }
  });
}
function selectFileCKFinder(in_value) {
  CKFinder.popup({
    chooseFiles: true,
    width: 800,
    height: 600,
    onInit: function(finder) {
      finder.on("files:choose", function(evt) {
        var file = evt.data.files.first();
        $(in_value).val(file.getUrl().replace(urlHome, "")).trigger("change");
      });
    }
  });
}
function selectVideoCKFinder(preview, in_value, type) {
  CKFinder.popup({
    chooseFiles: true,
    width: 800,
    height: 600,
    onInit: function(finder) {
      finder.on("files:choose", function(evt) {
        if (type == "MULTIPLE") {
          var files = evt.data.files;
          var html = "", url_file;
          var value = $(in_value).val() ? $(in_value).val() + "," : "";
          files.forEach(function(file2, i) {
            url_file = file2.getUrl().replace(urlHome, "");
            html += `<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                                    <span data-route="0" data-url="${url_file}" class="delete-video-ckfinder">
                                        <i class="ti ti-x"></i>
                                    </span>
                                    <video src="${file2.getUrl()}" width="100%" controls></video>
                                </div>`;
            if (i < files.length - 1) {
              value += url_file + ",";
            } else {
              value += url_file;
            }
          });
          $(preview).append(html);
          $(in_value).val(value);
        } else {
          var file = evt.data.files.first();
          $(preview).attr("src", file.getUrl());
          $(in_value).val(file.getUrl().replace(urlHome, ""));
        }
      });
    }
  });
}
function deleteItemGallery(that, input) {
  var url = that.data("url"), url_file = input.val().replace(url, "");
  if (url_file.indexOf(",,") !== -1) {
    url_file = url_file.replace(",,", ",");
  }
  if (url_file.indexOf(",") == 0) {
    url_file = url_file.slice(1);
  }
  if (url_file.lastIndexOf(",") == url_file.length - 1) {
    url_file = url_file.slice(0, -1);
  }
  input.val(url_file);
}
$(document).on("click", ".add-image-ckfinder", function(e) {
  selectImageCKFinder($(this).data("preview"), $(this).data("input"), $(this).data("type"));
});
$(document).on("click", ".add-file-ckfinder", function(e) {
  selectFileCKFinder($(this).data("input"));
});
$(document).on("click", ".add-video-ckfinder", function(e) {
  selectVideoCKFinder($(this).data("preview"), $(this).data("input"), $(this).data("type"));
});
