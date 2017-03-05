<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Page;


class PageController extends Controller
{

        private $objnames = [];
 
	public function gettree()
	{
		$Pages = Page::where('is_live', 1)
				->whereNull('parent_id')
                ->get();

                //$nodeid = 0;
                //$nodemap = [];
                $rtnArray = [];
                foreach($Pages as $Page) {
                	$rs = [];
                	$rs['id'] = $Page->id;
                	$rs['text'] = $Page->title;
                	$this->objnames[$Page->id] = $Page->title;

                	if (count($Page->children) > 0){
                		$rs['nodes'] = $this->getnodes($Page->children);
                	}

                	$rtnArray[] = $rs;
                }
        
		return response()->json(['data' => $rtnArray, 'objnames' => $this->objnames]);
	}

	private function getnodes($children)
	{
		$rtnArray = [];
                foreach($children as $child) {
                	$rs = [];
                	$rs['id'] = $child->id;
                	$rs['text'] = $child->title;
                	$this->objnames[$child->id] = $child->title;

                	if (count($child->children) > 0) {
                		$rs['nodes']  = $this->getnodes($child->children);
                	}

                	$rtnArray[] = $rs;
                }

                return $rtnArray;
	}

}
