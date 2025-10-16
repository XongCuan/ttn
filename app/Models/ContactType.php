<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class ContactType extends BaseModel
{
    use HasFactory;

    protected $table = 'contact_types';

    protected $fillable = [
        'admin_id',
        'name',
        'note'
    ];

    public function contact()
    {
        return $this->hasMany(Contact::class, 'type_id', 'id');
    }
}
