<div class="col-12 col-md-10">
    <div class="card">
        <div class="row card-body card-enq">

            <!-- Mã ENQ -->
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label">@lang('Mã ENQ'):</label>
                    <x-core_base::input name="enq_code" :value="old('enq_code', $data->enq_code)" readonly />
                </div>
            </div>

            <!-- Tên Khách Hàng (readonly, lấy từ chính bảng ENQ) -->
            <div class="col-6 col-md-6">
                <div class="mb-3">
                    <label class="form-label required">@lang('Tên Khách Hàng'):</label>

                    {{-- Hiển thị chỉ để xem --}}
                    <x-core_base::input name="customer_display" :value="$data->company" readonly />

                    {{-- Hidden input để giữ giá trị khi submit --}}
                    <input type="hidden" name="customer_id" value="{{ $data->customer_id }}">
                </div>
            </div>

            <!-- Loại khách hàng -->
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

            <!-- Trạng thái -->
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <label class="form-label">@lang('Trạng thái'):</label>
                    <x-core_base::select name="status">
                        @foreach ($status as $key => $value)
                        @php
                        $current = $data->status;
                        if (is_object($current) && property_exists($current, 'value')) {
                        $current = $current->value;
                        }
                        @endphp
                        <option value="{{ $key }}" {{ $current==$key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                        @endforeach
                    </x-core_base::select>
                </div>
            </div>

            <!-- ===== CHI TIẾT SẢN PHẨM ===== -->
            <div class="col-12">
                <h5 class="mb-3">@lang('Chi tiết yêu cầu báo giá')</h5>

                <div class="table-responsive" style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                    <table id="enqDetailsTable" class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th style="min-width: 40px;">No</th>
                                <th style="min-width: 40px;"><input type="checkbox" id="selectAll"></th>
                                <th style="min-width: 150px;">Mã code</th>
                                <th style="min-width: 250px;">Mô tả Sale</th>
                                <th style="min-width: 100px;">Số lượng</th>
                                <th style="min-width: 100px;">Đơn vị</th>

                                {{-- ✅ Các cột chỉ hiển thị khi đang edit --}}
                                @if(isset($data))
                                <th style="min-width: 120px;">Giá PO</th>
                                <th style="min-width: 120px;">Giá Local</th>
                                <th style="min-width: 150px;">Thời gian hàng</th>
                                @endif

                                <th style="min-width: 200px;">Ghi chú</th>
                                <th style="min-width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="enqDetailsBody">
                            {{-- JS sẽ tự thêm dòng --}}
                        </tbody>
                    </table>
                </div>

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

                <input type="hidden" name="details" id="enqDetailsData">
            </div>

        </div>
    </div>
</div>

{{-- ✅ SCRIPT với Number Format --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = 0;
    const oldDetails = @json($data->details ?? []);
    const isEditMode = {{ isset($data) ? 'true' : 'false' }};

    // ✅ Hàm format số thành dạng 1,234,567
    function formatNumber(num) {
        if (!num || num === '') return '';
        // Loại bỏ tất cả dấu phẩy trước
        let cleanNum = num.toString().replace(/,/g, '');
        // Kiểm tra có phải số không
        if (isNaN(cleanNum)) return num;
        // Format với dấu phẩy
        return cleanNum.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    // ✅ Hàm bỏ format (1,234,567 -> 1234567)
    function unformatNumber(str) {
        if (!str || str === '') return '';
        return str.toString().replace(/,/g, '');
    }

    // 🧱 Hàm thêm dòng
    function addRow(data = {}) {
        rowIndex++;
        const row = `
            <tr data-index="${rowIndex}">
                <td class="text-center">${rowIndex}</td>
                <td class="text-center"><input type="checkbox" class="row-checkbox"></td>

                <td><input type="text" class="form-control form-control-sm"
                    name="code_${rowIndex}" value="${data.code || ''}" placeholder="Mã code"></td>

                <td><textarea class="form-control form-control-sm"
                    name="description_${rowIndex}" rows="2" placeholder="Mô tả sản phẩm">${data.description_sale || ''}</textarea></td>

                <td><input type="number" class="form-control form-control-sm"
                    name="quantity_${rowIndex}" value="${data.quantity || 1}" min="1"></td>

                <td><input type="text" class="form-control form-control-sm"
                    name="unit_${rowIndex}" value="${data.unit || ''}" placeholder="Đơn vị"></td>

                ${isEditMode ? `
                    <td><input type="text" class="form-control form-control-sm inp-number-format"
                        name="unit_price_${rowIndex}" value="${formatNumber(data.unit_price) || ''}" placeholder="Giá PO"></td>

                    <td><input type="text" class="form-control form-control-sm inp-number-format"
                        name="total_price_${rowIndex}" value="${formatNumber(data.total_price) || ''}" placeholder="Giá Local"></td>

                    <td><input type="text" class="form-control form-control-sm"
                        name="delivery_time_${rowIndex}" value="${data.delivery_time || ''}" placeholder="Thời gian hàng"></td>
                ` : ''}

                <td><textarea class="form-control form-control-sm"
                    name="note_${rowIndex}" rows="2" placeholder="Ghi chú">${data.note || ''}</textarea></td>

                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btn-delete-row">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        document.querySelector('#enqDetailsTable tbody').insertAdjacentHTML('beforeend', row);
        updateRowNumbers();
        initNumberFormat(); // ✅ Khởi tạo format cho dòng mới
    }

    // ✅ Khởi tạo format số cho tất cả input có class inp-number-format
    function initNumberFormat() {
        document.querySelectorAll('.inp-number-format').forEach(input => {
            // Xóa event listener cũ để tránh duplicate
            input.replaceWith(input.cloneNode(true));
        });

        // Gán lại event listener mới
        document.querySelectorAll('.inp-number-format').forEach(input => {
            // Format khi nhập
            input.addEventListener('input', function(e) {
                let cursorPos = this.selectionStart;
                let oldLength = this.value.length;
                
                let val = this.value.replace(/,/g, '');
                
                // Chỉ cho phép nhập số và dấu chấm
                if (!/^\d*\.?\d*$/.test(val)) {
                    val = val.replace(/[^\d.]/g, '');
                }
                
                if (val !== '' && !isNaN(val)) {
                    this.value = formatNumber(val);
                    
                    // Điều chỉnh vị trí con trỏ
                    let newLength = this.value.length;
                    cursorPos += (newLength - oldLength);
                    this.setSelectionRange(cursorPos, cursorPos);
                }
            });

            // Format lại khi blur
            input.addEventListener('blur', function() {
                let val = unformatNumber(this.value);
                if (val !== '' && !isNaN(val)) {
                    this.value = formatNumber(val);
                }
            });
        });
    }

    // 🧮 Cập nhật số thứ tự
    function updateRowNumbers() {
        document.querySelectorAll('#enqDetailsTable tbody tr').forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
        });
    }

    // 📦 Thu thập dữ liệu khi submit
    function collectTableData() {
        const details = [];
        document.querySelectorAll('#enqDetailsTable tbody tr').forEach((row, index) => {
            const idx = row.getAttribute('data-index');
            const detail = {
                code: row.querySelector(`[name="code_${idx}"]`)?.value || '',
                description_sale: row.querySelector(`[name="description_${idx}"]`)?.value || '',
                quantity: row.querySelector(`[name="quantity_${idx}"]`)?.value || 1,
                unit: row.querySelector(`[name="unit_${idx}"]`)?.value || '',
                note: row.querySelector(`[name="note_${idx}"]`)?.value || '',
                sort_order: index + 1
            };

            // ✅ Bỏ format trước khi lưu vào DB
            if (isEditMode) {
                detail.unit_price = unformatNumber(row.querySelector(`[name="unit_price_${idx}"]`)?.value) || null;
                detail.total_price = unformatNumber(row.querySelector(`[name="total_price_${idx}"]`)?.value) || null;
                detail.delivery_time = row.querySelector(`[name="delivery_time_${idx}"]`)?.value || null;
            }

            details.push(detail);
        });
        return details;
    }

    // ⚙️ Các thao tác
    document.getElementById('btnAddRow').addEventListener('click', () => addRow());
    
    document.addEventListener('click', e => {
        if (e.target.closest('.btn-delete-row')) {
            e.target.closest('tr').remove();
            updateRowNumbers();
        }
    });

    document.getElementById('btnDeleteRows').addEventListener('click', () => {
        document.querySelectorAll('.row-checkbox:checked').forEach(cb => cb.closest('tr').remove());
        updateRowNumbers();
    });

    document.getElementById('btnCopyRow').addEventListener('click', () => {
        const selectedRow = document.querySelector('.row-checkbox:checked');
        if (!selectedRow) return alert('Vui lòng chọn dòng cần copy!');
        
        const tr = selectedRow.closest('tr');
        const idx = tr.getAttribute('data-index');
        const data = {
            code: tr.querySelector(`[name="code_${idx}"]`)?.value,
            description_sale: tr.querySelector(`[name="description_${idx}"]`)?.value,
            quantity: tr.querySelector(`[name="quantity_${idx}"]`)?.value,
            unit: tr.querySelector(`[name="unit_${idx}"]`)?.value,
            note: tr.querySelector(`[name="note_${idx}"]`)?.value
        };
        
        if (isEditMode) {
            data.unit_price = unformatNumber(tr.querySelector(`[name="unit_price_${idx}"]`)?.value);
            data.total_price = unformatNumber(tr.querySelector(`[name="total_price_${idx}"]`)?.value);
            data.delivery_time = tr.querySelector(`[name="delivery_time_${idx}"]`)?.value;
        }
        
        addRow(data);
    });

    // ✅ Chọn tất cả
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
    });

    // ✅ Submit form
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        const details = collectTableData();
        document.getElementById('enqDetailsData').value = JSON.stringify(details);
    });

    // ✅ Load dữ liệu cũ hoặc thêm dòng mới
    if (oldDetails.length > 0) {
        oldDetails.forEach(item => addRow(item));
    } else {
        addRow();
    }
});
</script>