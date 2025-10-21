function msgSuccess(text) {
  $.toast({
    heading: window.__trans("success"),
    text,
    position: "top-right",
    icon: "success",
    hideAfter: 5e3
  });
}
function msgError(text) {
  $.toast({
    heading: window.__trans("fail"),
    text,
    position: "top-right",
    icon: "error",
    hideAfter: 1e4
  });
}
function msgWarning(text) {
  $.toast({
    heading: window.__trans("warning"),
    text,
    position: "top-right",
    icon: "warning",
    hideAfter: 1e4
  });
}
function handleAjaxError(errors) {
  console.log(errors);
  if (errors.status == 416 || errors.status == 422) {
    $.map(errors.responseJSON.errors, function(value) {
      value.forEach((element) => {
        msgError(element);
      });
    });
  } else {
    if (errors.responseJSON.error == true) {
      msgError(errors.responseJSON.msg);
    } else if (errors.status == 500) {
      msgError(errors.responseJSON.message ? errors.responseJSON.message : errors.statusText ? errors.statusText : errors.responseText);
    } else {
      msgError(errors.responseJSON.message ? errors.responseJSON.message : errors.responseJSON.msg);
    }
  }
}
