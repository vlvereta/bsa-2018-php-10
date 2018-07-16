<?php

namespace App\Http\Controllers;

use Gate;
use App\Mail\RateChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    public function update(Request $request)
    {
        if (Gate::denies('admin')) {
            return redirect('/');
        }
        $currency = \App\Entity\Currency::find($request->id);
        $oldRate = $currency->rate;
        $currency->update(['rate' => $request->get('rate')]);
        $users = \App\User::where('is_admin', false)->get();
        foreach ($users as $user) {
            $message = new RateChanged($user, $currency, $oldRate);
            Mail::to($user)->send($message->build());
        }
        return json_encode($currency);
    }
}
