<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $p = Http::get('https://provinces.open-api.vn/api/p/')->collect()->map(function($item){
            unset($item['districts']);
            $item['codename'] = str()->of($item['codename'])->replace('_', '-');
            return $item;
        })->chunk(50)->toArray();

        DB::table('provinces')->delete();

        foreach($p as $item){
            DB::table('provinces')->insert($item);
        }

        $d = Http::get('https://provinces.open-api.vn/api/d/')->collect()->map(function($item){
            unset($item['wards']);
            return $item;
        })->chunk(50)->toArray();

        DB::table('districts')->delete();

        foreach($d as $item){
            DB::table('districts')->insert($item);
        }

        $p = Http::get('https://provinces.open-api.vn/api/w/')->collect()->chunk(100)->toArray();

        DB::table('wards')->delete();

        foreach($p as $item){
            DB::table('wards')->insert($item);
        }
    }
}
