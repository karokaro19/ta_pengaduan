<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class notifselesai extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $isimail;
    public function __construct($isimail)
    {
        //
        $this->isimail = $isimail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bfc.kemitraan@gmail.com')
                    ->subject('Notifikasi Pengajuan Surat Telah Selesai')
                    ->view('notif_email.notifselesai');
    }
}
