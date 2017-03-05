<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNewsletters extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'user_newsletters';
    protected $fillable = [
    	'user_id', 
    	'newsletter_id',
    ];

    public $timestamps = false;
}
