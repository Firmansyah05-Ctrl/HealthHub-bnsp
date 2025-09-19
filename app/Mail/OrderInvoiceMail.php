<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $pdf)
    {
        $this->order = $order;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Invoice Pesanan #' . $this->order->id)
                    ->view('emails.order_invoice')
                    ->attachData($this->pdf->output(), 'invoice-'.$this->order->id.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
