var columns;
$(document).on("change", "input.toggle-vis", function(e) {
  e.preventDefault();
  var column = columns.column($(this).attr("data-column"));
  column.visible(!column.visible());
  addSelect2();
  select2LoadDataMany();
});
function searchColumsDataTable(datatable, column_search = [], column_date = [], column_select = [], column_select2 = []) {
  datatable.api().columns(column_search).every(function() {
    var column = this, input = document.createElement("input"), findColumnSelect, findColumnSelect2;
    input.setAttribute("class", "form-control"), flagColSelect2Ajax = false;
    if (column_date.length > 0 && column_date.indexOf(column.selector.cols) !== -1) {
      input.setAttribute("type", "date");
    } else if (column_select && Object.keys(column_select).length > 0 && column.selector.cols in column_select) {
      findColumnSelect = column_select[column.selector.cols];
      input = document.createElement("select");
      createSelectColumnUniqueDatatableAll(input, findColumnSelect.data);
    } else if (column_select2 && Object.keys(column_select2).length > 0 && column.selector.cols in column_select2) {
      var findColumnSelect2 = column_select2[column.selector.cols];
      input = document.createElement("select");
      if (findColumnSelect2.ajax === true && findColumnSelect2.url) {
        flagColSelect2Ajax = true;
        input.setAttribute("class", "form-select select2-bs5-ajax-many");
        input.setAttribute("multiple", "true");
        input.setAttribute("data-url", findColumnSelect2.url);
      } else {
        createSelect2ColumnDatatable(input, findColumnSelect2.data);
      }
    }
    input.setAttribute("placeholder", window.__trans("enterKeyword"));
    $(input).appendTo($(column.footer()).empty()).on("change", function() {
      column.search($(this).val(), false, false, true).draw();
    });
  });
}
function createSelectColumnUniqueDatatable(column, input) {
  var optionAll = document.createElement("OPTION");
  optionAll.text = window.__trans("all");
  optionAll.value = "";
  input.setAttribute("class", "form-select");
  input.append(optionAll);
  column.data().unique().sort().each(function(d, j) {
    var option = document.createElement("OPTION");
    option.value = option.text = d;
    input.append(option);
  });
}
function addWrapTableScroll(idTable) {
  $(idTable).wrap('<div class="wrap-table-scroll"></div>');
}
function moveSearchColumnsDatatable(idTable) {
  $(idTable + " thead").append($(idTable + " tfoot tr"));
}
function createSelect2ColumnDatatable(input, data) {
  input.setAttribute("class", "form-select select2-bs5");
  input.setAttribute("multiple", "true");
  if (typeof data === "object") {
    Object.keys(data).map((index) => {
      var option = document.createElement("OPTION");
      $.each(data[index], function(key, value) {
        option.value = key;
        option.text = value;
      });
      input.append(option);
    });
  } else {
    data.forEach(function(value, index) {
      var option = document.createElement("OPTION");
      option.value = option.text = value;
      input.append(option);
    });
  }
}
function createSelectColumnUniqueDatatableAll(input, data) {
  var optionAll = document.createElement("OPTION");
  optionAll.text = window.__trans("all");
  optionAll.value = "";
  input.setAttribute("class", "form-select");
  input.append(optionAll);
  if (typeof data === "object") {
    Object.keys(data).map((key) => {
      var option = document.createElement("OPTION");
      option.value = key;
      option.text = data[key];
      input.append(option);
    });
  } else {
    data.forEach(function(value, index) {
      var option = document.createElement("OPTION");
      option.value = option.text = value;
      input.append(option);
    });
  }
}
function toggleColumnsDatatable(columns2) {
  var headerColumns = columns2.header().map((d) => d.textContent).toArray(), htmlToggleColumns = "", checked;
  $.each(headerColumns, function(index, value) {
    checked = "";
    if (columns2.column(index).visible() === true) {
      checked = "checked";
    }
    htmlToggleColumns += `
            <label class="dropdown-item"><input class="toggle-vis form-check-input m-0 me-2" ${checked} type="checkbox" data-column="${index}">${value}</label>
        `;
    $(".drop-toggle-columns").html(htmlToggleColumns);
  });
}
