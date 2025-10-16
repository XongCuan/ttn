<?php

namespace TCore\Superadmin\DataTables;

use TCore\Base\Enums\WorkingTimeStatus;
use TCore\WorkingTime\DataTables\WorkingTimeDataTable;

class AdminWorkingTimeDataTable extends WorkingTimeDataTable
{

    public string $nameTable = 'adminWorkingtimeeTable';

    protected function setRemoveColumns(): void
    {
        $this->removeColumns = ['admin_id'];
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

        $filter['admin_id'] = $this->admin_id;

        $filter_month = request()->get('filter_month') ?? (now()->month == 1 ? 12 : now()->month - 1);

        $filter_year = request()->get('filter_year') ?? (now()->month == 1 ? now()->year - 1 : now()->year);

        $filter[] = ['date', 'month', $filter_month];
        $filter[] = ['date', 'year', $filter_year];

        return $this->repository->getByQueryBuilder($filter, ['admin'], ['date', 'desc']);
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'status' => fn($working_time) => view('packages_workingtime::working_times.datatables.columns.status', ['status' => $working_time->status]),
            'action' => 'packages_superadmin::admin.datatables.columns.action-workingtime',
        ];
    }
}
