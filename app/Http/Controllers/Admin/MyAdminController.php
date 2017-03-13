<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Navigation;

class MyAdminController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function navAction(Request $request, $nav_type = 'TOP')
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

        return view('admin.navigation', [
            'nav_type' => $nav_type, 
            'parentNavElements' => $parentNavElements,
            'childNavElements' => $childNavElements
        ]);
    }

    
}
