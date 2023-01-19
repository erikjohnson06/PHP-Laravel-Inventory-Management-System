<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{

    /**
     * @return View
     */
    public function viewCustomersAll() : View {

        $data = Customer::latest()->get();

        return view("modules.customers.customers_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewAddCustomer() : View {

        $statuses = CustomerStatus::orderBy("id", "ASC")->get();

        return view("modules.customers.customer_add", [
            "statuses" => $statuses
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewEditCustomer(int $id) : View {

        $entity = Customer::findOrFail($id);
        $statuses = CustomerStatus::orderBy("id", "ASC")->get();

        return view("modules.customers.customer_edit", [
            "data" => $entity,
            "statuses" => $statuses
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addCustomer(Request $request) : RedirectResponse {

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "address" => "required"
        ],[
            "name.required" => "Please Enter a Customer Name",
            "phone.required" => "Please Enter a Phone Number for this Customer",
            "email.required" => "Please Enter an Email Address for this Customer",
            "address.required" => "Please Enter an Address for this Customer"
        ]);

        $img_url = "";

        if ($request->file("image")){

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
    public function deleteCustomer(int $id) : RedirectResponse {

        $entity = Customer::findOrFail($id);

        if ($entity && $entity->image){
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
    public function updateCustomer(Request $request) : RedirectResponse {

        $id = (int) $request->id;

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "address" => "required"
        ],[
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

        if ($request->file("image")){

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
}
