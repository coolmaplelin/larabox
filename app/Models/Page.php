<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\CrudTrait;


class Page extends Model
{
    use CrudTrait;
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pages';
    protected $fillable = [
    	'name', 
    	'is_live', 
    	'title', 
    	'slug',
    	'published_at', 
    	'parent_id',
    	'content',
    	'gallery',
    	'meta_title',
    	'meta_description'
    ];

    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getFullUrl()
    {
        return '/page/'.$this->slug;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function children()
    {
    	return $this->hasMany('App\Models\Page','parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPublishedAtAttribute($value) {
        $this->attributes['published_at'] = \Date::parse($value);
    }

    public function setTitleAttribute($value) {
    	$this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value , "-");
    }


 //    public static function boot()
	// {
	//     parent::boot();

	//     // registering a callback to be executed upon the creation of an activity
	//     static::creating(function($page) {


	//     });

	// }
}
