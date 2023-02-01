<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function status(){
        return $this->belongsTo(InvoiceStatus::class, "status_id", "id");
    }

    public function payment(){
        return $this->belongsTo(Payment::class, "invoice_no", "invoice_id");
    }
}
