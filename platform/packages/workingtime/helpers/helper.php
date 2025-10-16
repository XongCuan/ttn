<?php

use TCore\WorkingTime\Services\WorkingTimeTicketService;

if(!function_exists('working_time_ticket_service'))
{
    function working_time_ticket_service(): WorkingTimeTicketService
    {
        return app()->make(WorkingTimeTicketService::class);
    }
}