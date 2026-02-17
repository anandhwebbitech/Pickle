<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductPriceDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

                    $image = $row->image;

                    if (str_starts_with($image, '[')) {
                        $images = json_decode($image, true);
                        $image = $images[0] ?? 'default.png';
                    }

                    return '<img src="' . asset('public/uploads/products/' . $image) . '" 
                                width="50" 
                                class="rounded">';
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
                        <button class="btn btn-sm btn-primary editBtn" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '">
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
                'images' => 'required|array|max:2',
                'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
                'quantity'    => 'required|numeric', // KG
                'weights.*.weight' => 'required|string',
                'weights.*.price'  => 'required|numeric',
            ]);


            $imagePaths = [];
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                    $image->move(public_path('uploads/products'), $imageName);

                    $imagePaths[] = $imageName; // store file name in array
                }
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
                'image'       => json_encode($imagePaths),
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
            'name'        => 'required|string|max:255',
            'category_id' => 'required|integer',
            'quantity'    => 'nullable|numeric',
            'description' => 'nullable',
            'images'      => 'nullable|array|max:2',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // ❌ Remove images from validated data
        unset($data['images']);

        // ✅ Handle Images
        if ($request->hasFile('images')) {

            // Delete old images
            if ($product->image) {
                $oldImages = json_decode($product->image, true);

                if (is_array($oldImages)) {
                    foreach ($oldImages as $old) {
                        $oldPath = public_path('uploads/products/' . $old);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }
            }

            $imagePaths = [];

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('uploads/products'), $imageName);
                $imagePaths[] = $imageName;
            }

            $data['image'] = json_encode($imagePaths);
        }

        $data['deals'] = $request->deals ? 1 : 0;
        $data['weight'] = json_encode($request->weights ?? []);
        $data['contains'] = json_encode($request->contains ?? []);

        $product->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully'
        ]);
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
    public function Orders(Request $request)
    {
        if ($request->ajax()) {

            $products = Order::with(['category', 'product'])->latest();
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('orderid', function ($row) {
                    return 'ORD-' . $row->id;
                })
                ->addColumn('product_name', function ($row) {
                    return $row->product->name;
                })
                // ->addColumn('image', function ($row) {
                //     return '<img src="' . asset('public/uploads/products/' . $row->product->image) . '" width="50" class="rounded">';
                // })
                ->addColumn('image', function ($row) {

                    $image = $row->product->image;

                    if (str_starts_with($image, '[')) {
                        $images = json_decode($image, true);
                        $image = $images[0] ?? 'default.png';
                    }

                    return '<img src="' . asset('public/uploads/products/' . $image) . '" 
                                width="50" 
                                class="rounded">';
                })

                ->addColumn('category', function ($row) {

                    return $row->product->category->name ?? '-';
                })

                ->addColumn('price', function ($row) {

                    return $row->price;
                })
                ->addColumn('coupon', function ($row) {

                    return $row->coupon_code ?? '-';
                })
                ->addColumn('order_date', function ($row) {

                    return $row->order_date;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 2) {
                        return '<span class="badge bg-success">Delivered</span>';
                    } elseif ($row->status == 0) {
                        return '<span class="badge bg-warning">Pending</span>';
                    } elseif ($row->status == 1) {
                        return '<span class="badge bg-info">Order Confirm</span>';
                    } elseif ($row->status == 4) {
                        return '<span class="badge bg-danger">Returned</span>';
                    } else {
                        return '<span class="badge bg-danger">Cancelled</span>';
                    }
                })

                ->addColumn('action', function ($row) {

                    $deliverBtn = '';
                    if (in_array($row->status, [0, 1, 4])) {
                        $deliverBtn = '
                            <button class="btn btn-sm btn-success deliverBtn"
                                    data-id="' . $row->id . '"
                                    data-price="' . $row->price . '">
                                <i class="fa fa-truck"></i>
                            </button>
                        ';
                    }
                    $viewBtn = '
                        <button class="btn btn-sm btn-info viewBtn"
                                data-id="' . $row->id . '">
                            <i class="fa fa-eye"></i>
                        </button>
                    ';

                    return $deliverBtn . ' ' . $viewBtn;
                })

                ->rawColumns(['image', 'price', 'status', 'action'])
                ->make(true);
        }
    }
    public function Payments(Request $request)
    {
        if ($request->ajax()) {

            $products = PaymentDetail::with(['order'])->latest();
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('order_id', function ($row) {
                    $ids = json_decode($row->order_id, true);

                    if (is_array($ids)) {
                        return collect($ids)->map(function ($id) {
                            return 'ORD-' . $id;
                        })->implode(', ');
                    }

                    return 'ORD-' . $row->order_id;
                })
                ->addColumn('product_name', function ($row) {
                    $ids = json_decode($row->order_id, true);
                    if (is_array($ids)) {
                        return collect($ids)->map(function ($id) {
                            $order = Order::find($id);
                            return $order->product->name;
                        })->implode(', ');
                    }

                    return $row->order->product->name ?? '-';
                })
                ->addColumn('payment_id', function ($row) {

                    return $row->payment_id;
                })
                ->addColumn('payment_method', function ($row) {

                    return $row->payment_method ?? 'COD';
                })
                ->addColumn('amount', function ($row) {

                    return $row->amount;
                })
                ->addColumn('status', function ($row) {
                    if ($row->payment_status == 2) {
                        return '<span class="badge bg-danger">Failed</span>';
                    } elseif ($row->payment_status == 0) {
                        return '<span class="badge bg-warning">Pending</span>';
                    } elseif ($row->payment_status == 1) {
                        return '<span class="badge bg-success">Success</span>';
                    } else {
                        return '<span class="badge bg-danger">Pending</span>';
                    }
                })
                ->rawColumns(['amount', 'status'])
                ->make(true);
        }
    }
    public function DashboardOrders(Request $request)
    {
        if ($request->ajax()) {

            $products = Order::with(['category', 'product'])
                ->whereDate('delivery_date', '>=', Carbon::today())
                ->whereDate('delivery_date', '<=', Carbon::tomorrow())
                ->whereNotIn('status', [3, 4])
                ->latest();
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('orderid', function ($row) {
                    return 'ORD-' . $row->id;
                })
                ->addColumn('product_name', function ($row) {
                    return $row->product->name;
                })
                // ->addColumn('image', function ($row) {
                //     return '<img src="' . asset('public/uploads/products/' . $row->product->image) . '" width="50" class="rounded">';
                // })
                ->addColumn('image', function ($row) {

                    $image = $row->product->image;

                    if (str_starts_with($image, '[')) {
                        $images = json_decode($image, true);
                        $image = $images[0] ?? 'default.png';
                    }

                    return '<img src="' . asset('public/uploads/products/' . $image) . '" 
                                width="50" 
                                class="rounded">';
                })
                ->addColumn('price', function ($row) {

                    return $row->price;
                })
                ->addColumn('delivery_date', function ($row) {

                    return $row->delivery_date;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 2) {
                        return '<span class="badge bg-success">Delivered</span>';
                    } elseif ($row->status == 0) {
                        return '<span class="badge bg-warning">Pending</span>';
                    } elseif ($row->status == 1) {
                        return '<span class="badge bg-info">Order Confirm</span>';
                    } elseif ($row->status == 4) {
                        return '<span class="badge bg-danger">Returned</span>';
                    } else {
                        return '<span class="badge bg-danger">Cancelled</span>';
                    }
                })
                ->rawColumns(['image', 'price', 'status'])
                ->make(true);
        }
    }

    public function updateDelivery(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|string'
        ]);

        $updated = Order::where('id', $id)->update([
            'status' => $request->status
        ]);

        if ($updated) {
            // Store payment details
            $payment = PaymentDetail::create([
                'order_id'          => $id,
                'payment_id'        => 'PAY_COD_' . time(),
                'razorpay_order_id' => 'order_COD',
                'signature'         => null,
                'payment_method'    => 'COD',
                'amount'            => $request->amount,
                'payment_status'    => 1,
                'status'            => $request->status,
            ]);
            if (!$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment Failed'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Order status updated successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Order not found'
        ]);
    }
    public function viewOrder($id)
    {
        $order = Order::with('user', 'product', 'address')
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $order
        ]);
    }
}
