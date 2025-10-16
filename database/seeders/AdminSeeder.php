<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vô hiệu hóa event/observer để tránh lỗi từ AdminObserver (Gender::Male)
        Admin::unsetEventDispatcher();

        // Tạo tài khoản admin
        Admin::create([
            'username'      => 'TTN1',
            'fullname'      => 'TTN Admin',
            'email'         => 'admin1@ttnvietnam.vn',
            'status'        => 1,
            'is_superadmin' => true,
            'password'      => bcrypt('123456'), // Mã hóa password
        ]);
    }
}
