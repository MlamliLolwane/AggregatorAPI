<?php

namespace App\Http\Controllers\Aggregates;

use App\Http\Controllers\Controller;
use App\Notifications\SendNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class CreateNewsletter extends Controller
{
    // public function createAndSendNewsletter(Request $request)
    // {
    //     //Save the newsletter to the database and get contacts they are supposed to be sent to.
    //     //$response = Http::newslettersapi()->post('store', $request->all());

    //     $response = Http::contactsapi()->get('index');

    //     Notification::route('mail', $response['data'][0]['email'])->notify(new SendNewsletter());
    //     // return response($response['data']);

    //     //return response($response);
    // }
    public function sendWhatsappNewsletter()
    {
        try {
            $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v17.0/111812128521680/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"messaging_product\": \"whatsapp\", \"to\": \"27691238001\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }");

        $headers = array();
        $headers[] = 'Authorization: Bearer EAAHa2mk8dcMBAFr1aXkWDwiAsrLzju5r0IKoPGoNep5Q9G82Dp9BFBqglFeMUxrZB8SMpEOz8nqyCJQTQt0JT9XEYAVdGuXukTaZBbjopxnUbopfpmyAZAjZA61F2aA4HvSd7F9qEiZA3dEMPXNK58CmOT8LelzYbAEpHbjBZCIgf4BagEFdFJn6TjPMQd1RUmNXIcLR2GuZCfYz8d0ahGZBpCYvsV2ngksZD';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
