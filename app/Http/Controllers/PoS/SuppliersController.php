<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SuppliersController extends Controller
{
    public function viewSuppliersAll() : View {

        $data = Suppliers::latest()->get();

        return view("modules.suppliers.suppliers_all", [
            "data" => $data
        ]);
    }

    public function viewAddSupplier() : View {
        return view("modules.suppliers.supplier_add");
    }

    public function addSupplier() {

    }

}
