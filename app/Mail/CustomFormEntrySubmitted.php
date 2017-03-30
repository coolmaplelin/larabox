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
        $formString = "";
        $attachment = []; 
        foreach(json_decode($this->CustomFormEntry->form_fields, true) as $form_field) {
            $formString .= $form_field['title'] . " : ";
            switch($form_field['type']) {
                case 'text':
                case 'textbox':
                case 'email':
                    $formString .= $form_field['value'];
                    break;
                case 'select':
                case 'radio':
                    $options_array = explode("\n", $form_field['options']);
                    foreach($options_array as $option) {
                        $valueSlug = str_slug($option);
                        if ($valueSlug == $form_field['value']) {
                            $formString .= $option;
                            break;
                        }
                    }
                    break;
                case 'checkbox':
                    $options_array = explode("\n", $form_field['options']);
                    $valueArray = explode(',', $form_field['value']);
                    foreach($options_array as $key => $option) {
                        $valueSlug = str_slug($option);
                        if (in_array($valueSlug, $valueArray)) {
                            if ($key > 0) {
                                $formString .= ",";
                            }
                            $formString .= $option;
                        }
                    }    
                    break;
                case 'image':
                    $formString .= "see attachment";
                    if (isset($form_field['value']) && $form_field['value']) {
                        $attachment[] = base_path().'/public'.$form_field['value'];
                    }
                    break;
                default:
                    break;
            }
            $formString .= "<br/>";

        }

        foreach($attachment as $file) {
            if (is_file($file)) {
                $this->attach($file);
            }
        }


        return $this->subject(config('app.name')." :: Form Entry Submitted")
            ->view('emails.custom_entry_submitted')
            ->with([
                    'CustomFormEntry' => $this->CustomFormEntry,
                    'formdata' => $formString
                ]);

    }
}
