<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceImage extends Model
{
    use HasFactory;

    public $table = 'invoice_images';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'invoice_id',
        'image_path',
        'image_name',
        'created_at',
        'updated_at',
    ];

    // Define the inverse relationship with Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
