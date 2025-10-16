<?php

namespace Database\Seeders;

use App\Enums\Setting\SettingGroup;
use App\Enums\Setting\SettingTypeInput;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingWorkingTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('settings')->where('group', SettingGroup::WorkingTime->value)->delete();
        
        DB::table('settings')->insert([
            [
                'setting_key' => 'start_working_time',
                'setting_name' => 'Giờ checkin',
                'plain_value' => '08:30',
                'type_input' => SettingTypeInput::Time->value,
                'group' => SettingGroup::WorkingTime->value,
                'desc' => 'Thời gian checkin vào công ty.'
            ],
            [
                'setting_key' => 'end_working_time',
                'setting_name' => 'Giờ checkout',
                'plain_value' => '18:00',
                'type_input' => SettingTypeInput::Time->value,
                'group' => SettingGroup::WorkingTime->value,
                'desc' => 'Thời gian checkout công ty.'
            ],
            [
                'setting_key' => 'almost_ontime_working_time',
                'setting_name' => 'Giờ checkin flex',
                'plain_value' => '08:35',
                'type_input' => SettingTypeInput::Time->value,
                'group' => SettingGroup::WorkingTime->value,
                'desc' => 'Thời gian checkin flex.'
            ],
            [
                'setting_key' => 'allow_radius_checkin_checkout',
                'setting_name' => 'Bán kính điểm danh (Mét)',
                'plain_value' => 500,
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::WorkingTime->value,
                'desc' => 'Bán kính để điểm danh thường thì nên cho an toàn từ 30 trở lên.'
            ],
            [
                'setting_key' => 'location_latitude',
                'setting_name' => 'Vĩ độ điểm danh',
                'plain_value' => '10.8057637',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::WorkingTime->value,
                'desc' => 'Là vĩ độ của công ty hoặc lấy trung tâm nơi làm việc.'
            ],
            [
                'setting_key' => 'location_longitude',
                'setting_name' => 'Kinh độ điểm danh',
                'plain_value' => '106.7174988',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::WorkingTime->value,
                'desc' => 'Là kinh độ của công ty hoặc lấy trung tâm nơi làm việc.'
            ],
            
        ]);
    }
}
