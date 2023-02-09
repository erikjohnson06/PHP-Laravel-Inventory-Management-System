<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

    use HasFactory;

    protected $guarded = [];

    public function status() {
        return $this->belongsTo(SupplierStatus::class, "status_id", "id");
    }

}
