<?php

namespace TCore\Outsource\DataTables;

use TCore\Base\Enums\Department;
use TCore\LeaveRequest\DataTables\LeaveRequestDataTable as DataTablesLeaveRequestDataTable;
class LeaveRequestDataTable extends DataTablesLeaveRequestDataTable
{

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = get_auth_admin()->hasManagerShipRoleOutsource()
            ? ['admin_id', 'type', 'status'] 
            : ['type', 'status'];
    }

    public function query()
    {
        $filter = [
            ['admin.team', 'HAS', function ($query) {
                $query->where('department', Department::Outsource);
            }]
        ];
    
        if ($filter_month = request()->get('filter_month')) {
            $filter[] = ['date', 'month', $filter_month];
        }
    
        if ($filter_year = request()->get('filter_year')) {
            $filter[] = ['date', 'year', $filter_year];
        }
    
        return $this->model->makeQuery($filter, ['admin.team']);
    }
    

    protected function setRemoveColumns(): void
    {
        if (!get_auth_admin()->hasManagerShipRoleOutsource()) {
            $this->removeColumns = ['admin_id', 'action'];
        }
    }

}