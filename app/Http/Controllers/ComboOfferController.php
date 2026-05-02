<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ComboOffer;
use App\Models\ComboOfferItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ComboOfferController extends Controller
{
    //
    public function index()
    {
        $products = Product::where('status',1)->get();

        return view('admin.pages.comboproduct', compact('products'));
    }

    public function datatable()
    {
        $combo = ComboOffer::latest()->get();

        return DataTables::of($combo)

            ->addIndexColumn()

            ->addColumn('image', function ($row) {

                return '
                    <img src="'.asset('public/uploads/combo/'.$row->image).'"
                    width="60"
                    height="60"
                    style="object-fit:cover;border-radius:10px;">
                ';
            })

            ->addColumn('status', function ($row) {

                return $row->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('action', function ($row) {

                return '
                    <button class="btn btn-sm btn-primary editBtn"
                        data-id="'.$row->id.'">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button class="btn btn-sm btn-danger deleteBtn"
                        data-id="'.$row->id.'">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })

            ->rawColumns(['image','status','action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'offer_price' => 'required',
            'products' => 'required'
        ]);

        $imageName = null;

        if($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move(public_path('uploads/combo'), $imageName);
        }

        $combo = ComboOffer::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imageName,
            'original_price' => $request->original_price,
            'offer_price' => $request->offer_price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'status' => $request->status
        ]);

        foreach($request->products as $item) {

            ComboOfferItem::create([
                'combo_offer_id' => $combo->id,
                'product_id' => $item['product_id'],
                'weight' => $item['weight'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Combo Offer Added Successfully'
        ]);
    }

    public function edit($id)
    {
        $combo = ComboOffer::with('items')->findOrFail($id);

        return response()->json($combo);
    }

    public function update(Request $request, $id)
    {
        $combo = ComboOffer::findOrFail($id);

        $imageName = $combo->image;

        if($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move(public_path('uploads/combo'), $imageName);
        }

        $combo->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imageName,
            'original_price' => $request->original_price,
            'offer_price' => $request->offer_price,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'status' => $request->status
        ]);

        ComboOfferItem::where('combo_offer_id',$combo->id)->delete();

        foreach($request->products as $item) {

            ComboOfferItem::create([
                'combo_offer_id' => $combo->id,
                'product_id' => $item['product_id'],
                'weight' => $item['weight'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Combo Updated Successfully'
        ]);
    }

    public function destroy($id)
    {
        ComboOfferItem::where('combo_offer_id',$id)->delete();

        ComboOffer::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ]);
    }
}
