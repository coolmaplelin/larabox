<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePageRequest;
use App\Models\Page;
use Carbon\Carbon;

class PageController extends Controller
{

    /**
     * Show the page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

    /**
     * Show the form for creating a new page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Page = new Page;
        return view('public.page.create', ['Page' => $Page]);
    }

    /**
     * Store a newly created resource in storage.
     * Check https://laravel.com/docs/5.3/validation for more details
     * @param  StorePageRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(StorePageRequest $request)
    {
        $published_at = Carbon::createFromFormat('d/m/Y', $request->get('published_at'), 'Europe/London')->toDateString();
        
        $Page = Page::create(request(['title', 'name', 'is_live']));
        $Page->published_at = $published_at;
        $Page->save();
    }


}
