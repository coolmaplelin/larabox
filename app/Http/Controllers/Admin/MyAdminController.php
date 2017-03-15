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
 
        $parentNavElements = Navigation::where('nav_type', $nav_type)
               ->whereNull('parent_id')
               ->orderBy('sort', 'asc')
               ->get();
        $childNavElements = [];

        foreach($parentNavElements as $parentNavElement) {
            $childNavElements[$parentNavElement->id] = Navigation::where('nav_type', $nav_type)
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
        $response = ['success' => false];

        $nav_type = $request->get('nav_type');
        $nav_items = $request->get('nav_items');
        $nav_items_array = json_decode($nav_items, true);

        $allNavIds = [];

        foreach($nav_items_array as $parent_nav) {

          if ($parent_nav['origid']) {
            $Navigation = Navigation::find($parent_nav['origid']);
          }else{
            $Navigation = new Navigation();
          }

          $Navigation->nav_type = $nav_type;
          $Navigation->name = $parent_nav['name'];
          $Navigation->page_id = $parent_nav['page_id'] ? $parent_nav['page_id'] : NULL;
          $Navigation->link = $parent_nav['link'];
          $Navigation->active = $parent_nav['active'];
          $Navigation->save();
          $allNavIds[] = $Navigation->id;

          if (count($parent_nav['subnavs']) > 0) {
            $sub_items_array = $parent_nav['subnavs'];
            foreach($sub_items_array as $sub_nav) {
              if ($sub_nav['origid']) {
                $SubNavigation = Navigation::find($sub_nav['origid']);
              }else{
                $SubNavigation = new Navigation();
              }

              $SubNavigation->nav_type = $nav_type;
              $SubNavigation->parent_id = $Navigation->id;
              $SubNavigation->name = $sub_nav['name'];
              $SubNavigation->page_id = $sub_nav['page_id'] ? $sub_nav['page_id'] : NULL;
              $SubNavigation->link = $sub_nav['link'];
              $SubNavigation->active = $sub_nav['active'];
              $SubNavigation->save();

              $allNavIds[] = $SubNavigation->id;
            }
          }
        }

        //Delete the nav
        $AllNavigations = Navigation::where('nav_type', $nav_type)
               ->get();
        foreach($AllNavigations as $Navigation) {
          if (!in_array($Navigation->id, $allNavIds)) {
            $Navigation->delete();
          }
        }

        $response = ['success' => true];
        return response()->json($response);
    }

    
}
