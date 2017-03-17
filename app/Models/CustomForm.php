<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\CrudTrait;

class CustomForm extends Model
{
    use CrudTrait;
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'custom_forms';
    protected $fillable = [
    	'name', 
    	'slug',
    	'active', 
    	'emails', 
    	'instructions',
    	'form_fields',
    	'thankyou_title',
    	'thankyou_content',
    ];

    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getFullUrl()
    {
        return '/form/'.$this->slug;
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;

        $slug = str_slug($value, "-");
        $this->attributes['slug'] = $slug;
    }
}
