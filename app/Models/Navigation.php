<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Page;
class Navigation extends Model
{
    //
	protected $table = 'navigations';

	/*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getFullUrl()
    {
    	if($this->page_id) {
    		return Page::find($this->page_id)->getFullUrl();
    	}else{
    		return $this->link ? $this->link : '#';
    	}
    }
}
