<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\PurchaseRequisition;
use App\Models\Department;
use App\Models\Product;     
use App\Models\PurchaseRequisitionDetail;
use DB;


class PurchaseOrderController extends Controller
{


    public function index()
    {
        $requisitions = DB::table('purchase_requisitions as pr')
        ->leftJoin('departments as d', 'd.department_id', '=', 'pr.department_id')
        ->leftJoin('purchase_requisition_details as prd', 'prd.purchase_requisition_id', '=', 'pr.id')
        ->leftJoin('products as p', 'p.id', '=', 'prd.product_id')
        ->leftJoin('purchase_order as po', 'po.purchase_requisition_id', '=', 'pr.id')
        ->select([
        'pr.id',
        'pr.requisition_id',
        'pr.department_id',
        'pr.requested',
        'pr.request_date',
        'pr.required_date',
        'pr.priority',
        'pr.remarks',
        'pr.status',
        'pr.created_at',
        'd.name as department_name',

        DB::raw('COUNT(prd.id) as total_products'),

        DB::raw("
            GROUP_CONCAT(
                DISTINCT p.product_name
                SEPARATOR ', '
            ) as product_names
        "),

        DB::raw('COALESCE(MAX(po.id), 0) as po_id'),

        DB::raw("
            COALESCE(
                CASE MAX(po.status)
                    WHEN 'created' THEN 'Created'
                    WHEN 'sent' THEN 'sent'
                    WHEN 'approved' THEN 'Approved'
                    WHEN 'rejected' THEN 'Rejected'
                    WHEN 'completed' THEN 'Completed'
                    ELSE MAX(po.status)
                END,
                'Pending'
            ) as po_status
        "),
        ])
        ->groupBy([
        'pr.id',
        'pr.requisition_id',
        'pr.department_id',
        'pr.requested',
        'pr.request_date',
        'pr.required_date',
        'pr.priority',
        'pr.remarks',
        'pr.status',
        'pr.created_at',
        'd.name',
        ])
        ->orderBy('pr.created_at', 'DESC')
        ->get();

                    

        return view('PurchaseOrder.purchase_order', compact('requisitions'));
    }
    

        // CREATE PO PAGE
  public function create($id)
{
    $requisition = DB::table('purchase_requisitions')
        ->where('id', $id)
        ->first();

    $products = DB::table('purchase_requisition_details')
        ->leftJoin(
            'products',
            'products.id',
            '=',
            'purchase_requisition_details.product_id'
        )
        ->where(
            'purchase_requisition_details.purchase_requisition_id',
            $id
        )
        ->select(
            'purchase_requisition_details.*',
            'products.product_name',
            'products.product_code',
            'products.unit_of_measure'
        )
        ->get();

         $suppliers = DB::table('suppliers')
        ->select(
            'supplier_id',
            'supplier_name'
        )
        ->orderBy('supplier_name')
        ->get();

    $year = date('Y');
    $month = date('m');
          // Get Last PO
    $lastPO = DB::table('purchase_order')
        ->orderBy('id','DESC')
        ->first();

    if($lastPO){

        $lastNumber = (int) substr($lastPO->po_no, -4 );
        $nextNumber =str_pad($lastNumber + 1, 4,'0',STR_PAD_LEFT);
    }else{
         $nextNumber='0001';
    }
    $poNumber ='PO-'.$year .'-'.$month.'-'.$nextNumber;

  return view('PurchaseOrder.create_purchase_order', compact('requisition', 'products', 'suppliers', 'poNumber'));
        }

        public function getSupplierCategory($id)
        {
            $supplier = DB::table('suppliers')

                ->leftJoin(
                    'category as c',
                    'c.category_id',
                    '=',
                    'suppliers.category_id'
                )

                ->select(
                    'c.category_name'
                )

                ->where(
                    'suppliers.supplier_id',
                    $id
                )

                ->first();


            if(!$supplier){

                return response()->json([

                    'status' => false

                ]);

            }


            return response()->json([

                'status' => true,

                'category' => $supplier->category_name

            ]);
        }


  public function purchase_order(Request $request)
{
   $requisitions = DB::table('purchase_requisitions as pr')
    ->leftJoin('departments as d', 'd.department_id', '=', 'pr.department_id')
    ->leftJoin('purchase_requisition_details as prd', 'prd.purchase_requisition_id', '=', 'pr.id')
    ->leftJoin('products as p', 'p.id', '=', 'prd.product_id')
    ->leftJoin('purchase_order as po', 'po.purchase_requisition_id', '=', 'pr.id')
    ->select([
        'pr.id',
        'pr.requisition_id',
        'pr.department_id',
        'pr.requested',
        'pr.request_date',
        'pr.required_date',
        'pr.priority',
        'pr.remarks',
        'pr.status',
        'pr.created_at',
        'd.name as department_name',

        DB::raw('COUNT(prd.id) as total_products'),

        DB::raw("
            GROUP_CONCAT(
                DISTINCT p.product_name
                SEPARATOR ', '
            ) as product_names
        "),

        DB::raw('COALESCE(MAX(po.id), 0) as po_id'),

        DB::raw("
            COALESCE(
                CASE MAX(po.status)
                    WHEN 'created' THEN 'Created'
                    WHEN 'sent' THEN 'sent'
                    WHEN 'approved' THEN 'Approved'
                    WHEN 'rejected' THEN 'Rejected'
                    WHEN 'completed' THEN 'Completed'
                    ELSE MAX(po.status)
                END,
                'Pending'
            ) as po_status
        "),
    ])
    ->groupBy([
        'pr.id',
        'pr.requisition_id',
        'pr.department_id',
        'pr.requested',
        'pr.request_date',
        'pr.required_date',
        'pr.priority',
        'pr.remarks',
        'pr.status',
        'pr.created_at',
        'd.name',
    ])
    ->orderBy('pr.created_at', 'DESC')
    ->get();

    return view('PurchaseOrder.purchase_order', compact('requisitions'));
}

    public function purchase_order_approval(Request $request)
{
    $purchaseOrders = DB::table('purchase_order as po')
        ->leftJoin('suppliers as s', 's.supplier_id', '=', 'po.supplier_id')
        ->leftJoin('purchase_requisitions as pr', 'pr.id', '=', 'po.purchase_requisition_id')
        ->leftJoin('departments as d', 'd.department_id', '=', 'pr.department_id')
        ->select([
            'po.id',
            'po.po_no',
            'po.po_date',
            'po.delivery_date',
            'po.total_amount',
            'po.status',
            DB::raw("CASE WHEN po.aproval_status IS NULL
                     OR po.aproval_status = ''
                     THEN 'pending'
                     ELSE po.aproval_status
                     END as aproval_status"),
            's.supplier_name',
            'pr.requisition_id',
            'pr.requested',
            'pr.priority',
            'd.name as department_name'
        ])
        ->orderBy('po.created_at', 'DESC')
        ->paginate(10);


    return view(
        'PurchaseOrder.purchase_order_approval',
        compact('purchaseOrders')
    );
}
  
public function approval_view($id)
{
        $po = DB::table('purchase_order as po')
        ->leftJoin('suppliers as s', 's.supplier_id', '=', 'po.supplier_id')
        ->leftJoin('purchase_requisitions as pr', 'pr.id', '=', 'po.purchase_requisition_id')
        ->leftJoin('departments as d', 'd.department_id', '=', 'pr.department_id')
        ->select([
            'po.id',
            'po.po_no',
            'po.po_date',
            'po.delivery_date',
            'po.delivery_location',
            'po.payment_terms',
            'po.notes',
            'po.subtotal',
            'po.gst_rate',
            'po.gst_amount',
            'po.total_amount',
            'po.attachment',
            'po.status',
            'po.supplier_id',
            'po.purchase_requisition_id',

            DB::raw("
                CASE
                    WHEN po.aproval_status IS NULL
                        OR po.aproval_status = ''
                    THEN 'Pending'
                    ELSE po.aproval_status
                END as aproval_status
            "),

            's.supplier_name',
            'pr.requisition_id',
            'pr.requested',
            'pr.priority',
            'd.name as department_name'
        ])
        ->where('po.id', $id)
        ->first();
 
    if (!$po) {
        abort(404, 'Purchase Order not found.');
    }
 
    $poItems = DB::table('purchase_order_items as poi')
        ->leftJoin('products as p', 'p.id', '=', 'poi.product_id')
        ->where('poi.po_id', $id)
        ->select([
            'poi.product_id',
            'poi.qty',
            'poi.unit_price',
            'poi.total',
            'p.product_name',
            'p.unit_of_measure',
        ])
        ->get();
 
    return view('PurchaseOrder.purchase_order_approval_view', compact('po', 'poItems'));
}

    public function view($id)
{


        $po = DB::table('purchase_order as po')
            ->leftJoin('suppliers as s', 's.supplier_id', '=', 'po.supplier_id')
            ->select([
                'po.*',
                's.supplier_name'
            ])
            ->where('po.id', $id)
            ->first();

            $items = DB::table('purchase_order_items as poi')
                    ->leftJoin('products as p', 'p.id', '=', 'poi.product_id')
                    ->leftJoin('purchase_requisition_details as prd', function ($join) {
                    $join->on('prd.product_id', '=', 'poi.product_id');
                    })
                    ->select([
                    'poi.*',
                    'p.product_name',
                    'prd.category',
                    'prd.color',
                    'prd.size',
                    'prd.unit'
                    ])
                    ->where('poi.po_id', $id)
                    ->get();

    return view('PurchaseOrder.purchase_order_view', compact('po', 'items'));
}

    public function getProductlist($id)
{
    $data = DB::table(
        'purchase_requisition_details as prd'
    )

    ->leftJoin(
        'products as p',
        'p.id',
        '=',
        'prd.product_id'
    )

    ->select(
        'prd.product_id',
        'p.product_name',

        'prd.category',

        'prd.color',

        'prd.size',

        'prd.quantity',

        'prd.unit',
        'p.cost_price'

    )

    ->where(

        'prd.purchase_requisition_id',

        $id

    )

    ->get();


    return response()->json(

        $data

    );
}


public function store(Request $request)
{


    // ── 1. Decode products JSON string → array ──
    $products = json_decode($request->products, true);

    if (!$products || !is_array($products)) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid products data.'
        ], 422);
    }

    // ── 2. Sanitize undefined string values ──
    $deliveryLocation = ($request->delivery_location === 'undefined' || empty($request->delivery_location))
        ? null
        : $request->delivery_location;

    // ── 3. Convert date format "04 Jun 2026" → "2026-06-04" ──
    $poDate       = null;
    $deliveryDate = null;

    try {
        if ($request->po_date) {
            $poDate = \Carbon\Carbon::createFromFormat('d M Y', $request->po_date)->format('Y-m-d');
        }
        if ($request->delivery_date) {
            $deliveryDate = \Carbon\Carbon::createFromFormat('d M Y', $request->delivery_date)->format('Y-m-d');
        }
    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid date format: ' . $e->getMessage()
        ], 422);
    }

    // ── 4. Validate ──
    $request->validate([
        'supplier_id'   => 'required',
        'po_number'     => 'required',
        'po_date'       => 'required',
        'gst_rate'      => 'nullable|numeric',
        'subtotal'      => 'nullable|numeric',
        'gst_amount'    => 'nullable|numeric',
        'total_amount'  => 'nullable|numeric',
    ]);

    DB::beginTransaction();

    try {

        // ── 5. Handle file upload first ──
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('po_attachments', 'public');
        }

        // ── 6. Save PO Header ──
            $poId = DB::table('purchase_order')->insertGetId([
                'supplier_id'             => $request->supplier_id,
                'purchase_requisition_id' => $request->requisition_id ?? null,
                'po_no'                   => $request->po_number,
                'po_date'                 => $poDate,
                'delivery_date'           => $deliveryDate,
                'delivery_location'       => $deliveryLocation,
                'payment_terms'           => $request->payment_terms,
                'notes'                   => $request->notes,
                'gst_rate'                => $request->gst_rate   ?? 0,
                'subtotal'                => $request->subtotal   ?? 0,
                'gst_amount'              => $request->gst_amount ?? 0,
                'total_amount'            => $request->total_amount ?? 0,
                'attachment'              => $attachmentPath,
                'status'                  => 'created',
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

        // ── 7. Save PO Items ──
        foreach ($products as $product) {
            DB::table('purchase_order_items')->insert([
                'po_id'      => $poId,
                'product_id' => $product['product_id'] ?? null,
                'qty'        => $product['qty']        ?? 0,
                'unit_price' => $product['unit_price'] ?? 0,
                'total'      => $product['total']      ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Purchase Order created successfully.',
            'po_id'   => $poId
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => false,
            'message' => 'Failed: ' . $e->getMessage()
        ], 500);
    }
}
public function edit_purchase($id)
{

    $po = DB::table('purchase_order as po')
        ->leftJoin('suppliers as s', 's.supplier_id', '=', 'po.supplier_id')
        ->leftJoin('purchase_requisitions as pr', 'pr.id', '=', 'po.purchase_requisition_id')
        ->where('pr.id', $id)
        ->select([
            'po.*',
            's.supplier_name',
        ])
        ->first();
      

    if (!$po) {
        abort(404, 'Purchase Order not found.');
    }

        $poItems = DB::table('purchase_order_items as poi')
            ->leftJoin('products as p',
                'p.id', '=', 'poi.product_id')
            ->leftJoin('purchase_order as po',
                'po.id', '=', 'poi.po_id')
            ->leftJoin('purchase_requisitions as pr',
                'pr.id', '=', 'po.purchase_requisition_id')
            ->leftJoin('purchase_requisition_details as prd', function ($join) {
                $join->on('prd.product_id',              '=', 'poi.product_id')
                    ->on('prd.purchase_requisition_id', '=', 'pr.id');
            })
            ->where('poi.po_id',$po->id)
            ->select([
                'poi.product_id',
                'poi.po_id',
                'poi.qty',
                'poi.total',
                'p.product_name',
                'p.product_color',
                'p.cost_price',
                'p.unit_of_measure',
                'prd.color',
                'prd.size',
                'prd.quantity as requested_qty',
            ])
            ->get();

          

    $suppliers = DB::table('suppliers')
                ->select('supplier_id','supplier_name')
                ->orderBy('supplier_name','ASC')
                ->get();

    $requisition = DB::table('purchase_requisitions')
        ->where('id', $po->purchase_requisition_id)
        ->first();

    return view(
        'PurchaseOrder.purchase_order_edit',
        compact(
            'po',
            'poItems',
            'suppliers',
            'requisition'
        )
    );
}

public function update(Request $request, $id)
{
    $products = json_decode($request->products, true);

    // ── Convert date format "05 Jun 2026" → "2026-06-05" ──
    $poDate       = null;
    $deliveryDate = null;

    try {
        if ($request->po_date && $request->po_date !== '') {
            $poDate = \Carbon\Carbon::createFromFormat('d M Y', trim($request->po_date))->format('Y-m-d');
        }
        if ($request->delivery_date && $request->delivery_date !== '') {
            $deliveryDate = \Carbon\Carbon::createFromFormat('d M Y', trim($request->delivery_date))->format('Y-m-d');
        }
    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid date format: ' . $e->getMessage()
        ], 422);
    }

    // ── Sanitize delivery location ──
    $deliveryLocation = ($request->delivery_location === 'undefined' || empty($request->delivery_location))
        ? null
        : $request->delivery_location;

    DB::beginTransaction();
    try {

        // ── Handle file upload ──
        $attachmentPath = DB::table('purchase_order')
            ->where('id', $id)
            ->value('attachment');

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('po_attachments', 'public');
        }

        // ── Update PO header ──
        DB::table('purchase_order')->where('id', $id)->update([
            'supplier_id'             => (int) $request->supplier_id,
            'purchase_requisition_id' => (int) $request->requisition_id ?: null,
            'po_no'                   => $request->po_number,
            'po_date'                 => $poDate,           // ← converted date
            'delivery_date'           => $deliveryDate,     // ← converted date
            'delivery_location'       => $deliveryLocation,
            'payment_terms'           => $request->payment_terms,
            'notes'                   => $request->notes,
            'gst_rate'                => $request->gst_rate    ?? 0,
            'subtotal'                => $request->subtotal    ?? 0,
            'gst_amount'              => $request->gst_amount  ?? 0,
            'total_amount'            => $request->total_amount ?? 0,
            'attachment'              => $attachmentPath,
            'updated_at'              => now(),
        ]);

        // ── Delete old items and re-insert ──
        DB::table('purchase_order_items')->where('po_id', $id)->delete();

        foreach ($products as $product) {
            DB::table('purchase_order_items')->insert([
                'po_id'      => $id,
                'product_id' => $product['product_id'] ?? null,
                'qty'        => $product['qty']        ?? 0,
                'unit_price' => $product['unit_price'] ?? 0,
                'total'      => $product['total']      ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Purchase Order updated successfully.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
        ], 500);
    }
}



public function sendPO($id)
{
    $updated = DB::table('purchase_order')
        ->where('id', $id)
        ->update([
            'status' => 'sent',
            'updated_at' => now()
        ]);

    if ($updated) {
        return response()->json([
            'status' => true,
            'message' => 'PO sent successfully.'
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'PO not found.'
    ]);
}

public function approvePO($id)
{
    $updated = DB::table('purchase_order')
        ->where('id', $id)
        ->update([
            'aproval_status' => 'Approved',
            'updated_at' => now()
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Purchase Order Approved Successfully'
    ]);
}

public function rejectPO($id)
{
    $updated = DB::table('purchase_order')
        ->where('id', $id)
        ->update([
            'aproval_status' => 'Rejected',
            'updated_at' => now()
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Purchase Order Rejected Successfully'
    ]);
}


}
