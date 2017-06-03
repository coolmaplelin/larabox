<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
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
     * @param  PageStoreRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(PageStoreRequest $request)
    {

        $Page = new Page;
        $this->_save($request, $Page);
        session()->flash('flash_message','Page is created.');

        return redirect('/page/edit/'.$Page->id);
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Page = Page::find($id);

        if (!$Page) {
            abort(404);
        }

        return view('public.page.edit', ['Page' => $Page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageUpdateRequest $request, $id)
    {
        $Page = Page::find($id);
        $this->_save($request, $Page);

        session()->flash('flash_message','Page is updated.');

        return redirect('/page/edit/'.$Page->id);
    }

    /*
    *   This function is used for both store and update 
    *   It convert some fields value before saving
    */
    private function _save($request, $Page)
    {
        $published_at = Carbon::createFromFormat('d/m/Y', $request->get('published_at'), 'Europe/London')->toDateString();

        $Page->title = $request->get('title');
        $Page->name = $request->get('name');
        $Page->is_live = $request->get('is_live') == "1" ? "1" : "0";
        $Page->published_at = $published_at;
        $Page->save();
    }
}
