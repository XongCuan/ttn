<?php

namespace TCore\WorkingTime\Services;

use App\Models\WorkingTimeTicket;
use TCore\WorkingTime\Enums\WorkingTimeTicketStatus;
use TCore\WorkingTime\Enums\WorkingTimeTicketType;

class WorkingTimeTicketService
{
    public static function isStatusPending(WorkingTimeTicket $ticket)
    {
        return $ticket->status == WorkingTimeTicketStatus::Pending;
    }

    public static function isStatusApproved(WorkingTimeTicket $ticket)
    {
        return $ticket->status == WorkingTimeTicketStatus::Approved;
    }

    public static function isStatusRefuse(WorkingTimeTicket $ticket)
    {
        return $ticket->status == WorkingTimeTicketStatus::Refuse;
    }

    public static function isTypeCheckin(WorkingTimeTicket $ticket)
    {
        return $ticket->type == WorkingTimeTicketType::Checkin;
    }

    public static function isTypeCheckout(WorkingTimeTicket $ticket)
    {
        return $ticket->type == WorkingTimeTicketType::Checkout;
    }

    public static function isTypeFullday(WorkingTimeTicket $ticket)
    {
        return $ticket->type == WorkingTimeTicketType::Fullday;
    }
}