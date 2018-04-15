<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserImporter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public function __construct()
    {
        //
    }


    public function build()
    {
        return $this
            ->subject('[MBR-DIGITAL] Planilha Hortmart Importada')
            ->markdown('emails.user.import');
    }
}
