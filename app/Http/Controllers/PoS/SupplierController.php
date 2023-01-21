<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplierController extends Controller
{

    /**
     * @return View
     */
    public function viewSuppliersAll() : View {

        $data = Supplier::latest()->get();

        return view("modules.suppliers.suppliers_all", [
            "data" => $data
        ]);
    }

    /**
     *
     * @return View
     */
    public function viewAddSupplier() : View {

        $statuses = SupplierStatus::orderBy("id", "ASC")->get();

        return view("modules.suppliers.supplier_add",[
            "statuses" => $statuses
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewEditSupplier(int $id) : View {

        $data = Supplier::findOrFail($id);
        $statuses = SupplierStatus::orderBy("id", "ASC")->get();

        return view("modules.suppliers.supplier_edit", [
            "data" => $data,
            "statuses" => $statuses
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addSupplier(Request $request) : RedirectResponse {

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required"
        ],[
            "name.required" => "Please Enter a Supplier Name",
            "phone.required" => "Please Enter a Phone Number for this Supplier",
            "email.required" => "Please Enter an Email Address for this Supplier"
        ]);

        Supplier::insert([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "status_id" => $request->status_id,
            "created_by" => Auth::user()->id,
            "created_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "New Supplier Added Successfully",
            "alert-type" => "success"
        ];

        return redirect()->route("suppliers.all")->with($notifications);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateSupplier(Request $request) : RedirectResponse {

        $id = (int) $request->id;

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required"
        ],[
            "name.required" => "Please Enter a Supplier Name",
            "phone.required" => "Please Enter a Phone Number for this Supplier",
            "email.required" => "Please Enter a Email Address for this Supplier"
        ]);

        Supplier::findOrFail($id)->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "status_id" => $request->status_id,
            "updated_by" => Auth::user()->id,
            "updated_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "Supplier Updated",
            "alert-type" => "success"
        ];

        return redirect()->route("suppliers.all")->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteSupplier(int $id) : RedirectResponse {

        Supplier::findOrFail($id)->delete();

        $notifications = [
            "message" => "Supplier Deleted ",
            "alert-type" => "success"
        ];

        return redirect()->back()->with($notifications);
    }
}
