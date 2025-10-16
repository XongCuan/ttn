<?php

namespace App\Models;

use App\Enums\Customer\CustomerType;
use App\Enums\Order\OrderPriority;
use App\Enums\Order\OrderStatus;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;
use TCore\Sales\Observers\OrderObserver;

#[ObservedBy([OrderObserver::class])]
class Order extends BaseModel
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'team_id',
        'name',
        'sub_total',
        'total',
        'status',
        'customer_type',
        'priority',
        'desc'
    ];

    protected function casts()
    {
        return [
            'status' => OrderStatus::class,
            'total' => 'double',
            'sub_total' => 'double',
            'customer_type' => CustomerType::class,
            'priority' => OrderPriority::class,
        ];
    }

    public function isPriority()
    {
        return $this->priority != OrderPriority::Default;
    }

    public function isCompleted()
    {
        return $this->status == OrderStatus::Completed;
    }

    public function hasAddArise()
    {
        return $this->status != OrderStatus::Completed
            && $this->status != OrderStatus::Cancel;
    }

    public function hasAddService()
    {
        return $this->status != OrderStatus::Paymented
            && $this->status != OrderStatus::Completed
            && $this->status != OrderStatus::Cancel
            && $this->status != OrderStatus::Accepted;
    }

    public function hasAddPayment()
    {
        return $this->status != OrderStatus::Paymented
            && $this->status != OrderStatus::Completed
            && $this->status != OrderStatus::Cancel;
    }

    public function unpaidBalance()
    {
        return $this->total - $this->payments->sum('amount');
    }

    public function canAddService()
    {
        return $this->status == OrderStatus::Unpaid || $this->status == OrderStatus::Deposited;
    }

    public function arises()
    {
        return $this->hasMany(OrderArise::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    public function services()
    {
        return $this->hasMany(OrderService::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault();
    }

    public function teamSale()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id')->withDefault();
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id')->withDefault(['fullname' => null]);
    }

    public function assigns()
    {
        return $this->belongsToMany(Admin::class, 'assigns_orders', 'order_id', 'admin_id');
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

    public function projects()
    {
        return $this->hasMany(Project::class, 'order_id', 'id');
    }

    public function projectRequirement()
    {
        return $this->hasMany(ProjectRequirement::class, 'order_id', 'id');
    }

    public function projectThrough()
    {
        return $this->hasOneThrough(
            Project::class,      // Model cuối cùng (projects)
            ProjectRequirement::class,  // Model trung gian (requirements)
            'order_id',           // Foreign key ở Requirement trỏ tới Order
            'id',                 // Foreign key ở Project (mặc định id)
            'id',                 // Local key ở Order
            'project_id'          // Local key ở Requirement trỏ tới Project
        );
    }

    public function scopeInProgress($q)
    {
        return $q->whereIn('status', [
            OrderStatus::Unpaid,
            OrderStatus::Deposited,
            OrderStatus::Paymented
        ]);
    }
}