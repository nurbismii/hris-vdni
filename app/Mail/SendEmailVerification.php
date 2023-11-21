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
            'nik_karyawan' => $this->detail['nik_karyawan'],
            'email' => $this->detail['email']
        ];
        return $this->from('no-reply@vdni.my.id')->subject('Verifikasi email kamu')->view('auth.verify-email', compact('data'))->with([
            'data' => $data 
        ]);
    }
}
