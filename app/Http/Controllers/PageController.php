<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $slug = $_SERVER['REQUEST_URI'];
        $slug = substr($slug, 1);
        if(strpos($slug, "?") !== false)
            $slug = substr($slug, 0, strpos($slug, "?"));


        $Page = NULL;
        if ($slug) {
            $Page = Page::where('slug', $slug)->where('is_live',1)->first();
        }

        if (!$Page) {
            return response(view('errors.404'), 404);
        }

        return view('public.page.index', ['Page' => $Page]);
    }
}
