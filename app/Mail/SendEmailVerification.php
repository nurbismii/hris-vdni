<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    public $detail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'id' => $this->detail['id'],
            'nik_karyawan' => $this->detail['nik_karyawan'],
        ];
        return $this->from('no-reply@vdni.top')->view('auth.verify-email', compact('data'))->with([
            'data' => $data 
        ]);
    }
}
