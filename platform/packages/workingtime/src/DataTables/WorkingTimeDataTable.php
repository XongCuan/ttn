<?php

namespace TCore\WorkingTime\DataTables;

use TCore\Base\Enums\WorkingTimeStatus;
use TCore\DataTable\Supports\DataTables;
use TCore\WorkingTime\Repositories\WorkingTime\WorkingTimeRepositoryInterface;

class WorkingTimeDataTable extends DataTables
{

    public string $nameTable = 'workingtimeTable';
    public function __construct(
        public WorkingTimeRepositoryInterface $repository
    ) {}

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = get_auth_admin()->isSuperadmin() ? ['date', 'status', 'admin_id'] : ['date', 'status'];
    }


    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['date'];
    }
    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => WorkingTimeStatus::asSelectArray()
            ]
        ];
    }

    protected function makeBuilderDataTable($query): void
    {
        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
    }


    protected function setRemoveColumns(): void
    {
        if (!get_auth_admin()->isSuperadmin())
        {
            $this->removeColumns = ['action'];

            if(request()->routeIs('working_time.index'))
            {
                $this->removeColumns[] = 'admin_id';
            }
        }
    }

    public function makeParameters(): array
    {
        return $this->parameters = [
            'ordering' => false,
            'autoWidth' => false,
            'language' => [
                'url' => asset('libs/datatables/lang/' . trans()->getLocale() . '.json')
            ],
            'rowCallback' => "function(row, data, index) {
                if (data.total_working_hours < 8 && data.check_out) {
                    $(row).addClass('insufficient-hours');
                    $(row).attr('title', 'Chưa đủ 8 giờ làm việc');
                }
            }",
            'createdRow' => "function(row, data, index) {
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                var dateStr = data.date;
                var parts = dateStr.split('/');
                var checkInDate = new Date(parts[2], parts[1] - 1, parts[0]); 
                
                // Case 1: If date is before today and has check-in but no check-out
                if (checkInDate < today && data.check_in && !data.check_out) {
                    $(row).addClass('insufficient-hours');
                    $(row).tooltip({
                        title: 'Chưa checkout',
                        placement: 'top'
                    });
                }

                // Case 2: If today or future date, and checked in but not checked out after 9.5 hours
                else if (checkInDate >= today && data.check_in && !data.check_out) {
                    var checkInTime = new Date(data.check_in);
                    var currentTime = new Date();
                    var timeDiff = (currentTime - checkInTime) / (1000 * 3600);
                    
                    if (timeDiff > 9.5) { // After 9.5 hours from check-in (8h + 1.5h)
                        $(row).addClass('insufficient-hours');
                        $(row).tooltip({
                            title: 'Chưa checkout sau thời gian quy định',
                            placement: 'top'
                        });
                    }
                }

                // Case 3: If total working hours are less than 8 (including 1.5h break)
                else if (data.check_in && data.check_out && data.total_working_hours < 8) {
                    $(row).addClass('insufficient-hours');
                    $(row).tooltip({
                        title: 'Số giờ làm việc: ' + data.total_working_hours.toFixed(2) + ' giờ',
                        placement: 'top'
                    });
                }
            }"
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $filter = [];

        if ($filter_month = request()->get('filter_month')) {
            $filter[] = ['date', 'month', $filter_month];
        }

        if ($filter_year = request()->get('filter_year')) {
            $filter[] = ['date', 'year', $filter_year];
        }

        $query = $this->repository->getByQueryBuilder($filter, ['admin'], ['date', 'desc']);

        if(get_auth_admin()->isSuperadmin())
        {
            return $query;
        }

        if(request()->routeIs('working_time.index'))
        {
            return $query->where('admin_id', get_auth_admin()->id);
        }

        return $query->currentAuth();
    }

    protected function setFilterColumns(): void
    {

        $this->filterColumns = [
            'admin_id' => fn($q, $k) => $q->whereRelation('admin', 'fullname', 'like', "%$k%")
        ];
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'date' => '{{ format_date($date, "d/m/Y") }}',
            'admin_id' => fn($working_time) => view('packages_workingtime::working_times.datatables.columns.admin', ['working_time' => $working_time]),
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'status' => fn($working_time) => view('packages_workingtime::working_times.datatables.columns.status', ['status' => $working_time->status]),
            'action' => fn($working_time) => view('packages_workingtime::working_times.datatables.columns.action', ['working_time' => $working_time]),
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['action', 'admin_id'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'date' => [
                'title' => 'Ngày',
                'orderable' => false
            ],
            'check_in' => [
                'title' => 'Check in',
                'orderable' => false,
            ],
            'check_out' => [
                'title' => 'Check out',
                'orderable' => false,
            ],
            'status' => [
                'title' => 'Trạng thái',
                'orderable' => false,
            ],
            'admin_id' => [
                'title' => 'Nhân viên',
                'orderable' => false,
            ],
            'note' => [
                'title' => 'Ghi chú',
                'orderable' => false,
                'visible' => false,
            ],
            'action' => [
                'title' => 'Thao tác',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'align-middle text-center'
            ],
        ];
    }
}
