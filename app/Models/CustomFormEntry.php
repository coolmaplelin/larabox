<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFormEntry extends Model
{
    
    protected $table = 'custom_form_entry';
    protected $fillable = [
    	'form_id', 
    	'form_fields',
    	'is_actioned'
    ];

    public $timestamps = true;
}
