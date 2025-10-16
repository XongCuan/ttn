<?php

namespace TCore\WorkingTime\Mail;

use App\Cms\Services\Order\OrderService;
use App\Models\Admin;
use App\Models\Order;
use App\Models\WorkingTimeTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewWorkingTimeTicket extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        protected WorkingTimeTicket $ticket, 
        protected Admin $admin
    )
    {}

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: trans('Đơn bổ sung điểm danh - :fullname', ['fullname' => $this->ticket->admin?->fullname]),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'packages_workingtime::mails.new-workingtime-ticket',
            with: [
                'ticket' => $this->ticket,
                'admin' => $this->admin
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}