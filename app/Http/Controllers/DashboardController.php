<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Supplier;
use App\Models\Unit;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index(): View {

        //Get 20 most recent invoices
        $latestInvoices = Invoice::orderBy('invoice_date', 'DESC')
                ->orderBy('id', 'DESC')
                ->limit(20)
                ->get();

        //Get trailing month sales total
        $fromDate = (new DateTime)->modify("-1 month")->format('Y-m-d');

        $trailingSales = DB::table('invoices')
                ->join('invoice_details', 'invoices.invoice_no','=','invoice_details.invoice_id')
                ->where('invoices.status_id', 2)
                ->where('invoices.invoice_date', '>=', $fromDate)
                ->sum('invoice_details.sales_price');

        //# of Pending Purchase Orders
        $pendingPOs = DB::table('purchase_orders')
                ->where('status_id', 1)
                ->count();

        //Determine what quarter we are currently in
        $currDate = new DateTime;
        $currMonth = (int) $currDate->format('n');
        $currentQtr = ceil($currMonth / 3); //"Q" . (string)
        $currentQtrStart = DateTime::createFromFormat("Y-m-d", $currDate->format("Y") . "-" . (($currentQtr * 3) - 2) . "-01");

        //Use the current qtr start to determine to final day of the month for end of the quarter
        $currentQtrEndDay = clone $currentQtrStart;
        $currentQtrEnd = DateTime::createFromFormat("Y-m-d", $currDate->format("Y") . "-" . ($currentQtr * 3)  . "-" . $currentQtrEndDay->modify("+2 months")->format("t"));

        //Get sales from this quarter so far
        $quarterlySales = DB::table('invoices')
                ->join('invoice_details', 'invoices.invoice_no','=','invoice_details.invoice_id')
                ->where('invoices.status_id', 2)
                ->where('invoices.invoice_date', '>=', $currentQtrStart->format("Y-m-d"))
                ->where('invoices.invoice_date', '<=', $currentQtrEnd->format("Y-m-d"))
                ->sum('invoice_details.sales_price');

        //Value of active products with approved purchased orders
        $currentInventoryValue = DB::table('purchase_orders')
                ->join('products', 'products.id','=','purchase_orders.product_id')
                ->where('purchase_orders.status_id', 2)
                ->whereIn('products.status_id', [1,2])
                ->sum('purchase_price');

        //dd($currentInventoryValue);

        return view("admin.index", [
            "trailingSales" => $trailingSales,
            "pendingPOs" => $pendingPOs,
            "currentQtr" => "Q" . $currentQtr,
            "quarterlySales" => $quarterlySales,
            "currentInventoryValue" => $currentInventoryValue,
            "latestInvoices" => $latestInvoices
        ]);
    }
}
