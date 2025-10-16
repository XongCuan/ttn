<?php

namespace TCore\Sales\Repositories\Order;

use App\Models\Order;
use TCore\Support\Repositories\Eloquent\RepositoryAbstract;

class OrderRepository extends RepositoryAbstract implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }
}