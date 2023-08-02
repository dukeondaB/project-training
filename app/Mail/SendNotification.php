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
     * Create a new message instance.
     *
     * @param string $studentName
     * @param int $subjectCount
     */
    public function __construct($studentName, $subjectCount)
    {
        $this->studentName = $studentName;
        $this->subjectCount = $subjectCount;
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
