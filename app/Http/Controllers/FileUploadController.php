<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Helpers\UploadHandler;
use App\Models\Page;

class FileUploadController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objtype = 'page';
        $objid = '4';
        return view('upload', ['objtype' => $objtype, 'objid' => $objid]);
    }

    public function handle(Request $request, $objtype, $objid)
    {

        $Page = Page::find($objid);
        $galleryJson = $Page->gallery;
        $galleryArray = $galleryJson ? json_decode($galleryJson, true) : array();

        if($request->isMethod('get')) {
            $response = ['files' => $galleryArray];
        }else{

            $storagePath  = \Storage::disk('assets')->getDriver()->getAdapter()->getPathPrefix();
            $options = [
                'script_url' => $request->path(),
                'upload_dir' => $storagePath."files/".$objtype."/".$objid."/",
                'upload_url' => 'http://'.$_SERVER['HTTP_HOST'].'/assets/files/'.$objtype."/".$objid."/",
                'print_response' => false,
            ];

            $UploadHandler = new UploadHandler($options);
            $response = $UploadHandler->get_response();

            if ($request->isMethod('post') ){
                if (isset($response['files'][0])) {
                    $galleryArray[] = $response['files'][0];

                    $Page->gallery = json_encode($galleryArray);
                    $Page->save();
                }
                
            }

            if ($request->isMethod('delete')) {
                $file = $request->get('file');
                if (isset($response[$file]) && $response[$file]) {
                    foreach($galleryArray as $key => $item) {
                        if ($item['name'] == $file) {
                            unset($galleryArray[$key]);
                        }
                    }
                    $galleryArray = array_values($galleryArray);
                    $Page->gallery = json_encode($galleryArray);
                    $Page->save();
                }
            }
        }

//        var_dump($response);
        return response()->json($response);
    }

    public function saveorder(Request $request, $objtype, $objid)
    {
        $response = ['success' => false];
        $Page = Page::find($objid);
        $galleryJson = $Page->gallery;
        $galleryArray = $galleryJson ? json_decode($galleryJson, true) : array();

        $newGalleryArray = [];
        $fileorders = $request->get('fileorders');
        foreach($fileorders as $seq => $file) {
            foreach($galleryArray as $key => $item) {
                if ($item['name'] == $file) {
                    $newGalleryArray[] = $item;
                    break;
                }
            }
        }
        $Page->gallery = json_encode($newGalleryArray);
        $Page->save();

        $response = ['success' => true];

        return response()->json($response);
    }
}
