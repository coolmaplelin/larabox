<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CustomFormEntry;

class CustomFormEntrySubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The custom form entry instance.
     *
     * @var CustomFormEntry
     */
    protected $CustomFormEntry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CustomFormEntry $CustomFormEntry)
    {
        $this->CustomFormEntry = $CustomFormEntry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->markdown('emails.custom_entry_submitted')
                ->with([
                    'CustomFormEntry' => $this->CustomFormEntry,
                ]);
    }
}
