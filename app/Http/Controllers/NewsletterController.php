<?php

namespace App\Http\Controllers;

use App\Jobs\NewsletterJob;
use App\Mail\SendNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class NewsletterController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::newslettersapi()->get('index');

        return response($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newsletter = [
            'grade_ids' => json_encode($request->grades),
            'title' => $request->title,
            'body' => $request->body
        ];

        //Save the newsletter to the database
        $response = Http::newslettersapi()->post('store', $newsletter);
        
        //Dispatch the newsletters job
        dispatch(new NewsletterJob(json_encode($request->grades), $newsletter));

        //Return a response to the users
        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Http::newslettersapi()->get('show/' . $id);

        return response($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = Http::newslettersapi()->patch('update/' . $id, $request->all());

        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Http::newslettersapi()->delete('destroy/' . $id);

        return response($response);
    }
}
