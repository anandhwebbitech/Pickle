<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|digits_between:10,15|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 2,
        ]);
        Auth::login($user);
        return response()->json([
            'message' => 'Account created successfully!'
        ]);
    }
    public function login1(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            return response()->json([
                'status' => true,
                'message' => 'Login successful!',
                'redirect' => route('home') // change if needed
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password'
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // First check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ]);
        }

        // 🚫 Block users with role = 1
        if ($user->role == 1) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ]);
        }

        // Attempt login
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::user();

            // ✅ Merge guest wishlist after login
            if (session()->has('guest_wishlist')) {

                $guestWishlist = session()->get('guest_wishlist', []);
                $userKey = 'wishlist_' . $user->id;

                $userWishlist = session()->get($userKey, []);

                $mergedWishlist = $userWishlist + $guestWishlist;

                session()->put($userKey, $mergedWishlist);
                session()->forget('guest_wishlist');
            }
            // 🔥 MOVE GUEST CART TO DATABASE
            if (session()->has('guest_cart')) {

                $guestCart = session()->get('guest_cart');

                foreach ($guestCart as $item) {

                    $existingCart = Cart::where('user_id', $user->id)
                        ->where('product_id', $item['product_id'])
                        ->where('weight', $item['weight'])
                        ->first();

                    if ($existingCart) {
                        $existingCart->quantity += $item['quantity'];
                        $existingCart->total_amount = $existingCart->quantity * $existingCart->price;
                        $existingCart->save();
                    } else {
                        Cart::create([
                            'user_id'      => $user->id,
                            'product_id'   => $item['product_id'],
                            'category_id'  => $item['category_id'],
                            'quantity'     => $item['quantity'],
                            'weight'       => $item['weight'],
                            'price'        => $item['price'],
                            'discount'     => 0,
                            'total_amount' => $item['price'] * $item['quantity'],
                            'status'       => 1
                        ]);
                    }
                }

                session()->forget('guest_cart');
            }


            return response()->json([
                'status' => true,
                'message' => 'Login successful!',
                'redirect' => route('home')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password'
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'New password and confirm password must match.',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ], 400);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);
    }
    public function logout(Request $request)
    {
        $role = auth()->user()->role ?? null;
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role == 1) {
            return redirect()->route('adminlogin');
        }

        return redirect()->route('home'); // make sure login route exists
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
    protected function authenticated(Request $request, $user)
    {
        if (session()->has('guest_wishlist')) {

            $guestWishlist = session()->get('guest_wishlist', []);
            $userKey = 'wishlist_' . $user->id;

            $userWishlist = session()->get($userKey, []);

            // Merge guest + user wishlist
            $mergedWishlist = $userWishlist + $guestWishlist;

            session()->put($userKey, $mergedWishlist);

            session()->forget('guest_wishlist');
        }
    }
}
