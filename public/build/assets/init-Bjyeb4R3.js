const token = jQuery('meta[name="csrf-token"]').attr("content");
const urlHome = jQuery('meta[name="url-home"]').attr("content");
const currency = jQuery('meta[name="currency"]').attr("content");
const positionCurrency = jQuery('meta[name="position_currency"]').attr("content");
function generateUID(prefix = "") {
  return prefix + Math.floor(Math.random() * 26) + Date.now();
}
function input_format_number(value) {
  value = value.replace(/\D/g, "");
  return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), sep = typeof thousands_sep === "undefined" ? "," : thousands_sep, dec = typeof dec_point === "undefined" ? "." : dec_point, s = "", toFixedFix = function(n2, prec2) {
    var k = Math.pow(10, prec2);
    return "" + Math.round(n2 * k) / k;
  };
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}
function removeOverlayLoading(elm) {
  elm = $(elm);
  elm.find("#overlayLoading").remove();
  elm.find("button[type='submit']").css("opacity", "1");
  elm.find("button[type='submit'] .spinner-grow").remove();
}
function addOverlayLoading(elm) {
  elm = $(elm);
  elm.prepend('<div id="overlayLoading" style="position: absolute;width: 100%;height: 100%;background: #ffffff91;z-index: 10;"></div>');
  elm.find("button[type='submit']").css("opacity", "0.5");
  elm.find("button[type='submit']").prepend('<span class="spinner-grow spinner-grow-sm"></span>');
}
function copyText(text) {
  var input = $("<input>").val(text);
  $("body").append(input);
  input.select();
  document.execCommand("copy");
  input.remove();
  msgSuccess(window.__trans("copySuccess"));
}
$(document).on("submit", "form.block-double-click", function() {
  addOverlayLoading(this);
});
$(document).on("click", ".copy-text", function() {
  var text = $(this).data("text");
  copyText(text);
});
$(document).ready(function() {
  addSelect2();
  select2LoadDataMany();
  select2LoadData();
});
$(document).on("submit", "#formMultiple", function(e) {
  if ($(".check-list:checked").length == 0) {
    e.preventDefault();
    $.toast({
      heading: window.__trans("notìy"),
      text: window.__trans("pleaseChooseRecord"),
      position: "top-right",
      icon: "warning"
    });
    endAjax($(this), window.__trans("apply"));
    return;
  }
  if (!confirm(window.__trans("Bạn có muốn thực hiện?"))) {
    e.preventDefault();
    endAjax($(this), window.__trans("apply"));
    return;
  }
});
$(document).on("keyup", ".inp-number-format", function() {
  var value = $(this).val();
  $(this).val(input_format_number(value));
});
$(document).on("click", ".check-all", function(e) {
  $(".check-list").prop("checked", $(this).prop("checked"));
  if ($(this).prop("checked") == true) {
    $(".check-all").prop("checked", true);
    $(".select-action-multiple").removeAttr("style");
  } else {
    $(".check-all").prop("checked", false);
    $(".select-action-multiple").css("display", "none");
  }
});
$(document).on("click", ".check-list", function(e) {
  if ($(this).prop("checked") == false) {
    $(".check-all").prop("checked", false);
  }
  if ($(".check-list:checked").length == $(".check-list").length) {
    $(".check-all").prop("checked", true);
  }
  if ($(".check-list:checked").length > 0) {
    $(".select-action-multiple").removeAttr("style");
  } else {
    $(".select-action-multiple").css("display", "none");
  }
});
