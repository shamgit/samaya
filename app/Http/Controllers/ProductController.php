<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
   
    public function index()
    {
       return view('product.product-master');
    }


    public function store(Request $request)
    {
        $request->validate([
            'Category'      => 'required',
            'product_name'  => 'required',
            'product_code'  => 'required',
            'measure'       => 'required',
            'supplier'      => 'required',
        ]);

        try {

            $imageName = '';

            // ── FIXED: was 'fileInput', dd() shows it comes as 'product_image'
            if ($request->hasFile('product_image')) {

                $image     = $request->file('product_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);
            }

            Product::create([
                'category_id'        => $request->Category,
                'product_image'      => $imageName,
                'product_name'       => $request->product_name,
                'product_code'       => $request->product_code,
                'unit_of_measure'    => $request->measure,
                'product_color'      => $request->product_color,
                'supplier_id'        => $request->supplier,
                'cost_price'         => $request->cost_price,
                'warehouse_location' => $request->location,
                'reorder_level'      => $request->reorder_level,
                'created_by'         => 1,
                'updated_by'         => null,
            ]);

            return redirect()
                ->route('product_master')
                ->with('success', 'Product Saved Successfully');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
   
    public function create()
    {
        return view('product.product-master-add');
    }

    public function getCategory()
    {
        $categories = DB::table('category')
            ->select('category_id', 'category_name')
            ->get();

        return response()->json($categories);
    }

    public function generateProductCode()
    {
        $latestProduct = Product::latest()->first();

        $number = 1;

        if ($latestProduct && $latestProduct->product_code) {

            $code = $latestProduct->product_code;

            preg_match('/PR-(\d+)-(\d+)/', $code, $matches);

            if (isset($matches[1])) {

                $number = (int)$matches[1] + 1;
            }
        }

        $year = date('y');

        $productCode = 'PR-' . str_pad($number, 3, '0', STR_PAD_LEFT) . '-' . $year;

        return response()->json([
            'product_code' => $productCode
        ]);
    }


    public function productList(Request $request)
    {
        $rows = $request->rows ?? 5;

        $query = DB::table('products as p')

            ->leftJoin(
                'category as c',
                'c.category_id',
                '=',
                'p.category_id'
            )

            ->leftJoin(
                'suppliers as s',
                's.supplier_id',
                '=',
                'p.supplier_id'
            )

            ->select(
                'p.*',
                'c.category_name',
                's.supplier_name'
            );

        // Search
        if($request->search != '')
        {
            $query->where(function($q) use ($request){

                $q->where(
                    'p.product_name',
                    'LIKE',
                    '%' . $request->search . '%'
                )

                ->orWhere(
                    'p.product_code',
                    'LIKE',
                    '%' . $request->search . '%'
                );

            });
        }

        // Category Filter
        if($request->category != '')
        {
            $query->where(
                'c.category_name',
                $request->category
            );
        }

        // Status Filter
        if($request->status != '')
        {
            $query->where(
                '0',
                $request->status
            );
        }

        // Sort
        if($request->sort == 'name')
        {
            $query->orderBy(
                'p.product_name',
                'ASC'
            );
        }
        else
        {
            $query->orderBy(
                'p.id',
                'DESC'
            );
        }

        $products = $query->paginate($rows);

        return response()->json($products);
    }

        public function view($id)
    {
        $id = base64_decode($id);
        $product = DB::table('products as p')

            ->leftJoin(
                'category as c',
                'c.category_id',
                '=',
                'p.category_id'
            )

            ->leftJoin(
                'suppliers as s',
                's.supplier_id',
                '=',
                'p.supplier_id'
            )

            ->select(

                'p.id',

                'p.category_id',

                'p.product_image',

                'p.product_name',

                'p.product_code',

                'p.unit_of_measure',

                'p.product_color',

                'p.supplier_id',

                'p.cost_price',

                'p.warehouse_location',

                'p.reorder_level',
                'c.category_name as category_name',

                's.supplier_name as supplier_name'

            )

            ->where('p.id', $id)

            ->first();

        // Check Product
        if(!$product)
        {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Product Not Found'
                );
        }

        return view(
            'product.product-master-view',
            compact('product')
        );
    }

    public function getSuppliers()
    {
        $suppliers = DB::table('suppliers')
            ->select('supplier_id', 'supplier_name')
            ->get();

        return response()->json($suppliers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = base64_decode($id);
        $product = DB::table('products')
            ->where('id', $id)
            ->first();



        $categories = DB::table('category')->get();

        $suppliers = DB::table('suppliers')->get();

        return view(
            'product.product-master-edit',
            compact(
                'id',           // ← ADD THIS
                'product',
                'categories',
                'suppliers'
            )
        );
    }

   
    /**
     * Remove the specified resource from storage.
     */
         public function delete($id)
        {
            $product = Product::find($id);

            if(!$product)
            {
                return response()->json([

                    'status' => false,

                    'message' => 'Product Not Found'

                ]);
            }

            // Delete Image
            if($product->product_image != '')
            {
                $imagePath = public_path(
                    'uploads/products/' .
                    $product->product_image
                );

                if(file_exists($imagePath))
                {
                    unlink($imagePath);
                }
            }

            // Delete Product
            $product->delete();

            return response()->json([

                'status' => true,

                'message' => 'Product Deleted Successfully'

            ]);
        }

    // ── Categories List ───────────────────────────────────────────────────────────
    public function categoriesList()
    {
        $categories = DB::table('category')->get();
        return response()->json($categories);
    }

    // ── Suppliers List ────────────────────────────────────────────────────────────
    public function suppliersList()
    {
        $suppliers = DB::table('suppliers')->get();
        return response()->json($suppliers);
    }

    // ── Show Single Product ───────────────────────────────────────────────────────
    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    // ── Update Product ────────────────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name'  => 'required',
            'Category'      => 'required',
            'measure'       => 'required',
            'supplier'      => 'required',
            'cost_price'    => 'required',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        try {

            $data = [
                'product_name'       => $request->product_name,
                'category_id'        => $request->Category,
                'unit_of_measure'    => $request->measure,
                'product_color'      => $request->product_color,
                'supplier_id'        => $request->supplier,
                'cost_price'         => $request->cost_price,
                'reorder_level'      => $request->reorder_level,
                'warehouse_location' => $request->location,
                'updated_by'         => 1,
            ];

            if ($request->hasFile('product_image')) {
                $image     = $request->file('product_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);
                $data['product_image'] = $imageName;
            }

            DB::table('products')->where('id', $id)->update($data);

            return response()->json(['success' => true, 'message' => 'Product updated successfully']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // GET ALL PRODUCTS
    // ProductController.php

    public function getProducts()
    {
        $products = Product::select('id', 'product_name', 'category', 'color', 'size', 'unit')
                        ->orderBy('product_name', 'ASC')
                        ->get();

        return response()->json([
            'status' => true,
            'data'   => $products
        ]);
    }

    public function getProductDetails($id)
    {
            $product = DB::table('products')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.product_color',
                    'products.unit_of_measure',
                    'category.category_name as category_name'
                )
                ->leftJoin('category', 'category.category_id', '=', 'products.category_id')
                ->where('products.id', $id)
                ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
