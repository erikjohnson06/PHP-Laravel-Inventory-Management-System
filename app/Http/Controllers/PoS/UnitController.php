<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UnitController extends Controller {

    /**
     * @return View
     */
    public function viewUnitsAll(): View {

        $data = Unit::latest()->get();

        return view("modules.units.units_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewAddUnit(): View {

        return view("modules.units.unit_add");
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewEditUnit(int $id): View {

        $data = Unit::findOrFail($id);

        return view("modules.units.unit_edit", [
            "data" => $data
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addUnit(Request $request): RedirectResponse {

        $request->validate([
            "name" => "required"
                ], [
            "name.required" => "Please Enter a Unit Name"
        ]);

        Unit::insert([
            "name" => $request->name,
            "status" => 1,
            "created_by" => Auth::user()->id,
            "created_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "New Unit Added",
            "alert-type" => "success"
        ];

        return redirect()->route("units.all")->with($notifications);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateUnit(Request $request): RedirectResponse {

        $id = (int) $request->id;

        $request->validate([
            "name" => "required"
                ], [
            "name.required" => "Please Enter a Unit Name"
        ]);

        Unit::findOrFail($id)->update([
            "name" => $request->name,
            "updated_by" => Auth::user()->id,
            "updated_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "Unit Updated",
            "alert-type" => "success"
        ];

        return redirect()->route("units.all")->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteUnit(int $id): RedirectResponse {

        Unit::findOrFail($id)->delete();

        $notifications = [
            "message" => "Unit Deleted ",
            "alert-type" => "success"
        ];

        return redirect()->back()->with($notifications);
    }
}
