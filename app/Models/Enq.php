<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Area;
use App\Enums\Customer\CustomerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Enums\Gender;
use TCore\Base\Enums\Status;
use TCore\Base\Models\BaseModel;
use TCore\Base\Models\District;
use TCore\Base\Models\Province;
use TCore\Base\Models\Ward;

class Enq extends BaseModel
{
    use HasFactory;

    protected $table = 'enq';

    protected $fillable = [
        'enq_code',
        'customer_id',
        'brand_id',
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
            'status' => Status::class,
        ];
    }
    public static function generateEnqCode()
    {
        $prefix = 'ENQ_' . date('Ym'); // ENQ_202510

        // Lấy mã cuối cùng trong tháng này
        $lastEnq = self::where('enq_code', 'LIKE', $prefix . '%')
            ->orderBy('enq_code', 'desc')
            ->first();

        if ($lastEnq) {
            // Tách số thứ tự từ mã cuối
            $lastNumber = (int) str_replace($prefix . '_', '', $lastEnq->enq_code);
            $newNumber = $lastNumber + 1;
        } else {
            // Tháng mới, bắt đầu từ 1
            $newNumber = 1;
        }

        return $prefix . '_' . $newNumber;
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
    public function details()
    {
        return $this->hasMany(EnqDetail::class);
    }
}
