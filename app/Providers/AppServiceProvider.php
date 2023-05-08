<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
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
