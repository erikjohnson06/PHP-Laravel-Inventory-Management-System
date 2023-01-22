<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderStatus;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    /**
     * @return View
     */
    public function viewPurchaseOrdersAll() : View {

        $data = PurchaseOrder::orderBy('po_date','DESC')->orderBy('id','DESC')->get();

        return view("modules.purchaseorders.purchaseorders_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewAddPurchaseOrder() : View {

        $statuses = PurchaseOrderStatus::orderBy("id", "ASC")->get();
        $suppliers = Supplier::where('status_id', 1)->orderBy('id', 'ASC')->get();
        $categories = Category::where('status_id', 1)->orderBy('id', 'ASC')->get();
        $units = Unit::all();

        return view("modules.purchaseorders.purchaseorder_add", [
            "statuses" => $statuses,
            "suppliers" => $suppliers,
            "categories" => $categories,
            "units" => $units
        ]);
    }
}
