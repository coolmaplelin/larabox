<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomForm;
use App\Models\CustomFormEntry;

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
        var_dump($formentry);

        die();
    }
}
