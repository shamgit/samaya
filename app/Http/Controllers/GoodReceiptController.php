<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class GoodReceiptController extends Controller
{
    
    public function goods_receipt(Request $request)
    {
            

        return view('GoodReceipt.goods_receipt');
    }

        public function getPurchaseOrders()
        {
                $purchaseOrders = DB::table('purchase_order')
                        ->leftJoin('purchase_order_items as poi', 'poi.po_id', '=', 'purchase_order.id')
                        ->leftJoin('products', 'products.id', '=', 'poi.product_id')
                        ->leftJoin('suppliers as sup', 'sup.supplier_id', '=', 'purchase_order.supplier_id')
                        ->select(
                            'purchase_order.po_no',
                            'purchase_order.delivery_date',
                            'purchase_order.delivery_location',
                            'purchase_order.aproval_status',
                            'poi.qty',
                            'products.product_name',
                            'sup.supplier_name'
                        )
                        ->get();

            return response()->json($purchaseOrders);
        }
     public function goods_receipt_view(Request $request)
    {


        return view('GoodReceipt.goods_receipt_view');
    }

}