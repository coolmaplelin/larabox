<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\CrudTrait;


class CustomFormEntry extends Model
{
    use CrudTrait;
    use Notifiable;	
    
    protected $table = 'custom_form_entry';
    protected $fillable = [
    	'form_id', 
    	'form_fields',
    	'is_actioned'
    ];

    public $timestamps = true;

/*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    
    public function custom_form()
    {
        return $this->belongsTo('App\Models\CustomForm','form_id');
    }    
}
