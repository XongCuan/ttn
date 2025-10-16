<?php

namespace App\Models;

use TCore\Base\Enums\Department;
use TCore\Base\Models\BaseModel;
use TCore\WorkingTime\Enums\WorkingTimeTicketStatus;
use TCore\WorkingTime\Enums\WorkingTimeTicketType;

class WorkingTimeTicket extends BaseModel
{
    //
    protected $table = 'working_time_tickets';

    protected $fillable = [
        'admin_id',
        'status',
        'ticket_date',
        'type',
        'reason',
        'reason_refuse',
        'attachment_path'
    ];

    protected function casts()
    {
        return [
            'ticket_date' => 'date',
            'type' => WorkingTimeTicketType::class,
            'status' => WorkingTimeTicketStatus::class
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function scopeCurrentAuth($q)
    {
        $auth = get_auth_admin();

        if($auth->isSuperadmin())
        {

        }elseif($auth->isManagerSales()) {

            $q->whereHas('admin', fn($query) => $query->whereRelation('team', 'department', Department::Sales)->where('admin_id', '!=', $auth->id));
        }elseif($auth->isManagerMKT()) {

            $q->whereHas('admin', fn($query) => $query->whereRelation('team', 'department', Department::Marketing)->where('admin_id', '!=', $auth->id));
        }elseif($auth->isManagerOutSource()) {

            $q->whereHas('admin', fn($query) => $query->whereRelation('team', 'department', Department::Outsource)->where('admin_id', '!=', $auth->id));
        }else {
            $q->where('admin_id', $auth->id);
        }
    }
}
