const viTrans = {
  "choose": "Chọn",
  "enterKeyword": "Nhập từ khóa",
  "all": "Tất cả",
  "success": "Thành công",
  "fail": "Thất bại",
  "warning": "Cảnh báo",
  "pleaseReload": "Vui lòng tải lại trang",
  "notify": "Thông báo",
  "pleaseChooseRecord": "Vui lòng chọn bản ghi",
  "apply": "Áp dụng",
  "alertConfirm": "Bạn có muốn thực hiện?"
};
const enTrans = {
  "choose": "Choose",
  "enterKeyword": "Enter keyword",
  "all": "All",
  "success": "Success",
  "fail": "Fail",
  "warning": "Warning",
  "pleaseReload": "Please reload page",
  "notify": "Notify",
  "pleaseChooseRecord": "Please choose entries",
  "apply": "Apply",
  "alertConfirm": "Are you sure?"
};
class Translator {
  constructor(language = "en", translations = {}) {
    this.language = language;
    this.translations = translations;
  }
  setLanguage(language) {
    this.language = language;
  }
  translate(key) {
    if (this.translations[this.language] && this.translations[this.language][key]) {
      return this.translations[this.language][key];
    }
    return key;
  }
}
const _trans = new Translator(document.documentElement.getAttribute("lang"), {
  vi: viTrans,
  en: enTrans
});
function __trans(text) {
  return _trans.translate(text);
}
window.__trans = __trans;
