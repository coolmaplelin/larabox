<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\CrudTrait;
use App\Models\Redirect;
use Carbon\Carbon;

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
        return '/'.$this->slug;
    }

    public function getParentArray()
    {
        $rtnArray = [];
        if ($this->parent_id) {
            $Parent = Page::find($this->parent_id);
            if ($Parent) {

                $grandParents = $Parent->getParentArray();
                if (count($grandParents) > 0) {
                    $rtnArray = $grandParents;
                }
                $rtnArray[] = $Parent;
            }
        }

        return $rtnArray;
    }

    public function generateSlug()
    {
        $parents = $this->getParentArray();
        $slug = "";
        foreach($parents as $pa)
        {
            $slug .= str_slug($pa->title, "-")."/";
        }
        $slug .= str_slug($this->title, "-");
        return $slug;
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
    public function getPublishedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPublishedAtAttribute($value) {
        $this->attributes['published_at'] = \Date::parse($value);
    }

    public static function boot()
	{
	    parent::boot();

        static::creating(function($page) {
            $slug = $page->generateSlug();
            $page->slug = $slug;
        });

        static::updating(function($page) {
            $slug = $page->generateSlug();
            $page->slug = $slug;
        });

        static::updated(function($page) {

            $changed = $page->getDirty();

            if(array_key_exists('slug', $changed)) {
                $oldSlug = $page->getOriginal('slug');
                $newSlug = $changed['slug'];
                if ($oldSlug != $newSlug) {
                    $Redirect = new Redirect();
                    $Redirect->type = 'system';
                    $Redirect->from = $oldSlug;
                    $Redirect->to = $newSlug;
                    $Redirect->save();
                }
            }

            if (array_key_exists('parent_id', $changed) || array_key_exists('title', $changed)) {
                //Re generate slug for children
                $children = $page->children;
                if (count($children) > 0) {
                    foreach($children as $child) {
                        $childSlug = $child->generateSlug();
                        $child->slug = $childSlug;
                        $child->save();
                    }
                }
            }
        });

	}
}
