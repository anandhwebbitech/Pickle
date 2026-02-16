<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    //
    public function Login()
    {
        return view(view: 'admin.layouts.login');
    }
    public function Dashboard()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $coupon = Coupon::where('status', 1)->count();

        $ordersCount = Order::whereNotIn('status', [2, 3, 4])->count();

        return view('admin.pages.dashboard', compact(
            'productCount',
            'categoryCount',
            'coupon',
            'ordersCount'
        ));
    }
    public function Product()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.pages.product', compact('categories'));
    }
    public function Categories()
    {
        return view('admin.pages.categories');
    }
    public function Coupon()
    {
        return view('admin.pages.coupon-code');
    }

    public function OrderList()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.pages.orderlist', compact('categories'));
    }
    public function PaymentList()
    {
        return view('admin.pages.payment-list');
    }
    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            // Get the authenticated user
            $user = Auth::user();

            // Check role
            if ($user->role == 1) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('adminhome') // Admin dashboard
                ]);
            } else {
                // Logout if role is not admin (optional)
                Auth::logout();
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to access this page.'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password'
        ]);
    }
}
