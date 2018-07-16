<?php

namespace App\Http\Controllers;

use Gate;
use Queue;
use App\User;
use App\Entity\Currency;
use Illuminate\Http\Request;
use App\Jobs\SendRateChangedEmail;

class ApiController extends Controller
{
    public function update(Request $request)
    {
        if (Gate::denies('admin')) {
            return redirect('/');
        }
        $currency = Currency::find($request->id);
        $oldRate = $currency->rate;
        $currency->update(['rate' => $request->get('rate')]);
        $this->sendNotification($currency, $oldRate);
        return json_encode($currency);
    }

    private function sendNotification(Currency $currency, float $oldRate) : void
    {
        $users = User::where('is_admin', false)->get();
        foreach ($users as $user) {
            Queue::pushOn('notification', new SendRateChangedEmail($user, $currency, $oldRate));
        }
    }
}
