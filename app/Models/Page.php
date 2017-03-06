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

    
    public function parent()
    {
        return $this->hasOne('App\Models\Page','parent_id');
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

    public function setParentIdAttribute($value) {
        $this->attributes['parent_id'] = $value;

        $slug = str_slug($this->title , "-");
        if ($value) {
            $Parent = Page::find($value);
            $counter = 0;
            while ($Parent && $counter < 100) {

                $slug = str_slug($Parent->title , "-")."/".$slug;
                if ($Parent->parent_id) {
                    $Parent = Page::find($Parent->parent_id);
                }else{
                    $Parent = NULL;
                }
                $counter++;
            }
        }

        $this->attributes['slug'] = $slug;
    }


 //    public static function boot()
	// {
	//     parent::boot();

	//     // registering a callback to be executed upon the creation of an activity
	//     static::created(function($page) {

 //            $page->slug = str_slug($page->title, "-");
 //            $page->save();
	//     });

 //        static::updated(function($page) {

 //            $page->slug = str_slug($page->title, "-");

 //            //$page->save();
 //        });

	// }
}
