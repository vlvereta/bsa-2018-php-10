<?php

namespace App\Jobs;

use App\User;
use App\Entity\Currency;
use App\Mail\RateChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendRateChangedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $currency;
    public $oldRate;

    /**
     * SendRateChangedEmail constructor.
     * @param User $user
     * @param Currency $currency
     * @param float $oldRate
     */
    public function __construct(User $user, Currency $currency, float $oldRate)
    {
        $this->user = $user;
        $this->currency = $currency;
        $this->oldRate = $oldRate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : void
    {
        $message = new RateChanged($this->user, $this->currency, $this->oldRate);
        Mail::to($this->user)->send($message->build());
    }
}
