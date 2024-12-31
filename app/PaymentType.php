<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentType extends Model
{
    use SoftDeletes;

    public $table = 'payment_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_type_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
