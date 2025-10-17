<div class="col-12 col-md-10">
    <div class="card">
        <div class="row card-body card-enq">
            <!-- Mã ENQ - Tự động sinh -->
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Mã ENQ'):</label>
                    <x-core_base::input name="enq_code" :value="old('enq_code', 'Tự động sinh ENQ')" readonly
                        :placeholder="__('ENQ tự động sinh')" />
                </div>
            </div>

            <!-- Tên Khách Hàng - Select từ bảng customers -->
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label required">@lang('Tên Khách Hàng'):</label>
                    <x-core_base::select name="customer_id" id="customer_id" required>
                        <option value="">-- Chọn khách hàng --</option>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->fullname }} - {{ $customer->company }}
                        </option>
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>

            <!-- Loại Khách Hàng -->
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Loại Khách Hàng'):</label>
                    <x-core_base::select name="gender">
                        @foreach ($gender as $key => $value)
                        <x-core_base::select.option :selected="$data->gender->value ?? null" :value="$key"
                            :title="$value" />
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>

            <!-- Hãng -->
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Hãng'):</label>
                    <x-core_base::select name="brand_id">
                        <option value="">-- Chọn hãng --</option>
                    </x-core_base::select>
                </div>
            </div>

            <!-- Trạng thái - Mặc định: Pending -->
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Trạng thái'):</label>
                    <x-core_base::input name="status_display" :value="__('Pending')" readonly
                        class="form-control-plaintext" />
                    <input type="hidden" name="status" value="Pending">
                </div>
            </div>


            <!-- ===== BẢNG CHI TIẾT SẢN PHẨM ===== -->
            <div class="col-12">
                <h5 class="mb-3">@lang('Chi tiết yêu cầu báo giá')</h5>

                <div class="table-responsive">
                    <table id="enqDetailsTable" class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th width="40">No</th>
                                <th width="40">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th width="150">Mã code</th>
                                <th width="300">Mô tả Sale</th>
                                <th width="100">Số lượng</th>
                                <th width="100">Đơn vị</th>
                                <th width="250">Ghi chú</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be added dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Buttons -->
                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-primary" id="btnAddRow">
                        <i class="ti ti-plus"></i> Thêm dòng
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" id="btnCopyRow">
                        <i class="ti ti-copy"></i> Copy
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="btnDeleteRows">
                        <i class="ti ti-trash"></i> Xóa đã chọn
                    </button>
                </div>

                <!-- Hidden input to store details as JSON -->
                <input type="hidden" name="details" id="enqDetailsData">
            </div>

        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
  
    
    let rowIndex = 0;

    // Add new row
    function addRow(data = {}) {
        rowIndex++;
        const row = `
            <tr data-index="${rowIndex}">
                <td class="text-center">${rowIndex}</td>
                <td class="text-center">
                    <input type="checkbox" class="row-checkbox">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="code_${rowIndex}" value="${data.code || ''}" 
                           placeholder="Mã code">
                </td>
                <td>
                    <textarea class="form-control form-control-sm" 
                              name="description_${rowIndex}" rows="2" 
                              placeholder="Mô tả sản phẩm">${data.description_sale || ''}</textarea>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" 
                           name="quantity_${rowIndex}" value="${data.quantity || 1}" 
                           min="1" placeholder="SL">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                           name="unit_${rowIndex}" value="${data.unit || ''}" 
                           placeholder="Đơn vị">
                </td>
                <td>
                    <textarea class="form-control form-control-sm" 
                              name="note_${rowIndex}" rows="2" 
                              placeholder="Ghi chú">${data.note || ''}</textarea>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btn-delete-row">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        document.querySelector('#enqDetailsTable tbody').insertAdjacentHTML('beforeend', row);
        updateRowNumbers();
    }

    // Update row numbers
    function updateRowNumbers() {
        document.querySelectorAll('#enqDetailsTable tbody tr').forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
        });
    }

    // Collect data from table
    function collectTableData() {
        const details = [];
        document.querySelectorAll('#enqDetailsTable tbody tr').forEach((row, index) => {
            const idx = row.getAttribute('data-index');
            details.push({
                code: row.querySelector(`[name="code_${idx}"]`).value,
                description_sale: row.querySelector(`[name="description_${idx}"]`).value,
                quantity: row.querySelector(`[name="quantity_${idx}"]`).value || 1,
                unit: row.querySelector(`[name="unit_${idx}"]`).value,
                note: row.querySelector(`[name="note_${idx}"]`).value,
                sort_order: index + 1
            });
        });
        return details;
    }

    // Add row button
    document.getElementById('btnAddRow').addEventListener('click', function() {
        addRow();
    });

    // Delete single row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-row')) {
            e.target.closest('tr').remove();
            updateRowNumbers();
        }
    });

    // Delete selected rows
    document.getElementById('btnDeleteRows').addEventListener('click', function() {
        document.querySelectorAll('.row-checkbox:checked').forEach(cb => {
            cb.closest('tr').remove();
        });
        updateRowNumbers();
    });

    // Copy selected row
    document.getElementById('btnCopyRow').addEventListener('click', function() {
        const selectedRow = document.querySelector('.row-checkbox:checked');
        if (selectedRow) {
            const tr = selectedRow.closest('tr');
            const idx = tr.getAttribute('data-index');
            const data = {
                code: tr.querySelector(`[name="code_${idx}"]`).value,
                description_sale: tr.querySelector(`[name="description_${idx}"]`).value,
                quantity: tr.querySelector(`[name="quantity_${idx}"]`).value,
                unit: tr.querySelector(`[name="unit_${idx}"]`).value,
                note: tr.querySelector(`[name="note_${idx}"]`).value
            };
            addRow(data);
        } else {
            alert('Vui lòng chọn dòng cần copy!');
        }
    });

    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.row-checkbox').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    // Before submit form, collect data to hidden input
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const details = collectTableData();
            document.getElementById('enqDetailsData').value = JSON.stringify(details);
        });
    }

    // Add first row on load
    addRow();
});
</script>