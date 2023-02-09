<?php

namespace App\Http\Controllers\PoS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller {

    /**
     * @return View
     */
    public function viewStockStatusReport(): View {

        $data = Product::orderBy('supplier_id', 'ASC')
                ->orderBy('category_id', 'ASC')
                ->where("status_id", 1)
                ->get();

        return view("modules.stock.stock_status", [
            "data" => $data
        ]);
    }

    /**
     * @return View
     */
    public function viewStockStatusPDF(): View {

        $data = Product::orderBy('supplier_id', 'ASC')
                ->orderBy('category_id', 'ASC')
                ->where("status_id", 1)
                ->get();

        $date = new DateTime('now', new DateTimeZone('America/New_York'));

        return view("modules.pdf.stock_status_pdf", [
            "data" => $data,
            "date" => $date
        ]);
    }

    /**
     * @return View
     */
    public function viewStockSupplierReport(): View {

        $suppliers = Supplier::all();
        $categories = Category::all();

        return view("modules.stock.supplier_product_report", [
            "suppliers" => $suppliers,
            "categories" => $categories
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function viewSupplierReportPDF(Request $request): View {

        $data = Product::orderBy('supplier_id', 'ASC')
                ->orderBy('category_id', 'ASC')
                ->where("supplier_id", (int) $request->supplier_id)
                ->get();

        $date = new DateTime('now', new DateTimeZone('America/New_York'));

        return view("modules.pdf.supplier_report_pdf", [
            "data" => $data,
            "date" => $date
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function viewProductReportPDF(Request $request): View {

        $data = Product::where("category_id", (int) $request->category_id)
                ->where("id", (int) $request->product_id)
                ->first();

        $date = new DateTime('now', new DateTimeZone('America/New_York'));

        return view("modules.pdf.product_report_pdf", [
            "data" => $data,
            "date" => $date
        ]);
    }
}
