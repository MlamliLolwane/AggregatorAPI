<?php

namespace App\Http\Controllers\Aggregates;

use App\Http\Controllers\Controller;
use App\Notifications\SendNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class CreateNewsletter extends Controller
{
    public function createAndSendNewsletter(Request $request)
    {
        //Save the newsletter to the database and get contacts they are supposed to be sent to.
        //$response = Http::newslettersapi()->post('store', $request->all());

        $response = Http::contactsapi()->get('index');

        Notification::route('mail', $response['data'][0]['email'])->notify(new SendNewsletter());
        // return response($response['data']);

        //return response($response);
    }
}
