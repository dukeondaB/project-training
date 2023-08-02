<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotiStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $studentName;
    /**
     * @var mixed
     */
    public $totalPoint;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($studentName, $totalPoint)
    {
        $this->studentName = $studentName;
        $this->totalPoint = $totalPoint;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.sendstatus')
            ->subject('Thông báo buộc thôi học')
            ->with([
                'studentName' => $this->studentName,
                'totalPoint' => $this->totalPoint,
            ]);
    }
}
