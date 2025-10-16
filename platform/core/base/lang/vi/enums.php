<?php

return [
    TCore\Base\Enums\DefaultStatus::class => [
        TCore\Base\Enums\DefaultStatus::Published->value => 'Đã xuất bản',
        TCore\Base\Enums\DefaultStatus::Draft->value => 'Bản nháp'
    ],
    TCore\Base\Enums\Gender::class => [
        TCore\Base\Enums\Gender::EU->value => 'Nhà Máy',
        TCore\Base\Enums\Gender::TM->value => 'Thương Mại',
        TCore\Base\Enums\Gender::CN->value => 'Cá Nhân'
    ],

    TCore\Base\Enums\WorkingTimeStatus::class => [
        TCore\Base\Enums\WorkingTimeStatus::OnTime->value => 'Đúng giờ',
        TCore\Base\Enums\WorkingTimeStatus::AlmostOnTime->value => 'Gần đúng giờ',
        TCore\Base\Enums\WorkingTimeStatus::Late->value => 'Trễ giờ'
    ],

    TCore\Base\Enums\LeaveRequest\LeaveRequestStatus::class => [
        TCore\Base\Enums\LeaveRequest\LeaveRequestStatus::Approved->value => 'Đã duyệt',
        TCore\Base\Enums\LeaveRequest\LeaveRequestStatus::Pending->value => 'Chờ duyệt',
        TCore\Base\Enums\LeaveRequest\LeaveRequestStatus::Refused->value => 'Từ chối'
    ],
    TCore\Base\Enums\LeaveRequest\LeaveRequestType::class => [
        TCore\Base\Enums\LeaveRequest\LeaveRequestType::UnpaidLeave->value => 'Không lương',
        TCore\Base\Enums\LeaveRequest\LeaveRequestType::AnnualLeave->value => 'Phép năm',
        TCore\Base\Enums\LeaveRequest\LeaveRequestType::SpecialLeave->value => 'Trường hợp đặc biệt',
        TCore\Base\Enums\LeaveRequest\LeaveRequestType::Remote->value => 'Remote'
    ],
    TCore\Base\Enums\LeaveRequest\HalfDayType::class => [
        TCore\Base\Enums\LeaveRequest\HalfDayType::Morning->value => 'Buổi sáng',
        TCore\Base\Enums\LeaveRequest\HalfDayType::Afternoon->value => 'Buổi chiều',
    ],
    TCore\Base\Enums\SuperDepartment::class => [
        TCore\Base\Enums\SuperDepartment::None->value => 'Không có',
        TCore\Base\Enums\SuperDepartment::Operation->value => 'Điều hành',
        TCore\Base\Enums\SuperDepartment::BussinessDevelopment->value => 'PT kinh doanh',
        TCore\Base\Enums\SuperDepartment::ProductDevelopment->value => 'PT Sản phẩm'
    ]
];
