<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestaurantCallbackMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order, $email_subject, $_email_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $email_subject, $_email_content)
    {
        $this->order = $order;
        $this->email_subject = $email_subject;
        $this->_email_content = $_email_content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->email_subject)
            ->view('emails.restaurant_callback', [
                'order' => $this->order,
                'email_subject' => $this->email_subject,
                '_email_content' => $this->_email_content,
            ]);
    }
}
