<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentStatus;
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

class InvoiceController extends Controller
{

    /**
     * @return View
     */
    public function viewInvoicesAll() : View {

        $data = Invoice::orderBy('invoice_date','DESC')
                ->orderBy('id','DESC')
                ->get();

        return view("modules.invoices.invoices_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewAddInvoice() : View {

        $categories = Category::where('status_id', 1)
                ->orderBy('id', 'ASC')
                ->get();

        $payment_statuses = PaymentStatus::orderBy('id','ASC')->get();

        $customers = Customer::where("status_id", 1)->get();

        $invoice_data = Invoice::orderBy("id", "DESC")->first();
        $invoice_id = 0; //TO DO: need to re-do this in case multiple users are adding invoices at the same time

        if (is_null($invoice_data)){
            $invoice_id = 1000;
        }
        else {
            $invoice_id = $invoice_data->invoice_no + 1;
        }

        $curr_date = (new DateTime)->format("Y-m-d");

        return view("modules.invoices.invoice_add", [
            "categories" => $categories,
            "customers" => $customers,
            "invoice_id" => $invoice_id,
            "curr_date" => $curr_date,
            "payment_statuses" => $payment_statuses
        ]);
    }
}
