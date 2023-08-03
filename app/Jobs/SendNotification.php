<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNotification as SendNotificationMail;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $studentName;
    public $subjectCount;
    /**
     * @var mixed
     */
    public $notRegisterdSubjects;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $studentName
     * @param int $subjectCount
     */
    public function __construct($email, $studentName, $subjectCount, $notRegisteredSubjects)
    {
        $this->email = $email;
        $this->studentName = $studentName;
        $this->subjectCount = $subjectCount;
        $this->notRegisterdSubjects = $notRegisteredSubjects;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->subjectCount) {
            Mail::to($this->email)->send(new SendNotificationMail($this->studentName, $this->subjectCount, $this->notRegisterdSubjects));
        } else {
            Mail::to($this->email)->send(new SendNotificationMail($this->studentName, $this->notRegisterdSubjects));
        }
    }
}
