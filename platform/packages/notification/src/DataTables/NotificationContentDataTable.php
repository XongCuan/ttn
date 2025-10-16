<?php

namespace TCore\Notification\DataTables;

use App\Models\NotificationContent;
use TCore\Base\Enums\Department;
use TCore\DataTable\Supports\DataTables;

class NotificationContentDataTable extends DataTables
{
    public string $nameTable = 'notificationContent';

    public function __construct(
        public NotificationContent $model
    )
    {
        
    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = [
            'title', 'created_by', 'created_at'
        ];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = [
            'created_at'
        ];
    }

    public function query()
    {
        $filter = [];

        if(get_auth_admin()->isSuperadmin() == false)
        {
            $filter['created_by'] = get_auth_admin()->id;
        }

        return $this->model->makeQuery(filter: $filter, relations: ['createdBy']);
    }

    protected function setRemoveColumns(): void
    {
        if(get_auth_admin()->isRoleManager())
        {
            $this->removeColumns = [
                'created_by'
            ];
        }
    }

    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'created_by' => fn($q, $k) => $q->whereRelation('createdBy', 'fullname', 'like', "%$k%")
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'created_at' => '{{ format_date($created_at) }}',
            'created_by' => fn($row) => $row->createdBy->fullname
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'target' => function($row) {

                if($row->is_all)
                {
                    return trans('Toàn bộ nhân viên');
                }

                if($row->target_deparments)
                {
                    $departments = Department::asSelectArray();

                    $data = array_intersect_key($departments, array_flip($row->target_deparments->toArray()));

                    return implode(", ", $data);
                }

                return;
            },
            'action' => 'packages_notification::datatables.columns.action'
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'target'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            
            'title' => [
                'title' => 'Tiêu đề',
                'orderable' => false,
            ],

            'target' => [
                'title' => 'Gửi đến',
                'orderable' => false,
            ],

            'created_by' => [
                'title' => 'Người gửi',
                'orderable' => false,
            ],

            'created_at' => [
                'title' => 'Ngày tạo',
                'orderable' => false,
            ],

            'action' => [
                'title' => 'Hành động',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center'
            ]
        ];
    }
}