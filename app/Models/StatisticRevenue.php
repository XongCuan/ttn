<?php

namespace App\Models;

use App\Enums\Customer\CustomerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class StatisticRevenue extends BaseModel
{
    use HasFactory;

    protected $table = 'statistic_revenue';

    protected $fillable = [
        'source_id',
        'statistic_date',
        'amount',
        'customer_type',
    ];

    protected function casts()
    {
        return [
            'statistic_date' => 'date',
            'amount' => 'double',
            'customer_type' => CustomerType::class
        ];
    }

    public static function addRevenueFromOrder(Order $order, $amount)
    {
        $statisticRevenue = StatisticRevenue::firstOrCreate(
            [
                'statistic_date' => now()->format('Y-m-d'), 
                'customer_type' => $order->customer->typeStatistic(),
                'source_id' => $order->customer->source_id ?? Source::select('id')->where('is_default', true)->first()->id,
            ]
        );
        
        $statisticRevenue->amount += $amount;
        $statisticRevenue->save();
    }

    public function source()
    {
        return $this->belongsTo(Source::class)->withDefault();
    }
}
