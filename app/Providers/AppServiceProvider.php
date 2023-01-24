<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /**
         * Macros for common request paths for the http client
         */

        //ContactsAPI
        Http::macro('contactsapi', function () {
            return Http::withHeaders([
                'Accept' => 'application/json',
            ])->baseUrl('http://localhost:8001/api/contacts');
        });

        //GradesAPI
        Http::macro('gradesapi', function () {
            return Http::withHeaders([
                'Accept' => 'application/json',
            ])->baseUrl('http://localhost:8002/api');
        });

        //LearnerInfoAPI
        Http::macro('learnerinfoapi', function () {
            return Http::withHeaders([
                'Accept' => 'application/json',
            ])->baseUrl('http://localhost:8003/api/learners');
        });

        //NewslettersAPI
        Http::macro('newslettersapi', function () {
            return Http::withHeaders([
                'Accept' => 'application/json',
                ])->baseUrl('http://localhost:8004/api/newsletters');
        });

        //SchoolsAPI
        Http::macro('schoolsapi', function () {
            return Http::withHeaders([
                'Accept' => 'application/json',
                ])->baseUrl('http://localhost:8005/api/schools');
        });
    }
}
