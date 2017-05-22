<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PDFController extends Controller
{
    /**
     * This renders header html
     * @return \Illuminate\Http\Response
     */
    public function header(Request $request)
    {

        return view('pdf.header');
    }

    /**
     * This renders footer html
     * @return \Illuminate\Http\Response
     */
    public function footer(Request $request)
    {

        return view('pdf.footer');
    }


    public function test(Request $request)
    {
        $snappy = \App::make('snappy.pdf');

        if ($request->exists('preview')) {
            //Show HTML if preview parameter presents
            return view('pdf.invoice', ['name' => 'Maple Lin']);
        }


        $pdf = \PDF::loadView('pdf.invoice', ['name' => 'Maple Lin'])
            ->setPaper('a4')
            ->setOption('header-html', route('pdf_header'));
        return $pdf->download('invoice.pdf');
    }


}
