<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Navigation;
use App\Models\Page;

class MyAdminController extends Controller
{

    /**
     * Show the navigation.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNav(Request $request, $nav_type = 'TOP')
    {
 
        $parentNavElements = Navigation::where('active', 1)
               ->where('nav_type', $nav_type)
               ->whereNull('parent_id')
               ->orderBy('sort', 'asc')
               ->get();
        $childNavElements = [];

        foreach($parentNavElements as $parentNavElement) {
            $childNavElements[$parentNavElement->id] = Navigation::where('active', 1)
               ->where('nav_type', $nav_type)
               ->where('parent_id', $parentNavElement->id)
               ->orderBy('sort', 'asc')
               ->get();
        }

        $pages = Page::where('is_live', 1)
               ->orderBy('name', 'asc')
               ->get();

        return view('admin.navigation', [
            'nav_type' => $nav_type, 
            'parentNavElements' => $parentNavElements,
            'childNavElements' => $childNavElements,
            'pages' => $pages
        ]);
    }

    /**
     * Save the navigation. (AJAX)
     *
     * @return \Illuminate\Http\Response
     */
    public function saveNav(Request $request)
    {
        $nav_type = $request->get('nav_type');
        $nav_items = $request->get('nav_items');
        $nav_items_array = json_decode($nav_items, true);

        foreach($nav_items_array as $parent_nav) {

          if ($parent_nav['origid']) {
            $Navigation = Navigation::find($parent_nav['origid']);
          }else{
            $Navigation = new Navigation();
          }

          $Navigation->name = $parent_nav['name'];
          $Navigation->page_id = $parent_nav['page_id'];
          $Navigation->link = $parent_nav['link'];
          $Navigation->active = $parent_nav['active'];
          $Navigation->save();

          if (count($parent_nav['subnavs']) > 0) {
            
          }
        }
    }

    
}
