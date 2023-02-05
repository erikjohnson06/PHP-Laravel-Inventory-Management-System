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
use DateTime;
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

        $data = PurchaseOrder::orderBy('po_date','DESC')
                ->orderBy('id','DESC')
                ->get();

        return view("modules.purchaseorders.purchaseorders_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewAddPurchaseOrder() : View {

        $suppliers = Supplier::where('status_id', 1)
                ->orderBy('id', 'ASC')
                ->get();

        $curr_date = (new DateTime)->format("Y-m-d");

        return view("modules.purchaseorders.purchaseorder_add", [
            "suppliers" => $suppliers,
            "curr_date" => $curr_date
        ]);
    }


    /**
     * @return View
     */
    public function viewEditPurchaseOrder(int $id) : View {

        $data = Product::findOrFail($id);

        $statuses = ProductStatus::orderBy("id", "ASC")->get();
        $suppliers = Supplier::where('status_id', 1)
                ->orderBy('id', 'ASC')
                ->get();
        $categories = Category::where('status_id', 1)
                ->orderBy('id', 'ASC')
                ->get();
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
     * @return View
     */
    public function viewPurchaseOrdersApproval() : View {

        $data = PurchaseOrder::where("status_id", 0)
                ->orderBy('po_date','DESC')
                ->orderBy('id','DESC')
                ->get();

        return view("modules.purchaseorders.purchaseorders_approve", [
            "data" => $data
        ]);
    }

    public function viewPurchaseOrderDailyReport() : View {

        $curr_date = (new DateTime)->format("m-d-y");

        return view("modules.purchaseorders.purchaseorder_daily_report", [
            "curr_date" => $curr_date
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function createPurchaseOrder(Request $request) : RedirectResponse {

        $notifications = [];

        //dd($request->po_date);

        if ($request->product_id == null){

            $notifications = [
                "message" => "No products have been entered",
                "alert-type" => "error"
            ];
        }

        if ($notifications){
            return redirect()->back()->with($notifications);
        }

        $itemCount = count($request->product_id);

        for ($i = 0; $i < $itemCount; $i++){

            $purchaseOrder = new PurchaseOrder;
            $purchaseOrder->po_date = date("Y-m-d", strtotime($request->po_date[$i]));
            $purchaseOrder->po_number = trim($request->po_number[$i]);
            $purchaseOrder->po_description = trim($request->po_description[$i]);
            $purchaseOrder->product_id = (int) $request->product_id[$i];
            $purchaseOrder->supplier_id = (int) $request->supplier_id[$i];
            $purchaseOrder->category_id = (int) $request->category_id[$i];
            $purchaseOrder->purchase_qty = (float) $request->purchase_qty[$i];
            $purchaseOrder->unit_price = (float) $request->unit_price[$i];
            $purchaseOrder->purchase_price = (float)$request->purchase_price[$i];
            $purchaseOrder->status_id = 0;
            $purchaseOrder->created_by =  Auth::user()->id;
            $purchaseOrder->created_at =  Carbon::now();

            $purchaseOrder->save();
        }

        $notifications = [
            "message" => "New Purchase Order Created",
            "alert-type" => "success"
        ];

        return redirect()->route("purchaseorders.all")->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deletePurchaseOrder(int $id) : RedirectResponse {

        $data = PurchaseOrder::findOrFail($id);

        if (!$data){

            $notifications = [
                "message" => "Purchase Order Not Found",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        if ($data->status_id !== 0){

            $notifications = [
                "message" => "Purchase Order Cannot be Deleted.",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        $data->delete();

        $notifications = [
            "message" => "Purchase Order Deleted",
            "alert-type" => "success"
        ];

        return redirect()->back()->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function cancelPurchaseOrder(int $id) : RedirectResponse {

        $data = PurchaseOrder::findOrFail($id);

        if (!$data){

            $notifications = [
                "message" => "Purchase Order Not Found",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        if ($data->status_id !== 0){

            $notifications = [
                "message" => "Purchase Order Cannot be Canceled.",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        $data->status_id = 2; //2 = Cancelled
        $data->save();

        $notifications = [
            "message" => "Purchase Order Canceled",
            "alert-type" => "success"
        ];

        return redirect()->back()->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function approvePurchaseOrder(int $id) : RedirectResponse {

        $data = PurchaseOrder::findOrFail($id);

        $notifications = [];

        if (!$data){

            $notifications = [
                "message" => "Purchase Order Not Found",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        if ($data->status_id !== 0){

            $notifications = [
                "message" => "Purchase Order Cannot be Deleted.",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        $product = Product::where('id', $data->product_id)->first();

        $purchase_qty = (float) $data->purchase_qty + (float) $product->quantity ;

        $product->quantity = $purchase_qty;

        if ($product->save()){
            $data->status_id = 1;
            $data->save();

            $notifications = [
                "message" => "Purchase Order Approved",
                "alert-type" => "success"
            ];
        }

        return redirect()->route("purchaseorder.approval")->with($notifications);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function searchPurchaseOrderDataByDates(Request $request){

        $start_date = DateTime::createFromFormat("Y-m-d", $request->start_date);  // date("Y-m-d", strtotime($request->start_date));
        $end_date = DateTime::createFromFormat("Y-m-d", $request->end_date);

        if (!$start_date || !$end_date){

            $notifications = [
                "message" => "Invalid Start or End Date",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        if (intval($end_date->format("U")) < intval($start_date->format("U"))){
            $notifications = [
                "message" => "Start Date must precede End Date",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        $data = PurchaseOrder::whereBetween("po_date", [$start_date->format("Y-m-d"), $end_date->format("Y-m-d")])
                ->where("status_id", 1)
                ->get();

        return view("modules.pdf.purchaseorder_daily_report_pdf", [
            "data" => $data,
            "start_date" => $start_date,
            "end_date" => $end_date,
        ]);
    }
}
