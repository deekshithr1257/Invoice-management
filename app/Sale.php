<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    public $table = 'sales';

    protected $dates = [
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'store_id',
        'entry_date',
        'cash',
        'pay_out',
        'pay_out_admin',
        'cash_balance',
        'card',
        'description',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
