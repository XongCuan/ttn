<?php

use App\Enums\Area;
use App\Enums\Contact\ContactStatus;
use App\Enums\Customer\CustomerReturnStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Project\ProjectRequirementStatus;
use App\Enums\Project\ProjectStatus;
use App\Enums\Setting\SettingGroup;

return [
    SettingGroup::class => [
        SettingGroup::General->value => 'Chung',
        SettingGroup::WorkingTime->value => 'Điểm danh',
        SettingGroup::KpiSales->value => 'Kpi sales',
        SettingGroup::KpiMkt->value => 'Kpi marketing'
    ],
    ContactStatus::class => [
        ContactStatus::NotConsulted->value => 'Chưa tư vấn',
        ContactStatus::Consulting->value => 'Đang tư vấn',
        ContactStatus::Deposited->value => 'Đã cọc',
        ContactStatus::Quoted->value => 'Gửi báo giá',
        ContactStatus::Canceled->value => 'Hủy',
        ContactStatus::Fake->value => 'Ảo',
        ContactStatus::Completed->value => 'Hoàn thành'
    ],
    CustomerReturnStatus::class => [
        CustomerReturnStatus::Consulting->value => 'Đang tư vấn',
        CustomerReturnStatus::Deposited->value => 'Đã cọc',
        CustomerReturnStatus::Canceled->value => 'Hủy',
        CustomerReturnStatus::Completed->value => 'Hoàn thành'
    ],

    Area::class => [
        Area::North->value => 'Bắc',
        Area::Central->value => 'Trung',
        Area::South->value => 'Nam'
    ],

    OrderStatus::class => [
        OrderStatus::Unpaid->value => 'Chưa thanh toán',
        OrderStatus::Paymented->value => 'Đã thanh toán',
        OrderStatus::Deposited->value => 'Đã chuyển cọc',
        OrderStatus::Cancel->value => 'Đã hủy',
        OrderStatus::Completed->value => 'Đã hoàn thành',
        OrderStatus::UnderAcceptance->value => 'Đang nghiệm thu',
        OrderStatus::DelayAcceptance->value => 'Trì hoãn nghiệm thu',
        OrderStatus::Accepted->value => 'Đã nghiệm thu'
    ],

    ProjectStatus::class => [
        ProjectStatus::Todo->value => 'Cần làm',
        ProjectStatus::Doing->value => 'Đang triển khai',
        ProjectStatus::Demo->value => 'Demo',
        ProjectStatus::Done->value => 'Hoàn thành',
        ProjectStatus::Paused->value => 'Tạm dừng',
        ProjectStatus::Cancel->value => 'Đã hủy',
    ],

    ProjectRequirementStatus::class => [
        ProjectRequirementStatus::Todo->value => 'Cần làm',
        ProjectRequirementStatus::Doing->value => 'Đang triển khai',
        ProjectRequirementStatus::Done->value => 'Hoàn thành',
        ProjectRequirementStatus::Finish->value => 'Kết thúc',
        ProjectRequirementStatus::Paused->value => 'Tạm dừng',
        ProjectRequirementStatus::Cancel->value => 'Đã hủy',
    ],
];