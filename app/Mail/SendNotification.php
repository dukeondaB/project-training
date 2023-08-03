<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $subjectCount;
    /**
     * @var mixed
     */
    public $notRegisteredSubjects;

    /**
     * Create a new message instance.
     *
     * @param string $studentName
     * @param int $subjectCount
     */
    public function __construct($studentName, $subjectCount, $notRegisteredSubjects)
    {
        $this->studentName = $studentName;
        $this->subjectCount = $subjectCount;
        $this->notRegisteredSubjects = $notRegisteredSubjects;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->subjectCount){
            return $this->view('mail.sendnotification')
                ->subject('Thông báo đăng ký môn học')
                ->with([
                    'studentName' => $this->studentName,
                    'subjectCount' => $this->subjectCount,
                    'notRegisteredSubjects'=> $this->notRegisteredSubjects,
                ]);
        }else{
            return $this->view('mail.sendnotification')
                ->subject('Thông báo đăng ký môn học')
                ->with([
                    'studentName' => $this->studentName
                ]);
        }


    }
}
