<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * @return View
     */
    public function viewCategoriesAll() : View {

        $data = Category::latest()->get();

        return view("modules.categories.categories_all", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewAddCategory() : View {

        $statuses = CategoryStatus::orderBy("id", "ASC")->get();

        return view("modules.categories.category_add", [
            "statuses" => $statuses
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewEditCategory(int $id) : View {

        $data = Category::findOrFail($id);
        $statuses = CategoryStatus::orderBy("id", "ASC")->get();

        return view("modules.categories.category_edit", [
            "data" => $data,
            "statuses" => $statuses
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addCategory(Request $request) : RedirectResponse {

        $request->validate([
            "name" => "required"
        ],[
            "name.required" => "Please Enter a Unit Name"
        ]);

        Category::insert([
            "name" => $request->name,
            "status_id" => $request->status_id,
            "created_by" => Auth::user()->id,
            "created_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "New Category Added",
            "alert-type" => "success"
        ];

        return redirect()->route("categories.all")->with($notifications);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCategory(Request $request) : RedirectResponse {

        $id = (int) $request->id;

        $request->validate([
            "name" => "required"
        ],[
            "name.required" => "Please Enter a Category Name"
        ]);

        Category::findOrFail($id)->update([
            "name" => $request->name,
            "status_id" => $request->status_id,
            "updated_by" => Auth::user()->id,
            "updated_at" => Carbon::now()
        ]);

        $notifications = [
            "message" => "Category Updated",
            "alert-type" => "success"
        ];

        return redirect()->route("categories.all")->with($notifications);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteCategory(int $id) : RedirectResponse {

        Category::findOrFail($id)->delete();

        $notifications = [
            "message" => "Category Deleted ",
            "alert-type" => "success"
        ];

        return redirect()->back()->with($notifications);
    }
}
