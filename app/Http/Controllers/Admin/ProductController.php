<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductPriceDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    /**
     * Show product list page
     */

    /**
     * Store product (AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $products = Product::with(['category'])->latest();

            return DataTables::of($products)

                ->addColumn('image', function ($row) {
                    return '<img src="'.asset('public/uploads/products/'.$row->image).'" width="50" class="rounded">';
                })

                ->addColumn('category', function ($row) {
                    return $row->category->name ?? '-';
                })

                ->addColumn('price', function ($product) {

                    $weights = json_decode($product->weight); // objects

                    if (!is_array($weights)) {
                        return '-';
                    }

                    return collect($weights)
                        ->map(function ($w) {
                            return $w->weight . 'g - ₹' . $w->price;
                        })
                        ->implode('<br>');
                })

                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-primary editBtn" data-id="'.$row->id.'">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['image', 'price', 'status', 'action'])
                ->make(true);
        }

        return view('admin.products.index');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // 1️⃣ Validate
            $request->validate([
                'name'        => 'required|string|max:255',
                'category_id' => 'required|integer',
                'image'       => 'required|image|mimes:jpg,jpeg,png,webp',
                'quantity'    => 'required|numeric', // KG
                'weights.*.weight' => 'required|string',
                'weights.*.price'  => 'required|numeric',
            ]);

            
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/products'), $imageName);
                $imagePath = $imageName;
            }
            // 3️⃣ Store product
            $product = Product::create([
                'name'        => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'deals'       => $request->deals ?? 0,
                'weight'      => null, // handled in price table
                'quantity'    => $request->quantity, // KG
                'contains'    => $request->contains ? json_encode($request->contains) : null,
                'image'       => $imagePath,
                'status'      => 1,
            ]);

            // 4️⃣ Store weight & price as JSON in products table
                $weightPrices = [];

                if ($request->weights) {
                    foreach ($request->weights as $row) {
                        $weightPrices[] = [
                            'weight' => $row['weight'],
                            'price'  => $row['price'],
                        ];
                    }
                }

                // Save JSON array
                $product->update([
                    'weight' => json_encode($weightPrices),
                ]);

            // 5️⃣ Store gallery images (if you add later)
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $img) {
                    $path = $img->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'images'     => $path,
                        'status'     => 1,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Product added successfully'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

   public function edit($id)
    {
        return Product::findOrFail($id);
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'quantity' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['deals'] = $request->deals ? 1 : 0;
        $data['weight'] = json_encode($request->weights ?? []);
        $data['contains'] = json_encode($request->contains ?? []);

        $product->update($data);

        return response()->json(['success' => true]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
