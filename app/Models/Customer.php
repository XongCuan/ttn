<?php

namespace App\Models;

use App\Enums\Area;
use App\Enums\Customer\CustomerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Enums\Gender;
use TCore\Base\Models\BaseModel;
use TCore\Base\Models\District;
use TCore\Base\Models\Province;
use TCore\Base\Models\Ward;

class Customer extends BaseModel
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'invite_id',
        'admin_id',
        'team_id',
        'source_id',
        'range_price_id',
        'sector_id',
        'fullname',
        'company',       
        'short_name',    
        'tax_code',      
        'customer_type', 
        'phone',
        'email',
        'gender',
        'province_code',
        'district_code',
        'ward_code',
        'area',
        'status',
        'avatar',
        'address',
        'note',
        'is_new'
    ];

    protected function casts()
    {
        return [
            'gender' => Gender::class,
            'area' => Area::class,
        ];
    }

    public function displayText()
    {
        return $this->fullname . ($this->phone ? ' - ' . $this->phone : '');
    }

    public function fullAddress()
    {
        $arr = [];

        if ($this->address) {
            $arr[] = $this->address;
        }

        if ($this->ward->name) {
            $arr[] = $this->ward->name;
        }

        if ($this->district->name) {
            $arr[] = $this->district->name;
        }

        if ($this->province->name) {
            $arr[] = $this->province->name;
        }

        return implode(', ', $arr);
    }

    public function enumCustomerType()
    {
        return $this->isNew() ? CustomerType::New : CustomerType::Old;
    }

    public function isNew()
    {
        return $this->is_new == true;
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function teamSale()
    {
        return $this->belongsTo(Team::class, 'team_id')->withDefault();
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'admin_id')->withDefault(['fullname' => null]);
    }

    public function inviter()
    {
        return $this->belongsTo(Customer::class, 'invite_id')->withDefault();
    }

    public function assigns()
    {
        return $this->belongsToMany(Admin::class, 'assigns_customers', 'customer_id', 'admin_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id')->withDefault();
    }

    public function rangePrice()
    {
        return $this->belongsTo(RangePrice::class, 'range_price_id')->withDefault();
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id')->withDefault();
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code')->withDefault();
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code')->withDefault();
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code')->withDefault();
    }

    public function customerReturns()
    {
        return $this->hasMany(CustomerReturn::class, 'customer_id', 'id');
    }

    public function scopeFollowByEmployee($query)
    {
        $query->where(function ($q) {
            $q->where('admin_id', auth('admin')->id())
              ->orWhereRelation('assigns', 'id', auth('admin')->id());
        });
    }

    public function scopeFollowBySales($query)
    {
        if (get_auth_admin()->isRoleEmployee()) {
            $query->followByEmployee();
        } elseif (get_auth_admin()->isRoleLeader()) {
            $query->where('team_id', get_auth_admin()->team_id);
        }
    }
}
