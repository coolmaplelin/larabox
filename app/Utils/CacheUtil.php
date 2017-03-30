<?php

namespace App\Utils;

use App\Models\Navigation;

class CacheUtil
{

    public static function genMenu($nav_type)
    {
        $cache_file = base_path().'/resources/views/cache/nav'.$nav_type.'.blade.php';

        $parentNavElements = Navigation::where('nav_type', $nav_type)
               ->whereNull('parent_id')
               ->orderBy('sort', 'asc')
               ->get();

        $rtnString = '<ul class="nav navbar-nav">';
        foreach($parentNavElements as $parentNavElement) {
            // $childNavElements[$parentNavElement->id] = Navigation::where('nav_type', $nav_type)
            //    ->where('parent_id', $parentNavElement->id)
            //    ->orderBy('sort', 'asc')
            //    ->get();
            $rtnString .= "<li><a href='".$parentNavElement->getFullUrl()."'>".$parentNavElement->name."</a></li>";
        }

        $rtnString .= '</ul>';

        $fh = fopen($cache_file, 'w') or die("can't open file ".$cache_file);
        fwrite($fh, $rtnString);
        fclose($fh);
    }
}
