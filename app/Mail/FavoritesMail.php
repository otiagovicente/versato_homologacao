<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FavoritesMail extends Mailable
{
    

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $products;
    public $representative;
    public $customer;
    
    public function __construct($arrProducts, $objRepresentative, $objCustomer)
    {
        $this->products = $arrProducts;
        $this->representative = $objRepresentative;
        $this->customer = $objCustomer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.favorites')->subject('Favoritos');
    }
}
