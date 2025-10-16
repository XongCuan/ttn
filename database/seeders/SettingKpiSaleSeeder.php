<?php

namespace Database\Seeders;

use App\Enums\Setting\SettingGroup;
use App\Enums\Setting\SettingTypeInput;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingKpiSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('settings')->where('group', SettingGroup::KpiSales->value)->delete();
        
        DB::table('settings')->insert([
            [
                'setting_key' => 'kpi_target_revenue',
                'setting_name' => 'Doanh thu KH mới',
                'plain_value' => 10000000,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::KpiSales->value,
                'desc' => 'Mục tiêu doanh thu phải đạt được mỗi ngày'
            ],
            [
                'setting_key' => 'kpi_target_revenue_old',
                'setting_name' => 'Doanh thu từ KH cũ',
                'plain_value' => 10000000,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::KpiSales->value,
                'desc' => 'Mục tiêu doanh thu từ khách hàng cũ phải đạt được mỗi ngày'
            ],
            [
                'setting_key' => 'kpi_target_contact_success',
                'setting_name' => 'Tỉ lệ chuyển đổi từ KH mới (%)',
                'plain_value' => 5,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::KpiSales->value,
                'desc' => 'Mục tiêu chuyển đổi phải đạt được mỗi ngày'
            ],
            [
                'setting_key' => 'kpi_target_contact_success_old',
                'setting_name' => 'Tỉ lệ chuyển đổi từ KH cũ (%)',
                'plain_value' => 5,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::KpiSales->value,
                'desc' => 'Mục tiêu chuyển đổi từ khách hàng cũ phải đạt được mỗi ngày'
            ],
        ]);
    }
}
