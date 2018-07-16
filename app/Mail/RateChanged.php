<?php

namespace App\Mail;

use App\User;
use App\Entity\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RateChanged extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $currency;
    private $newRate;
    private $oldRate;

    /**
     * RateChanged constructor.
     * @param User $user
     * @param Currency $currency
     * @param float $oldRate
     */
    public function __construct(User $user, Currency $currency, float $oldRate)
    {
        $this->user = $user->getAttribute('name');
        $this->currency = $currency->getAttribute('name');
        $this->newRate = $currency->getAttribute('rate');
        $this->oldRate = $oldRate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->with([
                'user'     => $this->user,
                'currency' => $this->currency,
                'new_rate' => $this->newRate,
                'old_rate' => $this->oldRate,
            ]);
    }
}
