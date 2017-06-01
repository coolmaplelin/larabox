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

        if ($slug == 'admin') {
            return redirect('/admin/login');
        }

        $Page = NULL;
        if ($slug) {
            $Page = Page::where('slug', $slug)->where('is_live',1)->first();
        }

        if (!$Page) {
            abort(404);
        }

        return view('public.page.index', ['Page' => $Page]);
    }

    public function create(Request $request)
    {
        $Page = new Page;
        return view('public.page.create', ['Page' => $Page]);
    }
}
