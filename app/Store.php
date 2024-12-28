<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    public $table = 'stores';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        "name",
        "contact_number", 
        "email",
        "logo",
        "address_line1",
        "address_line2",
        "city",
        "state",
        "postal_code",
        "country",
        "created_by" ,
        'created_at',
        'updated_at',
        'deleted_at',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user')
                    ->withTimestamps();
    }
}
