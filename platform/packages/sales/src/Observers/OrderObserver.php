<?php

namespace TCore\Sales\Observers;

use App\Enums\Project\ProjectRequirementStatus;
use App\Enums\Project\ProjectStatus;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
        if($order->wasChanged('status') && $order->isCompleted())
        {
            $order->projects()->update([
                'status' => ProjectStatus::Done
            ]);

            $order->projectRequirement()->update([
                'status' => ProjectRequirementStatus::Finish
            ]);

            $order->projectThrough()->update([
                'status' => ProjectStatus::Done
            ]);
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
