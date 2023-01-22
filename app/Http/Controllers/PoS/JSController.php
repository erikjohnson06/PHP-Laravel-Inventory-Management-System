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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JSController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCategoriesBySupplierId(Request $request) : JsonResponse {

        $supplier_id = (int) $request->supplier_id;

        $categories = Product::with(["category"])
                ->select("category_id")
                ->where('supplier_id', $supplier_id)
                ->groupBy("category_id")
                ->orderBy('category_id', 'ASC')
                ->get();

        //dd($categories);

        return response()->json($categories);
    }
}
