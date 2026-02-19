<?php

namespace Modules\Customer\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Customer\Models\Customer;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Customer $customer)
    {
    }

    public function build()
    {
        return $this->markdown('customer::mails.welcome', [
            'customer' => $this->customer,
        ])->subject("Welcome to UP");
    }
}
