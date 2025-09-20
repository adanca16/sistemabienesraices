<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name','email','phone','preferred_zone','budget',
        'listing_type','property_type','bedrooms',
        'subject','message','ip','user_agent',
    ];
}
