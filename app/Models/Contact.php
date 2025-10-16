<?php

namespace App\Models;

use App\Enums\Area;
use App\Enums\Contact\ContactStatus;
use Illuminate\Database\Eloquent\Model;
use TCore\Base\Enums\Department;
use TCore\Base\Enums\Gender;
use TCore\Base\Models\BaseModel;
use TCore\Base\Models\District;
use TCore\Base\Models\Province;
use TCore\Base\Models\Ward;

class Contact extends BaseModel
{
    //
    protected $table = 'contacts';

    protected $fillable = [
        'admin_id', 'team_id', 'type_id', 'source_id', 'range_price_id', 'sector_id', 'department', 'fullname', 'phone', 'email', 'gender', 'province_code', 'district_code', 'ward_code', 'area', 'status', 'avatar', 'address', 'note', 'date_add'
    ];

    protected function casts()
    {
        return [
            'gender' => Gender::class,
            'area' => Area::class,
            'status' => ContactStatus::class,
            'department' => Department::class,
            'date_add' => 'datetime'
        ];
    }

    public function fullAddress()
    {
        $arr = [];

        if($this->address)
        {
            array_push($arr, $this->address);
        }

        if($this->ward->name)
        {
            array_push($arr, $this->ward->name);
        }

        if($this->district->name)
        {
            array_push($arr, $this->district->name);
        }

        if($this->province->name)
        {
            array_push($arr, $this->province->name);
        }

        return implode(', ', $arr);
    }

    public function isMakeOrder()
    {
        return $this->status != ContactStatus::Completed && $this->status != ContactStatus::Fake && $this->status != ContactStatus::Canceled;
    }

    public function cloneToCustomer()
    {
        $data = $this->toArray();

        unset($data['id'], $data['type'], $data['department'], $data['status'], $data['created_at'], $data['updated_at']);
        $data['admin_id'] = auth('admin')->id();
        $data['team_id'] = auth('admin')->user()->team_id;
        $data['is_new'] = true;

        return Customer::create($data);
    }

    public function displayText()
    {
        return $this->fullname . ($this->phone ? ' - ' . $this->phone : '');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id')->withDefault();
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id')->withDefault(['fullname' => null]);
    }

    public function activities()
    {
        return $this->hasMany(ContactActiviTy::class, 'contact_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ContactType::class, 'type_id', 'id')->withDefault();
    }

    public function rangePrice()
    {
        return $this->belongsTo(RangePrice::class, 'range_price_id', 'id')->withDefault();
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id')->withDefault();
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

    public function assigns()
    {
        return $this->belongsToMany(Admin::class, 'assigns_contacts', 'contact_id', 'admin_id');
    }

    public function teamSale()
    {
        return $this->belongsTo(Team::class, 'team_id')->where('department', Department::Sales)->withDefault();
    }

    public function teamMkt()
    {
        return $this->belongsTo(Team::class, 'team_id')->where('department', Department::Marketing)->withDefault();
    }

    public function scopeFollowByEmployee($query)
    {
        $query->where(function($q) {
            $q->where('admin_id', auth('admin')->id())
            ->orWhereRelation('assigns', 'id', auth('admin')->id());
        });
    }

    public function scopeFollowBySales($query)
    {
        if(get_auth_admin()->isRoleEmployee())
        {
            $query->followByEmployee();
        }elseif(get_auth_admin()->isRoleLeader()) {
            $query->where('team_id', get_auth_admin()->team_id);
        }
    }

    public function scopeFollowByMkt($query)
    {
        $query->where('department', Department::Marketing);
        if(get_auth_admin()->isRoleEmployee())
        {
            $query->followByEmployee();
        }elseif(get_auth_admin()->isRoleLeader()) {
            $query->where('team_id', get_auth_admin()->team_id);
        }
    }
}
