<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use TCore\Base\Models\BaseModel;

class NotificationContent extends BaseModel
{
    //
    protected $table = 'notification_contents';

    protected $fillable = [
        'created_by', 'title', 'content', 'is_all', 'target_deparments', 'target_admin_ids'
    ];

    protected function casts()
    {
        return [
            'target_deparments' => AsArrayObject::class,
            'target_admin_ids' => AsArrayObject::class,
        ];
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by')->withDefault();
    }
}
