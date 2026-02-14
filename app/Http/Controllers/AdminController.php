<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        return view(view: 'admin.pages.dashboard');
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
    public function LoginCheck(Request $request)
    {
        // Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Check plain password against hashed password
            if (Hash::check($request->password, $user->password)) {
                // Login the user
                Auth::login($user);

                // Determine redirect based on role
                $redirect = $user->role == 1 ? route('adminhome') : route('dashboard');

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful!',
                    'redirect' => $redirect
                ]);
            } else {
                // Password mismatch
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ]);
            }
        } else {
            // User not found
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ]);
        }
    }
}
