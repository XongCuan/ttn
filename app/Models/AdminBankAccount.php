<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCore\Base\Enums\Department;

class AdminBankAccount extends Model
{
    //
    protected $table = 'admin_bank_accounts';

    protected $fillable = [
        'admin_id', 'bank_name', 'account_number', 'account_holder'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
