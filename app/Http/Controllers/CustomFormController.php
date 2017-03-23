<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomFormEntrySubmitted;
use App\Models\CustomForm;
use App\Models\CustomFormEntry;
use App\Http\Helpers\StringHelper;

class CustomFormController extends Controller
{
    /**
     * Show the form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $CustomForm = CustomForm::where('slug', $slug)->first();
        if (!$CustomForm) {
            return response(view('errors.404'), 404);
        }

        //var_dump(json_decode($CustomForm->form_fields, true));
        return view('public.custom_form.show', ['CustomForm' => $CustomForm, 'FormFields' => json_decode($CustomForm->form_fields, true)]);
    }

    public function saveentry(Request $request, $slug)
    {
        $CustomForm = CustomForm::where('slug', $slug)->first();
        if (!$CustomForm) {
            return response(view('errors.404'), 404);
        }
        
        $formentry = $request->get('formentry');
        $FormFields = json_decode($CustomForm->form_fields, true);
        $FormFieldsValue = $FormFields;

        foreach($FormFields as $key => $FormField) {

            $nameSlug = str_slug($FormField['title']);

            if ($FormField['type'] == 'checkbox') {
                $FormFieldsValue[$key]['value'] = !empty($formentry[$nameSlug]) ? implode(",", $formentry[$nameSlug]) : '';
            }elseif ($FormField['type'] == 'image') {
                if ($request->file($nameSlug)) {
                    $file = $request->file($nameSlug);
                    $original_name = $file->getClientOriginalName();

                    $path = $request->file($nameSlug)->storeAs('userupload', $original_name, 'assets');
                    $FormFieldsValue[$key]['value'] = '/assets/'.$path;
                }
                
            }else{
                $FormFieldsValue[$key]['value'] = $formentry[$nameSlug];
            }
        }

        //var_dump($FormFieldsValue);

        $CustomFormEntry = new CustomFormEntry();
        $CustomFormEntry->form_id = $CustomForm->id;
        $CustomFormEntry->form_fields = json_encode($FormFieldsValue);
        $CustomFormEntry->save();

        $notifyEmails = StringHelper::parseEmails($CustomForm->emails);
        foreach($notifyEmails as $notifyEmail) {
            if ($notifyEmail != '') {
                Mail::to($notifyEmail)->send(new CustomFormEntrySubmitted($CustomFormEntry));
            }
        }

        return \Redirect::to($CustomForm->getFullUrl()."/thankyou");
    }

    public function thankyou($slug)
    {
        $CustomForm = CustomForm::where('slug', $slug)->first();
        if (!$CustomForm) {
            return response(view('errors.404'), 404);
        }

        return view('public.custom_form.thankyou', ['CustomForm' => $CustomForm]);
    }
}
