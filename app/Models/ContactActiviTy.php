<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class ContactActiviTy extends BaseModel
{
    use HasFactory;

    protected $table = 'contact_activities';

    protected $fillable = [
        'admin_id',
        'contact_id',
        'date_time',
        'desc'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id')->withDefault();
    }
}
