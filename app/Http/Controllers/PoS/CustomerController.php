<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerStatus;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentStatus;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller {

    /**
     * @return View
     */
    public function viewCustomersAll(): View {

        $data = Customer::latest()->get();

        return view("modules.customers.customers_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewCreditCustomersAll(): View {

        $data = Payment::where("due_amount", ">", 0)->get();

        return view("modules.customers.credit_customers_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewPaidCustomersAll(): View {

        $data = Payment::where("due_amount", 0)->get();

        return view("modules.customers.paid_customers_all", [
            "data" => $data
        ]);
    }

    /**
     * @param int $invoice_id
     * @return View
     */
    public function viewEditCustomerInvoice(int $invoice_id): View {

        $payment = Payment::where("invoice_id", $invoice_id)->first();

        $payment_statuses = PaymentStatus::whereIn("id", [1, 3])->orderBy('id', 'ASC')->get();

        $inv_details = InvoiceDetail::where('invoice_id', $invoice_id)->get();

        $curr_date = (new DateTime)->format("m/d/Y");

        return view("modules.customers.edit_customer_invoice", [
            "curr_date" => $curr_date,
            "inv_details" => $inv_details,
            "payment" => $payment,
            "payment_statuses" => $payment_statuses
        ]);
    }

    /**
     * @param int $invoice_id
     * @return View
     */
    public function viewCustomerInvoiceDetails(int $invoice_id): View {

        $payment = Payment::where("invoice_id", $invoice_id)->first();

        $payment_details = PaymentDetail::where("invoice_id", $invoice_id)->orderBy("created_at", "ASC")->get();

        $inv_details = InvoiceDetail::where('invoice_id', $invoice_id)->get();

        return view("modules.pdf.customer_invoice_details_pdf", [
            "inv_details" => $inv_details,
            "payment_details" => $payment_details,
            "payment" => $payment
        ]);
    }

    /**
     * @return View
     */
    public function viewPrintCreditCustomersAll(): View {

        $data = Payment::where("due_amount", ">", 0)->get();

        $date = new DateTime('now', new DateTimeZone('America/New_York'));

        $title = "Invoices Due";

        return view("modules.pdf.customer_invoice_all_pdf", [
            "data" => $data,
            "date" => $date,
            "title" => $title
        ]);
    }

    /**
     * @return View
     */
    public function viewPrintPaidCustomersAll(): View {

        $data = Payment::where("due_amount", 0)->get();

        $date = new DateTime('now', new DateTimeZone('America/New_York'));

        $title = "Invoices Paid in Full";

        return view("modules.pdf.customer_invoice_all_pdf", [
            "data" => $data,
            "date" => $date,
            "title" => $title
        ]);
    }

    /**
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function viewCustomersReportPDF(Request $request) {

        if (!$request->customer_id) {

            $notifications = [
                "message" => "Please select a customer",
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        $data = null;
        $title = "";

        switch ($request->query_type) {
            case "customer_paid":

                $data = Payment::where("customer_id", $request->customer_id)->
                        where("due_amount", 0)
                        ->get();

                $title = "Invoices Paid in Full";
                break;

            case "customer_credit":
            default:

                $data = Payment::where("customer_id", $request->customer_id)->
                        where("due_amount", ">", 0)
                        ->get();

                $title = "Invoices with Outstanding Balance";
                break;
        }

        $date = new DateTime('now', new DateTimeZone('America/New_York'));

        return view("modules.pdf.customer_invoice_all_pdf", [
            "data" => $data,
            "date" => $date,
            "title" => $title
        ]);
    }

    /**
     * @return View
     */
    public function viewAddCustomer(): View {

        $statuses = CustomerStatus::orderBy("id", "ASC")->get();

        return view("modules.customers.customer_add", [
            "statuses" => $statuses
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewEditCustomer(int $id): View {

        $entity = Customer::findOrFail($id);
        $statuses = CustomerStatus::orderBy("id", "ASC")->get();

        return view("modules.customers.customer_edit", [
            "data" => $entity,
            "statuses" => $statuses
        ]);
    }

    /**
     * @return View
     */
    public function viewCustomersReport(): View {

        $data = Customer::latest()->get();

        return view("modules.customers.customer_report", [
            "data" => $data
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addCustomer(Request $request): RedirectResponse {

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "address" => "required"
                ], [
            "name.required" => "Please Enter a Customer Name",
            "phone.required" => "Please Enter a Phone Number for this Customer",
            "email.required" => "Please Enter an Email Address for this Customer",
            "address.required" => "Please Enter an Address for this Customer"
        ]);

        $img_url = "";

        if ($request->file("image")) {

            $img = $request->file("image");
            $name_gen = hexdec(uniqid()) . "." . $img->getClientOriginalExtension();
            $img_url = "upload/customers/" . $name_gen;
            Image::make($img)->resize(200, 200)->save($img_url);
        }

        Customer::insert([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "address" => $request->address,
            "image" => $img_url,
            "status_id" => $request->status_id,
            "created_by" => Auth::user()->id,
            "created_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "New Customer Added Successfully",
            "alert-type" => "success"
        ];

        return redirect()->route("customers.all")->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteCustomer(int $id): RedirectResponse {

        $entity = Customer::findOrFail($id);

        if ($entity && $entity->image) {
            unlink($entity->image);
        }

        Customer::findOrFail($id)->delete();

        $notifications = [
            "message" => "Customer Deleted ",
            "alert-type" => "success"
        ];

        return redirect()->back()->with($notifications);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCustomer(Request $request): RedirectResponse {

        $id = (int) $request->id;

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "address" => "required"
                ], [
            "name.required" => "Please Enter a Customer Name",
            "phone.required" => "Please Enter a Phone Number for this Customer",
            "email.required" => "Please Enter an Email Address for this Customer",
            "address.required" => "Please Enter an Address for this Customer"
        ]);

        $fields = [
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "address" => $request->address,
            "status_id" => $request->status_id,
            "updated_by" => Auth::user()->id,
            "updated_at" => Carbon::now()
        ];

        if ($request->file("image")) {

            $img = $request->file("image");
            $name_gen = hexdec(uniqid()) . "." . $img->getClientOriginalExtension();
            $img_url = "upload/customers/" . $name_gen;
            Image::make($img)->resize(200, 200)->save($img_url);

            $fields["image"] = $img_url;
        }

        Customer::findOrFail($id)->update($fields);

        $notifications = [
            "message" => "Customer Updated",
            "alert-type" => "success"
        ];

        return redirect()->route("customers.all")->with($notifications);
    }

    /**
     * @param Request $request
     * @param int $invoice_id
     * @return RedirectResponse
     */
    public function updateCustomerInvoice(Request $request, int $invoice_id): RedirectResponse {

        $payment = Payment::where("invoice_id", (int) $invoice_id)->first();

        $request->payment_amount = (float) preg_replace("/[,]/", "", $request->payment_amount); //Remove commas before casting to float

        try {

            if (!$payment) {
                throw new Exception("Whoops.. an unexected error has occurred. Unable to find the necessary payment data.");
            }

            if ($request->payment_status == "3" && (is_nan($request->payment_amount) || $request->payment_amount <= 0)) {
                throw new Exception("Whoops.. Please enter a valid payment amount.");
            }

            if ($request->payment_amount && $request->payment_amount > $payment->due_amount) {
                throw new Exception("Whoops.. You cannot pay more than the due amount ($" . number_format($payment->due_amount, 2) . ")");
            }
        } catch (Exception $ex) {

            $notifications = [
                "message" => $ex->getMessage(),
                "alert-type" => "error"
            ];

            return redirect()->back()->with($notifications);
        }

        //Save new payment data
        $paymentDetails = new PaymentDetail();
        $paymentDetails->invoice_id = $payment->invoice_id;
        $paymentDetails->payment_date = (new DateTime)->format('Y-m-d');
        $paymentDetails->updated_by = Auth::user()->id;

        $payment->status_id = (int) $request->payment_status;

        //Paid in Full
        if ($payment->status_id === 1) {

            //Calculate new paid and due amounts
            $paymentDetails->current_paid_amount = $payment->due_amount;

            $payment->payment_amount = ($payment->payment_amount + $payment->due_amount);
            $payment->due_amount = 0;
        }
        //Partial Payment
        else if ($payment->status_id === 3) {

            $paymentDetails->current_paid_amount = (float) $request->payment_amount;

            $payment->payment_amount = (float) ($payment->payment_amount + (float) $request->payment_amount);
            $payment->due_amount = (float) ($payment->due_amount - (float) $request->payment_amount);
        }

        $payment->save();
        $paymentDetails->save();

        $notifications = [
            "message" => "Invoice Updated",
            "alert-type" => "success"
        ];

        return redirect()->route("customers.credit")->with($notifications);
    }
}
