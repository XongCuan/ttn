<?php

use App\Enums\Setting\SettingGroup;
use TCore\Base\Enums\Department;

return [
    //example
    // [
    //     'title' => 'Example',
    //     'route_name' => 'dashboard.index',
    //     'params' => ['s' => 'hello'],
    //     'icon' => '<i class="ti ti-home"></i>',
    //     'sub' => [],
    //     'visiable' => [
    //         'is_superadmin' => true, // Nếu = true bỏ qua mọi tham số khác
    //         'department' => Department::Accountant,
    //         'is_manager' => false,
    //         'is_leader' => false
    //     ]
    // ],



    // [
    //     'title' => 'Bảng điều khiển',
    //     'route_name' => 'dashboard.index',
    //     'icon' => '<i class="ti ti-home"></i>'
    // ],


    // [
    //     'title' => 'Chấm công',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-clock"></i>',
    //     'visiable' => [
    //         'is_superadmin' => false
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Dashboard',
    //             'route_name' => 'working_time.dashboard',
    //             'icon' => '<i class="ti ti-dashboard"></i>',
    //             'visiable' => [
    //                 'is_manager' => true
    //             ],
    //         ],
    //         [
    //             'title' => 'Điểm danh',
    //             'route_name' => 'working_time.index',
    //             'icon' => '<i class="ti ti-clock"></i>'
    //         ],
    //         [
    //             'title' => 'Bổ sung điểm danh',
    //             'route_name' => 'workingtime_ticket.index',
    //             'icon' => '<i class="ti ti-clock-plus"></i>'
    //         ],
    //         [
    //             'title' => 'OT',
    //             'route_name' => 'working_overtime.index',
    //             'icon' => '<i class="ti ti-adjustments"></i>'
    //         ],
    //         [
    //             'title' => 'Type OT',
    //             'route_name' => 'type_overtime.index',
    //             'icon' => '<i class="ti ti-list-numbers"></i>',
    //             'visiable' => [
    //                 'is_manager' => true,
    //                 'is_leader' => true,
    //             ]
    //         ],
    //     ],
    // ],

    // [
    //     'title' => 'Nghỉ phép',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-calendar-week"></i>',
    //     'visiable' => [
    //         'is_superadmin' => false
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Danh sách',
    //             'route_name' => 'leave_request.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ],
    // ],

    // [
    //     'title' => 'Thông báo',
    //     'route_name' => 'notification.notification_content.index',
    //     'icon' => '<i class="ti ti-bell"></i>',
    //     'visiable' => [
    //         'is_superadmin' => false,
    //         'is_manager' => true
    //     ]
    // ],


    //sales

    [
        'title' => 'THIẾT BỊ ĐIỆN TTN',
        'is_header' => true,
        'visiable' => [
            'department' => Department::Sales
        ],
    ],
    [
        'title' => 'Yêu cầu báo giá',
        'route_name' => 'sales.enq.index',
        'icon' => '<i class="ti ti-users-group"></i>',
        'visiable' => [
            'department' => Department::Sales
        ]

    ],
    [
        'title' => 'Đơn đặt hàng',
        'route_name' => '',
        'icon' => '<i class="ti ti-businessplan"></i>',
        'visiable' => [
            'department' => Department::Sales
        ],
        'sub' => [
            [
                'title' => 'Tạo yêu cầu',
                'route_name' => 'sales.order.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'visiable' => [
                    'is_manager' => true,
                    'is_leader' => true,
                ]
            ],
            [
                'title' => 'Danh sách',
                'route_name' => 'sales.order.index',
                'icon' => '<i class="ti ti-list"></i>'
            ],
        ]
    ],


    [
        'title' => 'Khách hàng',
        'route_name' => 'sales.customer.index',
        'icon' => '<i class="ti ti-users-group"></i>',
        'visiable' => [
            'department' => Department::Sales
        ]

    ],

    // [
    //     'title' => 'Liên hệ',
    //     'route_name' => 'sales.contact.index',
    //     'icon' => '<i class="ti ti-address-book"></i>',
    //     'visiable' => [
    //         'department' => Department::Sales
    //     ],
    // ],

    // [
    //     'title' => 'Phân loại KH/LH',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-grid-dots"></i>',
    //     'visiable' => [
    //         'department' => Department::Sales,
    //         'is_leader' => true,
    //         'is_manager' => true
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Nguồn',
    //             'route_name' => 'sales.source.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Loại',
    //             'route_name' => 'sales.contact_type.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Tầm giá',
    //             'route_name' => 'sales.range_price.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Lĩnh vực',
    //             'route_name' => 'sales.sector.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ]
    // ],

    [
        'title' => 'Thống kê',
        'route_name' => 'sales.statistic.index',
        'icon' => '<i class="ti ti-chart-bar-popular"></i>',
        'visiable' => [
            'department' => Department::Sales,
            'is_manager' => true
        ]
    ],

    // [
    //     'title' => 'Quản lý nhân viên',
    //     'route_name' => 'sales.employee.index',
    //     'icon' => '<i class="ti ti-user"></i>',
    //     'visiable' => [
    //         'department' => Department::Sales,
    //         'is_manager' => true
    //     ],
    // ],

    // [
    //     'title' => 'Cài đặt',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-settings"></i>',
    //     'visiable' => [
    //         'department' => Department::Sales,
    //         'is_manager' => true
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'KPI',
    //             'route_name' => 'sales.setting.kpi',
    //             'icon' => '<i class="ti ti-golf"></i>'
    //         ],
    //     ]
    // ],
    // [
    //     'title' => 'Duyệt nghỉ phép',
    //     'route_name' => 'sales.leave_request.index',
    //     'icon' => '<i class="ti ti-calendar-week"></i>',
    //      'visiable' => [
    //         'department' => Department::Sales,
    //         'is_manager' => true
    //     ],
    //     'sub' => [
    //     ],
    // ],

    // // marketing
    // [
    //     'title' => 'Marketing',
    //     'is_header' => true,
    //     'visiable' => [
    //         'department' => Department::Marketing
    //     ],
    // ],

    // [
    //     'title' => 'Liên hệ',
    //     'route_name' => 'marketing.contact.index',
    //     'icon' => '<i class="ti ti-address-book"></i>',
    //     'visiable' => [
    //         'department' => Department::Marketing
    //     ],
    // ],

    // [
    //     'title' => 'Phân loại KH/LH',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-grid-dots"></i>',
    //     'visiable' => [
    //         'department' => Department::Marketing,
    //         'is_leader' => true,
    //         'is_manager' => true
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Nguồn',
    //             'route_name' => 'marketing.source.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Loại',
    //             'route_name' => 'marketing.contact_type.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Tầm giá',
    //             'route_name' => 'marketing.range_price.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Lĩnh vực',
    //             'route_name' => 'marketing.sector.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ]
    // ],

    // [
    //     'title' => 'Thống kê',
    //     'route_name' => 'marketing.statistic.index',
    //     'icon' => '<i class="ti ti-chart-bar-popular"></i>',
    //     'visiable' => [
    //         'department' => Department::Marketing,
    //         'is_manager' => true
    //     ]
    // ],

    // [
    //     'title' => 'Quản lý nhân viên',
    //     'route_name' => 'marketing.employee.index',
    //     'icon' => '<i class="ti ti-user"></i>',
    //     'visiable' => [
    //         'department' => Department::Marketing,
    //         'is_manager' => true
    //     ],
    // ],

    // [
    //     'title' => 'Cài đặt',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-settings"></i>',
    //     'visiable' => [
    //         'department' => Department::Marketing,
    //         'is_manager' => true
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'KPI',
    //             'route_name' => 'marketing.setting.kpi',
    //             'icon' => '<i class="ti ti-golf"></i>'
    //         ],
    //     ]
    // ],

    // [
    //     'title' => 'Duyệt nghỉ phép',
    //     'route_name' => 'marketing.leave_request.index',
    //     'icon' => '<i class="ti ti-calendar-week"></i>',
    //      'visiable' => [
    //         'department' => Department::Marketing,
    //         'is_manager' => true,
    //     ],
    //     'sub' => [
    //     ],
    // ],

    // // internal
    // [
    //     'title' => 'Internal',
    //     'is_header' => true,
    //     'visiable' => [
    //         'department' => Department::Internal
    //     ],
    // ],

    // [
    //     'title' => 'Dự án',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-components"></i>',
    //     'visiable' => [
    //         'department' => Department::Internal
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Thêm',
    //             'route_name' => 'internal.project.create',
    //             'icon' => '<i class="ti ti-plus"></i>',
    //             'visiable' => [
    //                 'is_manager' => true,
    //                 'is_leader' => true,
    //             ]
    //         ],
    //         [
    //             'title' => 'Danh sách',
    //             'route_name' => 'internal.project.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ],


    // ],

    // [
    //     'title' => 'Duyệt nghỉ phép',
    //     'route_name' => 'internal.leave_request.index',
    //     'icon' => '<i class="ti ti-calendar-week"></i>',
    //      'visiable' => [
    //         'department' => Department::Internal,
    //         'is_manager' => true,
    //     ],
    //     'sub' => [
    //     ],
    // ],

    // [
    //     'title' => 'Quản lý nhân viên',
    //     'route_name' => 'internal.employee.index',
    //     'icon' => '<i class="ti ti-user"></i>',
    //     'visiable' => [
    //         'department' => Department::Internal,
    //         'is_manager' => true
    //     ],
    // ],

    // // outsource
    // [
    //     'title' => 'Outsource',
    //     'is_header' => true,
    //     'visiable' => [
    //         'department' => Department::Outsource
    //     ],
    // ],

    // [
    //     'title' => 'Dashboard',
    //     'route_name' => 'outsource.dashboard.index',
    //     'icon' => '<i class="ti ti-dashboard"></i>',
    //     'visiable' => [
    //         'department' => Department::Outsource,
    //         'is_manager' => true
    //     ]
    // ],

    // [
    //     'title' => 'Dự án',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-components"></i>',
    //     'visiable' => [
    //         'department' => Department::Outsource
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Thêm',
    //             'route_name' => 'outsource.project.create',
    //             'icon' => '<i class="ti ti-plus"></i>',
    //             'visiable' => [
    //                 'is_manager' => true,
    //                 'is_leader' => true,
    //             ]
    //         ],
    //         [
    //             'title' => 'Danh sách',
    //             'route_name' => 'outsource.project.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ]
    // ],

    // [
    //     'title' => 'Quản lý nhân viên',
    //     'route_name' => 'outsource.employee.index',
    //     'icon' => '<i class="ti ti-user"></i>',
    //     'visiable' => [
    //         'department' => Department::Outsource,
    //         'is_manager' => true
    //     ]
    // ],

    // [
    //     'title' => 'Duyệt nghỉ phép',
    //     'route_name' => 'outsource.leave_request.index',
    //     'icon' => '<i class="ti ti-calendar-week"></i>',
    //      'visiable' => [
    //         'department' => Department::Outsource,
    //         'is_manager' => true,
    //         'is_leader' => true,
    //     ],
    //     'sub' => [
    //     ],
    // ],

    // // webadmin
    // // [
    // //     'title' => 'Webadmin',
    // //     'is_header' => true,
    // //     'visiable' => [
    // //         'department' => Department::Webadmin
    // //     ],
    // // ],

    // [
    //     'title' => 'Yêu cầu dự án',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-components"></i>',
    //     'visiable' => [
    //         'department' => Department::Webadmin
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Thêm',
    //             'route_name' => 'webadmin.project_requirement.create',
    //             'icon' => '<i class="ti ti-plus"></i>',
    //             'visiable' => [
    //                 'is_manager' => true,
    //                 'is_leader' => true
    //             ]
    //         ],
    //         [
    //             'title' => 'Danh sách',
    //             'route_name' => 'webadmin.project_requirement.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ]
    // ],

    // accounting

    // [
    //     'title' => 'Kế toán',
    //     'is_header' => true,
    //     'visiable' => [
    //         'department' => Department::Accounting
    //     ],
    // ],

    [
        'title' => 'Biên lai / chứng từ',
        'route_name' => '',
        'icon' => '<i class="ti ti-receipt-dollar"></i>',
        'visiable' => [
            'department' => Department::Accounting,
            'is_manager' => true
        ],
        'sub' => [
            [
                'title' => 'Danh sách',
                'route_name' => 'accounting.receipt.index',
                'icon' => '<i class="ti ti-list"></i>'
            ],
            [
                'title' => 'Loại',
                'route_name' => 'accounting.receipt_type.index',
                'icon' => '<i class="ti ti-list"></i>'
            ],
        ]
    ],

    //superadmnin

    // [
    //     'title' => 'Superadmin',
    //     'is_header' => true,
    //     'visiable' => [
    //         'is_superadmin' => true
    //     ],
    // ],

    // [
    //     'title' => 'Quản lý nhân sự',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-user"></i>',
    //     'visiable' => [
    //         'is_superadmin' => true
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Thêm',
    //             'route_name' => 'superadmin.admin.create',
    //             'icon' => '<i class="ti ti-plus"></i>'
    //         ],
    //         [
    //             'title' => 'Danh sách',
    //             'route_name' => 'superadmin.admin.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Team',
    //             'route_name' => 'superadmin.team.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ],
    // ],

    // [
    //     'title' => 'Tài liệu',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-file-type-doc"></i>',
    //     'visiable' => [
    //         'is_superadmin' => true
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Danh sách',
    //             'route_name' => 'superadmin.document.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //         [
    //             'title' => 'Loại',
    //             'route_name' => 'superadmin.document_type.index',
    //             'icon' => '<i class="ti ti-list"></i>'
    //         ],
    //     ]
    // ],
    [
        'title' => 'Tài Liệu Kỹ Thuật',
        'route_name' => 'superadmin.ckfinder',
        'icon' => '<i class="ti ti-file-type-doc"></i>',
        'visiable' => [
            'is_superadmin' => true
        ],
        'sub' => []
    ],

    // [
    //     'title' => 'Settings',
    //     'route_name' => '',
    //     'icon' => '<i class="ti ti-settings"></i>',
    //     'visiable' => [
    //         'is_superadmin' => true
    //     ],
    //     'sub' => [
    //         [
    //             'title' => 'Điểm danh',
    //             'route_name' => 'superadmin.setting.working_time',
    //             'icon' => '<i class="ti ti-clock"></i>'
    //         ],
    //     ]
    // ],
];
