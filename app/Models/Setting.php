<?php

namespace App\Models;

use App\Enums\Setting\SettingGroup;
use App\Enums\Setting\SettingTypeInput;
use TCore\Base\Models\BaseModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Setting extends BaseModel
{
    const CACHE_KEY_GET_ALL = 'cache_settings';

    protected $table = 'settings';

    protected $fillable = [
        'setting_key',
        'setting_name',
        'plain_value',
        'desc',
        'type_input',
        'type_data',
        'group'
    ];

    protected $casts = [
        'type_input' => SettingTypeInput::class,
        'group' => SettingGroup::class
    ];

    public function getNameComponent()
    {
        return match($this->type_input){
            SettingTypeInput::Text => 'core_base::input',
            SettingTypeInput::Number => 'core_base::input.number',
            SettingTypeInput::Image => 'core_base::input.image_ckfinder',
            SettingTypeInput::Email => 'core_base::input.email',
            SettingTypeInput::Phone => 'core_base::input.phone',
            SettingTypeInput::Checkbox => 'core_base::inputcheckbox',
            SettingTypeInput::Time => 'core_base::input.time',
            default => 'input'
        };
    }

    public static function getAll()
    {

        return Cache::rememberForever(self::CACHE_KEY_GET_ALL, function () {

            return self::all()->pluck('plain_value', 'setting_key');
        });
    }

    public static function getValue(string $key)
    {
        return self::getAll()->get($key, '');
    }

    public static function updateMultipleRecord(array $data){
        
        Cache::forget(static::CACHE_KEY_GET_ALL);

        $query = "UPDATE settings SET plain_value = CASE setting_key ";

        foreach ($data as $key => $value) {
            $query .= "WHEN '{$key}' THEN '{$value}' ";
        }
        
        $query .= "END WHERE setting_key IN ('".implode("', '", array_keys($data))."')";

        return DB::update($query);
    }
    
}
