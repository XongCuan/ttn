<?php

namespace TCore\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use TCore\Superadmin\Repositories\Admin\AdminRepositoryInterface;

class AdminSearchSelectController
{
    public function __construct(
        public AdminRepositoryInterface $repo
    )
    {
        
    }

    public function employees(Request $request)
    {
        return [
            'results' => $this->repo->getByQueryBuilder([
                'is_superadmin' => false,
                'team_id' => null,
                ['managerDepartments', 'DOESNTHAVE', true]
            ])
            ->whereAny(['fullname'], 'like', '%' . $request->input('term', '') . '%')
            ->get()
            ->map(fn($item) => ['id' => $item->id, 'text' => $item->fullname])
        ];
    }

    public function allEmployees(Request $request)
    {
        return [
            'results' => $this->repo->getByQueryBuilder([
                'is_superadmin' => false,
            ])
            ->whereAny(['fullname'], 'like', '%' . $request->input('term', '') . '%')
            ->get()
            ->map(fn($item) => ['id' => $item->id, 'text' => $item->fullname])
        ];
    }
}