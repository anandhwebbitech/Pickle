<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CouponController extends Controller
{
    //
    public function datatable()
    {
        $coupons = Coupon::latest()->get();

        return response()->json([
            'data' => $coupons->map(function ($coupon) {
                return [
                    'id'     => $coupon->id,
                    'code'   => $coupon->code,
                    'type'   => $coupon->type == 1 ? 'Percentage' : 'Amount',
                    'value'  => $coupon->value,
                    'status' => $coupon->status == 1
                        ? '<span class="badge-active">Active</span>'
                        : '<span class="badge-inactive">Inactive</span>',
                    'action' => '
                        <button class="btn btn-sm btn-primary editBtn" data-id="'.$coupon->id.'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$coupon->id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    '
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'   => 'required|string|max:255|unique:coupons,code',
            'type'   => 'required|in:percentage,amount',
            'value'  => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        Coupon::create([
            'code'   => strtoupper($request->code),
            'type'   => $request->type === 'percentage' ? 1 : 0, // 1 = %, 0 = amount
            'value'  => $request->value,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon added successfully!'
        ], 201);
    }

    public function edit($id)
{
    return response()->json(
        Coupon::findOrFail($id)
    );
}

public function update(Request $request, $id)
{
    $request->validate([
        'code'   => 'required|string|max:255|unique:coupons,code,' . $id,
        'type'   => 'required|in:percentage,amount',
        'value'  => 'required|integer|min:1',
        'status' => 'required|boolean',
    ]);

    $coupon = Coupon::findOrFail($id);

    $coupon->update([
        'code'   => strtoupper($request->code),
        'type'   => $request->type === 'percentage' ? 1 : 0,
        'value'  => $request->value,
        'status' => $request->status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Coupon updated successfully'
    ]);
}

public function destroy($id)
{
    Coupon::findOrFail($id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Coupon deleted successfully'
    ]);
}
}
