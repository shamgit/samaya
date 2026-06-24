<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PurchaseOrderTrackingController extends Controller
{
    
    public function purchase_order_tracking(Request $request)
    {
        return view('PurchaseOrderTracking.purchase_order_tracking');
    }

    public function purchase_order_tracking_view(Request $request)
    {
        return view('PurchaseOrderTracking.purchase_order_tracking_view');
    }

    public function testing_sham_view(Request $request)
    {
        return view('PurchaseOrderTracking.purchase_order_tracking_view');
    }

}
