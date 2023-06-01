<?php

namespace App\Jobs;

use App\Mail\SendNewsletter;
use App\Notifications\SendNewsletter as NotificationsSendNewsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $grades;
    protected $newsletter;
    public $tries = 3;
    /**
     * Create a new job instance.
     */
    public function __construct($grades, $newsletter)
    {
        $this->grades = $grades;
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //Get learner ids from grade_learners which contain the grade_ids
        $grade_learners = Http::gradesapi()->get('grade_learner/get_learner_ids/' . $this->grades);
        $grade_learners = json_decode($grade_learners);

        $learners = "";

        foreach ($grade_learners as $learner) {
            $learners = $learners . "," . strval($learner->learner_id);
        }

        $learners = explode(",", $learners);

        $learners = array_splice($learners, 1);

        $contacts = Http::contactsapi()->get('get_contacts/' . json_encode($learners));
        $contacts = json_decode($contacts);
        
        foreach ($contacts as $contact) {
            switch ($contact->preffered_contact_method) {
                case 'email':
                    Notification::route('mail', $contact->email)->notify(new NotificationsSendNewsletter($this->newsletter, $contact));
                    break;

                case 'whatsapp':
                    break;

                default:
                    Notification::route('mail', $contact->email)->notify(new NotificationsSendNewsletter($this->newsletter, $contact));
                    break;
            }
        }
    }
}
