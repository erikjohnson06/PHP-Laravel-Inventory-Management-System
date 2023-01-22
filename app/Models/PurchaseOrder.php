<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function status(){
        return $this->belongsTo(PurchaseOrderStatus::class, "status_id", "id");
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, "supplier_id", "id");
    }
}
