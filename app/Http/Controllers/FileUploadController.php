<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Helpers\UploadHandler;

class FileUploadController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload');
    }

    public function uploadimage(Request $request)
    {
        //var_dump($request->file('files'));

        $UploadHandler = new UploadHandler();
        $response = $UploadHandler->get_response();
        //var_dump($response);die();
        //return response()->json($response);
    }
}
