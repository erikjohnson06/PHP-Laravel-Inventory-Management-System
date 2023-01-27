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
                ->where('status_id', [1,2])
                ->groupBy("category_id")
                ->orderBy('category_id', 'ASC')
                ->get();

        return response()->json($categories);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductsByCategoriesAndSupplierId(Request $request) : JsonResponse {

        $supplier_id = (int) $request->supplier_id;
        $category_id = (int) $request->category_id;

        $products = Product::where('supplier_id', $supplier_id)
                ->where('category_id', $category_id)
                ->where('status_id', [1,2])
                ->orderBy('id', 'ASC')
                ->get();

        return response()->json($products);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductsByCategoryId(Request $request) : JsonResponse {

        $category_id = (int) $request->category_id;

        $products = Product::where('category_id', $category_id)
                ->where('status_id', [1,2])
                ->orderBy('id', 'ASC')
                ->get();


        return response()->json($products);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductAvailableQty(Request $request) : JsonResponse {

        $product_id = (int) $request->product_id;

        $product = Product::where('id', $product_id)->first();

        if (!$product){

        }

        $qty = $product->quantity;

        return response()->json($qty);
    }
}
