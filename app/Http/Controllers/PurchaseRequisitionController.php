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
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseRequisitionController extends Controller
{
    
    public function purchase_requisition(Request $request)
    {
 

        return view('PurchaseRequisition.purchase_requisition');
    }
          
        public function getRequisitionId()
    {
        $id = $this->generateRequisitionId();
        return response()->json(['requisition_id' => $id]);
    }


        private function generateRequisitionId()
    {
        // CURRENT YEAR
        $year = date('Y');

        // GET LAST RECORD
        $latest = PurchaseRequisition::latest()->first();

        if ($latest) {

            // GET LAST 4 DIGITS
            $lastNumber = intval(substr($latest->requisition_id, -4));

            // INCREMENT
            $newNumber = $lastNumber + 1;

        } else {

            // FIRST NUMBER
            $newNumber = 1;
        }

        // MAKE 0001 FORMAT
        $number = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // FINAL ID
        return 'PR-' . $year . '-' . $number;
    }

     public function getDepartments()
    {
        $departments = Department::orderBy('name','ASC')->get();

        return response()->json($departments);
    }


     public function purchase_requisition_view(Request $request)
    {


        return view('PurchaseRequisition.purchase_requisition_view');
    }

     public function purchase_request_approval(Request $request)
    {


        return view('PurchaseRequisition.purchase_request_approval');
    }

     public function purchase_request_approval_view(Request $request)
    {


        return view('PurchaseRequisition.purchase_request_approval_view');
    }

        public function store(Request $request)
        {
            $request->validate([
                'requisition_id' => 'required',
                'department_id'  => 'required',
                'requested_by'   => 'required',
                'request_date'   => 'required',
                'required_date'  => 'required',
                'product_id'     => 'required|array',
                'quantity'       => 'required|array',
                'remarks'        => 'required',
            ]);

            DB::beginTransaction();

            try {

                // Header Save
                $requisition = PurchaseRequisition::create([
                    'requisition_id' => $request->requisition_id,
                    'department_id'  => $request->department_id,
                    'requested'      => $request->requested_by,
                    'request_date'   => date('Y-m-d', strtotime($request->request_date)),
                    'required_date'  => date('Y-m-d', strtotime($request->required_date)),
                    'priority'       => $request->priority,
                    'remarks'        => $request->remarks,
                    'status'         => 'Pending',
                ]);

                // Details Save
                foreach ($request->product_id as $key => $productId) {

                    if (empty($productId)) {
                        continue;
                    }

                    PurchaseRequisitionDetail::create([
                        'purchase_requisition_id' => $requisition->id,
                        'product_id'              => $productId,
                        'category'                => $request->category[$key] ?? null,
                        'color'                   => $request->color[$key] ?? null,
                        'size'                    => $request->size[$key] ?? null,
                        'quantity'                => $request->quantity[$key] ?? 0,
                        'unit'                    => $request->unit[$key] ?? null,
                    ]);
                }

                DB::commit();

                return response()->json([
                    'status'  => true,
                    'message' => 'Purchase Requisition Saved Successfully'
                ]);

            } catch (\Exception $e) {

                DB::rollBack();

                return response()->json([
                    'status'  => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
   
        public function list()
        {

                    $data = PurchaseRequisition::with([
                        'details.product',
                        'department'
                    ])
                    ->latest()
                    ->get();

                   

            return response()->json($data);

        }

   public function view($id)
    {
        $requisition = PurchaseRequisition::with([
                'details.product',
                'department'
            ])
            ->where('requisition_id', $id)
            ->firstOrFail();

        return view(
            'PurchaseRequisition.purchase_requisition_view',
            compact('requisition')
        );
    }
    public function approve(Request $request)
{
    PurchaseRequisition::where('id', $request->id)
        ->update([
            'status' => 'Approved'
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Request Approved Successfully'
    ]);
}


public function reject(Request $request)
{
    PurchaseRequisition::where('id', $request->id)
        ->update([
            'status' => 'Denied'
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Request Rejected Successfully'
    ]);
}


public function delete(Request $request)
{
    $requisition = PurchaseRequisition::where(
        'requisition_id',
        $request->requisition_id
    )->first();

    if($requisition){

        PurchaseRequisitionDetail::where(
            'purchase_requisition_id',
            $requisition->id
        )->delete();

        $requisition->delete();

        return response()->json([
            'status' => true,
            'message' => 'Request Deleted Successfully'
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'Record Not Found'
    ]);
}




public function print($id)
{
    $requisition = PurchaseRequisition::with([
            'details.product',
            'department'
        ])
        ->where('requisition_id', $id)
        ->firstOrFail();

    $pdf = Pdf::loadView(
        'PurchaseRequisition.print',
        compact('requisition')
    );

    return $pdf->stream(
        'Purchase-Requisition-' .
        $requisition->requisition_id .
        '.pdf'
    );
}

public function download($id)
{
    $requisition = PurchaseRequisition::with([
            'details.product',
            'department'
        ])
        ->where('requisition_id', $id)
        ->firstOrFail();

    $pdf = Pdf::loadView(
        'PurchaseRequisition.print',
        compact('requisition')
    );

    return $pdf->download(
        'Purchase-Requisition-' .
        $requisition->requisition_id .
        '.pdf'
    );
}

}