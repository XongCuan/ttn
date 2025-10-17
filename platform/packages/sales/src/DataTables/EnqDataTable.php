<?php

namespace TCore\Sales\DataTables;

use App\Models\Enq;
use TCore\DataTable\Supports\DataTables;

class EnqDataTable extends DataTables
{
    public string $nameTable = 'enqTable';

    protected array $columnHasSearch = [];
    protected array $columnSearchDate = [];
    protected array $filterColumns = [];
    protected array $removeColumns = [];
    protected array $editColumns = [];
    protected array $addColumns = [];
    protected array $rawColumns = [];
    protected array $configColumns = [];

    public function __construct()
    {
        parent::__construct();
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['enq_code', 'company', 'short_name', 'tax_code', 'enq_type', 'admin_id', 'assigns', 'created_at'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'info' => fn($q, $k) => $q->whereAny(['fullname', 'phone'], 'like', "%{$k}%"),
            'admin_id' => fn($q, $k) => $q->whereRelation('creator', 'fullname', 'like', "%{$k}%"),
            'assigns' => fn($q, $k) => $q->whereRelation('assigns', 'fullname', 'like', "%{$k}%")
        ];
    }

    protected function setRemoveColumns(): void
    {
        if (get_auth_admin()->hasLeaderShipRoleSales() == false) {
            $this->removeColumns = [
                'assigns',
                'admin_id'
            ];
        }
    }

    public function query()
    {
        return enq::query()->with(['assigns', 'creator']);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'admin_id' => fn($data) => $data->creator?->fullname ?? '-',
            'created_at' => fn($row) => format_date($row->created_at)
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'info' => fn($data) => view('packages_sales::enqs.datatables.columns.info')->with('data', $data),
            'assigns' => fn($data) => $data->assigns->pluck('fullname')->implode(', ') ?: '-',
            'company' => fn($data) => e($data->company ?? '-'),
            'enq_code' => fn($data) => e($data->enq_code ?? '-'),

            // ✅ Hiển thị trạng thái có màu
            'status' => function ($data) {
                $status = $data->status?->name ?? 'Pending'; // lấy tên Enum
                $label = $data->status?->value ?? 'Pending'; // giá trị tiếng Việt

                $colors = [
                    'Pending' => 'secondary',   // xám
                    'TakingPrice' => 'warning', // vàng
                    'QuotedPrice' => 'info',    // xanh dương
                    'HavePo' => 'success',      // xanh lá
                ];

                $color = $colors[$status] ?? 'secondary';

                return '<span class="badge bg-' . $color . '">' . e($label) . '</span>';
            },

            'short_name' => fn($data) => e($data->short_name ?? '-'),
            'tax_code' => fn($data) => e($data->tax_code ?? '-'),
            'gender' => fn($data) => e($data->gender ?? '-'),
            'action' => 'packages_sales::enqs.datatables.columns.action',
        ];
    }
    protected function setRawColumns(): void
    {
     
        $this->rawColumns = ['action', 'info', 'status'];
    }

 

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'enq_code' => [
                'title' => 'Mã ENQ',
                'orderable' => false,
            ],
            'company' => [
                'title' => 'Công Ty',
                'orderable' => false,
            ],


            'gender' => [
                'title' => 'Loại Khách Hàng',
                'orderable' => false,
            ],

            'admin_id' => [
                'title' => 'Người Tạo',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'Ngày yêu cầu',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'action' => [
                'title' => 'Hành Động',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center'
            ]
        ];
    }
}
