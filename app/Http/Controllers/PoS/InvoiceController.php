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
    public function viewInvoicesPEnding() : View {

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

    public function viewApproveInvoice(int $id) : View {

        $invoice = Invoice::findOrFail($id);

        return view("modules.invoices.invoice_approval", [
            "invoice" => $invoice,
//            "categories" => $categories,
//            "customers" => $customers,
//            "invoice_id" => $invoice_id,
//            "curr_date" => $curr_date,
//            "payment_statuses" => $payment_statuses
        ]);
    }

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


    public function deleteInvoice(int $id) : RedirectResponse {

        $notifications = [];

        try {

            $invoice = Invoice::findOrFail((int) $id);

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
}
