<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $response = Http::get('https://api.vietqr.io/v2/banks');

        if ($response->successful()) {

            $responseData = $response->json();

            $banksData = $responseData['data'];

            $banks = collect($banksData)->map(function ($item) {
                return [
                    'name' => $item['name'],
                    'code' => $item['code'],
                    'bin' => $item['bin'],
                    'logo' => $item['logo'],
                ];
            });
            foreach($banks as $bank){
                DB::table('banks')->insert($bank);
            }
        }

    }
}
