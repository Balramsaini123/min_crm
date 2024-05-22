<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Log;
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $email;
    public $companyname;
    public function __construct($email,$companyname)
    {
        $this->email = $email;
        $this->companyname = $companyname;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Job run');
        Mail::to($this->email)->send(new WelcomeEmail($this->companyname));
    }
}
