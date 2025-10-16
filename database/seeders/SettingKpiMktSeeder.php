<?php

namespace Database\Seeders;

use App\Enums\Setting\SettingGroup;
use App\Enums\Setting\SettingTypeInput;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingKpiMktSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('settings')->where('group', SettingGroup::KpiMkt->value)->delete();
        
        DB::table('settings')->insert([
            [
                'setting_key' => 'mkt_kpi_target_contact',
                'setting_name' => 'Data quan tâm',
                'plain_value' => 10,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::KpiMkt->value,
                'desc' => 'Mục tiêu liên hệ phải đạt được mỗi ngày'
            ]
        ]);
    }
}
