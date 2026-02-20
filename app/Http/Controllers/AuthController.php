<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     // First check if user exists
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid email or password'
    //         ]);
    //     }

    //     // 🚫 Block users with role = 1
    //     if ($user->role == 1) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid email or password'
    //         ]);
    //     }


    //     // ✅ Generate OTP
    //     $otp = rand(100000, 999999);
    //     $user->update([
    //         'otp' => $otp,
    //         'otp_expires_at' => Carbon::now()->addMinutes(5)
    //     ]);

    //     // ✅ Send OTP Mail
    //     // Mail::send('frontend.pages.otp_email', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
    //     //     $message->to($user->email)
    //     //         ->subject('Your Login OTP');
    //     // });
    //     Mail::send('frontend.pages.otp_email', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
    //         $message->to($user->email)
    //             ->subject('Your Login OTP')
    //             ->from($user->email, $user->name);
    //     });



    //     // Attempt login
    //     if (Auth::attempt([
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ])) {
    //         $user = Auth::user();

    //         // ✅ Merge guest wishlist after login
    //         if (session()->has('guest_wishlist')) {

    //             $guestWishlist = session()->get('guest_wishlist', []);
    //             $userKey = 'wishlist_' . $user->id;

    //             $userWishlist = session()->get($userKey, []);

    //             $mergedWishlist = $userWishlist + $guestWishlist;

    //             session()->put($userKey, $mergedWishlist);
    //             session()->forget('guest_wishlist');
    //         }
    //         // 🔥 MOVE GUEST CART TO DATABASE
    //         if (session()->has('guest_cart')) {

    //             $guestCart = session()->get('guest_cart');

    //             foreach ($guestCart as $item) {

    //                 $existingCart = Cart::where('user_id', $user->id)
    //                     ->where('product_id', $item['product_id'])
    //                     ->where('weight', $item['weight'])
    //                     ->first();

    //                 if ($existingCart) {
    //                     $existingCart->quantity += $item['quantity'];
    //                     $existingCart->total_amount = $existingCart->quantity * $existingCart->price;
    //                     $existingCart->save();
    //                 } else {
    //                     Cart::create([
    //                         'user_id'      => $user->id,
    //                         'product_id'   => $item['product_id'],
    //                         'category_id'  => $item['category_id'],
    //                         'quantity'     => $item['quantity'],
    //                         'weight'       => $item['weight'],
    //                         'price'        => $item['price'],
    //                         'discount'     => 0,
    //                         'total_amount' => $item['price'] * $item['quantity'],
    //                         'status'       => 1
    //                     ]);
    //                 }
    //             }

    //             session()->forget('guest_cart');
    //         }


    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Login successful!',
    //             'redirect' => route('home')
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Invalid email or password'
    //     ]);
    // }

    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'otp'   => 'required'
    //     ]);

    //     $user = User::where('email', $request->email)
    //         ->where('otp', $request->otp)
    //         ->where('otp_expires_at', '>=', now())
    //         ->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid or expired OTP'
    //         ]);
    //     }

    //     // ✅ Login user after OTP verification
    //     Auth::login($user);

    //     // Clear OTP
    //     $user->update([
    //         'otp' => null,
    //         'otp_expires_at' => null
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Login successful!',
    //         'redirect' => route('home')
    //     ]);
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->role == 1) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ]);
        }

        // ✅ Check password manually (DO NOT Auth::attempt here)
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ]);
        }

        // ✅ Generate OTP
        $otp = random_int(1000, 9999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        // // ✅ Send OTP Mail (CORRECT FROM)
        Mail::send('frontend.pages.otp_email', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Login OTP')
                ->from($user->email, $user->name);
        });
        session(['otp_email' => $user->email]);

        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your email',

            'redirect' => route('otp')
        ]);
    }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp'   => 'required|digits:4'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP'
            ]);
        }

        // ✅ Login user HERE
        Auth::login($user);

        // ✅ Clear OTP
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        // 🔥 Move guest cart AFTER login
        $this->moveGuestCart($user);
        $this->mergeGuestWishlist($user);

        return response()->json([
            'status' => true,
            'message' => 'Login successful!',
            'redirect' => route('home')
        ]);
    }
    private function mergeGuestWishlist($user)
    {

        // ✅ Merge guest wishlist after login
        if (session()->has('guest_wishlist')) {

            $guestWishlist = session()->get('guest_wishlist', []);
            $userKey = 'wishlist_' . $user->id;

            $userWishlist = session()->get($userKey, []);

            $mergedWishlist = $userWishlist + $guestWishlist;

            session()->put($userKey, $mergedWishlist);
            session()->forget('guest_wishlist');
        }
    }
    private function moveGuestCart($user)
    {
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
        // dd(8);
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

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        // 🔥 Generate new OTP
        $otp = random_int(1000, 9999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // 🔥 Send email
        Mail::send('frontend.pages.otp_email', [
            'otp' => $otp,
            'user' => $user
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your New Login OTP')
                ->from(config('mail.from.address'), config('mail.from.name'));
        });

        return response()->json([
            'status' => true,
            'message' => 'New OTP sent successfully!'
        ]);
    }
}
