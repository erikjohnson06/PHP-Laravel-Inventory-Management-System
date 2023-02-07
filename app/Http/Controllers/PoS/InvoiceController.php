<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
//use App\Models\InvoiceStatus;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentStatus;
use App\Models\Product;
//use App\Models\ProductStatus;
//use App\Models\PurchaseOrder;
//use App\Models\PurchaseOrderStatus;
//use App\Models\Supplier;
//use App\Models\Unit;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoiceController extends Controller
{

    /**
     * @return View
     */
    public function viewInvoicesAll() : View {

        $data = Invoice::orderBy('invoice_date','DESC')
                ->orderBy('id','DESC')
                ->where("status_id", 1)
                ->get();

        return view("modules.invoices.invoices_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewInvoicesPending() : View {

        $data = Invoice::orderBy('invoice_date','DESC')
                ->orderBy('id','DESC')
                ->where("status_id", 0)
                ->get();

        return view("modules.invoices.invoices_pending", [
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

    /**
     * @return View
     */
    public function viewApproveInvoice(int $id) : View {

        $invoice = Invoice::with("invoice_details")->findOrFail($id);
        $payment = Payment::where('invoice_id', $invoice->invoice_no)->first();

        return view("modules.invoices.invoice_approval", [
            "invoice" => $invoice,
            "payment" => $payment
        ]);
    }

    /**
     * @return View
     */
    public function viewPrintInvoice(int $id) : View {

        $invoice = Invoice::with("invoice_details")->findOrFail($id);
        $payment = Payment::where('invoice_id', $invoice->invoice_no)->first();

        return view("modules.pdf.invoice_pdf", [
            "invoice" => $invoice,
            "payment" => $payment
        ]);
    }


    public function viewInvoiceDailyReport() : View {

        $curr_date = (new DateTime)->format("m-d-y");

        return view("modules.invoices.invoice_daily_report", [
            "curr_date" => $curr_date
        ]);
    }

    /**
     * @return View
     */
    /*
    public function viewPrintInvoiceList() : View {

        $data = Invoice::orderBy('invoice_date','DESC')
                ->orderBy('id','DESC')
                ->where("status_id", 1)
                ->get();

        return view("modules.invoices.invoice_print_list", [
            "data" => $data
        ]);
    }
    */

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function createInvoice(Request $request) : RedirectResponse {

        $notifications = [];

        if ($request->product_id == null){

            $notifications = [
                "message" => "No items have been added to the invoice",
                "alert-type" => "error"
            ];
        }
        else if ($request->paid_amount > $request->invoiceTotal){
            $notifications = [
                "message" => "Paid Amount cannot exceed the invoice total",
                "alert-type" => "error"
            ];
        }

        if ($notifications){
            return redirect()->back()->with($notifications);
        }


        DB::transaction(function() use($request){

            $customer_id = 0;

            $invoice = new Invoice;
            $invoice->invoice_no = (int) $request->invoice_no;
            $invoice->invoice_date = (DateTime::createFromFormat("Y-m-d", $request->invoice_date))->format("Y-m-d");
            $invoice->comments = $request->comments;
            $invoice->status_id = 0;
            $invoice->created_by =  Auth::user()->id;
            $invoice->created_at =  Carbon::now();

            if ($invoice->save()){

                $itemCount = count($request->product_id);

                for ($i = 0; $i < $itemCount; $i++){

                    $invoiceDetail = new InvoiceDetail;
                    $invoiceDetail->invoice_id = $invoice->invoice_no;
                    $invoiceDetail->invoice_date = $invoice->invoice_date;
                    $invoiceDetail->category_id = (int) $request->category_id[$i];
                    $invoiceDetail->product_id = (int) $request->product_id[$i];
                    $invoiceDetail->sales_qty = (int) $request->sales_qty[$i];
                    $invoiceDetail->unit_price = (float) $request->unit_price[$i];
                    $invoiceDetail->sales_price = (float) $request->sales_price[$i];
                    $invoiceDetail->status_id = 0;
                    $invoiceDetail->save();
                }

                //Add new Customers
                if ($request->customer_id == "0"){

                    $customer = new Customer;
                    $customer->name = $request->customer_name;
                    $customer->phone = $request->customer_phone;
                    $customer->email = $request->customer_email;
                    $customer->save();
                    $customer_id = $customer->id;
                }
                else {
                    $customer_id = (int) $request->customer_id;
                }

                $payment = new Payment;
                $payment->invoice_id = $invoice->invoice_no;
                $payment->customer_id = $customer_id;
                $payment->payment_date = $invoice->invoice_date;
                $payment->status_id = (int) $request->payment_status;
                $payment->discount_amount = (float) $request->invoiceDiscountAmount;
                $payment->total_amount = (float) $request->invoiceTotal;

                $paymentDetails = new PaymentDetail;
                $paymentDetails->invoice_id = $invoice->invoice_no;
                $paymentDetails->payment_date = $invoice->invoice_date;
                $paymentDetails->updated_by = Auth::user()->id;

                //Full payments
                if ($payment->status_id === 1){
                    $payment->payment_amount = (float) $request->invoiceTotal;
                    $payment->due_amount = 0;

                    $paymentDetails->current_paid_amount = (float) $request->invoiceTotal;
                }
                //Full Due payment
                else if ($payment->status_id === 2){
                    $payment->payment_amount = 0;
                    $payment->due_amount = (float) $request->invoiceTotal;

                    $paymentDetails->current_paid_amount = 0;
                }
                //Partial payments
                else if ($payment->status_id === 3){
                    $payment->payment_amount = (float) $request->payment_amount;
                    $payment->due_amount = floatVal($request->invoiceTotal) - floatVal($request->payment_amount);

                    $paymentDetails->current_paid_amount = (float) $request->payment_amount;
                }

                $payment->save();
                $paymentDetails->save();
            }
        });

        $notifications = [
            "message" => "Invoice #" . $request->invoice_no . " Created in Pending Status",
            "alert-type" => "success"
        ];

        return redirect()->route("invoices.all")->with($notifications);
    }


    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteInvoice(int $id) : RedirectResponse {

        $notifications = [];

        try {

            $invoice = Invoice::findOrFail($id);

            if (!$invoice || !$invoice->id){
                throw new Exception("Unable to Delete this Invoice");
            }

            InvoiceDetail::where("invoice_id", $invoice->invoice_no)->delete();

            PaymentDetail::where("invoice_id", $invoice->invoice_no)->delete();

            Payment::where("invoice_id", $invoice->invoice_no)->delete();

            $invoice->delete();

            $notifications = [
                "message" => "Invoice #" . $invoice->invoice_no . " Deleted",
                "alert-type" => "success"
            ];
        }
        catch (Exception $ex) {
            $notifications = [
                "message" => $ex->getMessage(),
                "alert-type" => "error"
            ];
        }

        return redirect()->route("invoices.pending")->with($notifications);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function approveInvoice(Request $request, int $id) : RedirectResponse {


        $notifications = [];

        $invoice = Invoice::findOrFail($id);

        if (!$invoice || !$request->product_id || !$request->sales_qty){
            $notifications = [
                "message" => "Whoops... An unexpected error has occurred. ",
                "alert-type" => "error"
            ];
        }

        if ($notifications){
            return redirect()->back()->with($notifications);
        }

        //Ensure qty ordered does not exceed on hand values. If so, return with an error message
        foreach ($request->sales_qty as $k => $val){

            $invoiceDetails = InvoiceDetail::where('id', $k)->first();

            $product = Product::where("id", $invoiceDetails->product_id)->first();

            if ($product->quantity < $val){

                $notifications = [
                    "message" => "Unable to fulfill item " . $product->id . ". Qty ordered (" . $val . ") exceeds availability (" . $product->quantity . ")",
                    "alert-type" => "error"
                ];

                break;
            }
        }

        if ($notifications){
            return redirect()->back()->with($notifications);
        }

        $invoice->updated_by = Auth::user()->id;
        $invoice->status_id = 1;

        DB::transaction(function() use($request, $invoice, $id){

            foreach ($request->sales_qty as $k => $val){

                $invoiceDetails = InvoiceDetail::where('id', $k)->first();
                $product = Product::where("id", $invoiceDetails->product_id)->first();

                $invoiceDetails->status_id = 1;
                $invoiceDetails->save();

                $product->quantity = ((float) $product->quantity) - ((float) $val);
                $product->save();
            }

            $invoice->save();
        });

        $notifications = [
            "message" => "Invoice #" . $id . " Approved",
            "alert-type" => "success"
        ];

        return redirect()->route("invoices.pending")->with($notifications);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function searchInvoiceDataByDates(Request $request){

        $start_date = DateTime::createFromFormat("Y-m-d", $request->start_date);  // date("Y-m-d", strtotime($request->start_date));
        $end_date = DateTime::createFromFormat("Y-m-d", $request->end_date);

        if (!$start_date || !$end_date){

            $notifications = [
                "message" => "Invalid Start or End Date",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        //dd(intval($end_date->format("U")));

        if (intval($end_date->format("U")) < intval($start_date->format("U"))){
            $notifications = [
                "message" => "Start Date must precede End Date",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        $data = Invoice::whereBetween("invoice_date", [$start_date->format("Y-m-d"), $end_date->format("Y-m-d")])
                ->where("status_id", 1)
                ->get();



        return view("modules.pdf.invoice_daily_report_pdf", [
            "data" => $data,
            "start_date" => $start_date,
            "end_date" => $end_date,
        ]);
    }
}
