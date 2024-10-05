<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $product_name;
    public $quantity;
    public $totalPrice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $product_name, $quantity, $totalPrice)
    {
        $this->name = $name;
        $this->product_name = $product_name;
        $this->quantity = $quantity;
        $this->totalPrice = $totalPrice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Product Booked Successfully')
                    ->view('mail.product_booked')
                    ->with([
                        'user' => $this->name,
                        'product_name' => $this->product_name,
                        'quantity' => $this->quantity,
                        'totalPrice' => $this->totalPrice,
                    ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            // subject: 'Forgot Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.product_booked',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

}
