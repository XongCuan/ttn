<?php

namespace TCore\Sales\Models;

use App\Enums\Customer\CustomerReturnStatus;
use App\Models\CustomerReturn as ModelsCustomerReturn;
use Illuminate\Database\Eloquent\Builder;

class CustomerReturn extends ModelsCustomerReturn
{
    protected static function booted(): void
    {
        static::addGlobalScope('apply_filter', function(Builder $builder) {
            if(get_auth_admin()->hasManagerShipRoleSales() == false)
            {
                $builder->whereHas('customer', function($q) {
                    $q->where('team_id', auth('admin')->user()->team_id);
                });

                if(get_auth_admin()->isRoleLeader() == false)
                {
                    $builder->where('admin_id', auth('admin')->id());
                }
            }
        });
    }

    public function isMakeOrder()
    {
        return $this->status != CustomerReturnStatus::Completed && $this->status != CustomerReturnStatus::Canceled;
    }
}