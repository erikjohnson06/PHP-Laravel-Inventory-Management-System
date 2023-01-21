<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @return View
     */
    public function viewProductsAll() : View {

        $data = Product::latest()->get();

        return view("modules.products.products_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewAddProduct() : View {

        $statuses = ProductStatus::orderBy("id", "ASC")->get();
        $suppliers = Supplier::where('status_id', 1)->orderBy('id', 'ASC')->get();
        $categories = Category::where('status_id', 1)->orderBy('id', 'ASC')->get();
        $units = Unit::all();

        return view("modules.products.product_add", [
            "statuses" => $statuses,
            "suppliers" => $suppliers,
            "categories" => $categories,
            "units" => $units
        ]);
    }

    /**
     * @return View
     */
    public function viewEditProduct(int $id) : View {

        $data = Product::findOrFail($id);

        $statuses = ProductStatus::orderBy("id", "ASC")->get();
        $suppliers = Supplier::where('status_id', 1)->orderBy('id', 'ASC')->get();
        $categories = Category::where('status_id', 1)->orderBy('id', 'ASC')->get();
        $units = Unit::all();

        return view("modules.products.product_edit", [
            "data" => $data,
            "statuses" => $statuses,
            "suppliers" => $suppliers,
            "categories" => $categories,
            "units" => $units
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addProduct(Request $request) : RedirectResponse {

        $request->validate([
            "name" => "required",
            "category_id" => "required",
            "supplier_id" => "required",
            "unit_id" => "required",
            "status_id" => "required"
        ],[
            "name.required" => "Please Enter a Product Name",
            "category_id.required" => "Please Select a Category",
            "supplier_id.required" => "Please Select a Supplier",
            "unit_id.required" => "Please Select a Unit of Measure",
            "status_id.required" => "Please Select a Status"
        ]);

        Product::insert([
            "name" => $request->name,
            "category_id" => $request->category_id,
            "supplier_id" => $request->supplier_id,
            "unit_id" => $request->unit_id,
            "status_id" => $request->status_id,
            "quantity" => 0,
            "created_by" => Auth::user()->id,
            "created_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "New Product Added",
            "alert-type" => "success"
        ];

        return redirect()->route("products.all")->with($notifications);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProduct(Request $request) : RedirectResponse {

        $id = (int) $request->id;

        $request->validate([
            "name" => "required",
            "category_id" => "required",
            "supplier_id" => "required",
            "unit_id" => "required",
            "status_id" => "required"
        ],[
            "name.required" => "Please Enter a Product Name",
            "category_id.required" => "Please Select a Category",
            "supplier_id.required" => "Please Select a Supplier",
            "unit_id.required" => "Please Select a Unit of Measure",
            "status_id.required" => "Please Select a Status"
        ]);

        Product::findOrFail($id)->update([
            "name" => $request->name,
            "category_id" => $request->category_id,
            "supplier_id" => $request->supplier_id,
            "unit_id" => $request->unit_id,
            "status_id" => $request->status_id,
            "quantity" => 0,
            "updated_by" => Auth::user()->id,
            "updated_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "Product Updated",
            "alert-type" => "success"
        ];

        return redirect()->route("products.all")->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteProduct(int $id) : RedirectResponse {

        Product::findOrFail($id)->delete();

        $notifications = [
            "message" => "Product Deleted",
            "alert-type" => "success"
        ];

        return redirect()->back()->with($notifications);
    }
}
