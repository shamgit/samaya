<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class InventoryOverviewController extends Controller
{
    
    public function inventory_overview(Request $request)
    {
        $totalProducts = Product::count();
            $lowStockItems = DB::table('purchase_order_items as po')
            ->leftJoin('products as p', 'p.id', '=', 'po.product_id')
            ->select(
            'p.product_name',
            DB::raw('SUM(po.qty) as total_quantity')
            )
            ->groupBy('p.product_name')
            ->havingRaw('SUM(po.qty) > 250')
            ->get();

            $lowStockCount = $lowStockItems->count();

             $query = DB::table('products');

    // Search
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('product_code', 'like', '%' . $request->search . '%')
              ->orWhere('product_name', 'like', '%' . $request->search . '%');
        });
    }

    // Category Filter
    if ($request->category) {
        $query->where('category', $request->category);
    }

    // Status Filter
    if ($request->status == 'In Stock') {
        $query->where('qty', '>', 100);
    }

    if ($request->status == 'Low Stock') {
        $query->whereBetween('qty', [1, 100]);
    }

    if ($request->status == 'Out of Stock') {
        $query->where('qty', 0);
    }

    // Sorting
    if ($request->sort == 'name') {
        $query->orderBy('product_name');
    } else {
        $query->latest();
    }

    $products = $query->paginate(10);

        $categories = DB::table('category')
        ->orderBy('category_name', 'ASC')
        ->get();
        return view('InventoryOverview.inventory_overview', compact('totalProducts','lowStockCount', 'products', 'categories'));
    }


    public function inventoryList()
{
    $products = DB::table('products')
        ->leftJoin('category as c', 'c.category_id', '=', 'products.category_id')
        ->leftJoin('purchase_requisition_details as pr', 'pr.product_id', '=', 'products.id')
        ->select(
            'products.product_code',
            'products.product_name',
            'c.category_name',
            'products.product_color',
            'pr.size',
            'pr.quantity',
            'pr.unit',
            'products.warehouse_location'
        )
        ->get();

    return response()->json($products);
}

}

                                                                                                                                                                