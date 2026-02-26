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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;


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
        $otp = random_int(1000, 9999);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 2,
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);
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
        // Auth::login($user);
        // return response()->json([
        //     'message' => 'Account created successfully!'
        // ]);
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

    //     // ðŸš« Block users with role = 1
    //     if ($user->role == 1) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid email or password'
    //         ]);
    //     }


    //     // âœ… Generate OTP
    //     $otp = rand(100000, 999999);
    //     $user->update([
    //         'otp' => $otp,
    //         'otp_expires_at' => Carbon::now()->addMinutes(5)
    //     ]);

    //     // âœ… Send OTP Mail
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

    //         // âœ… Merge guest wishlist after login
    //         if (session()->has('guest_wishlist')) {

    //             $guestWishlist = session()->get('guest_wishlist', []);
    //             $userKey = 'wishlist_' . $user->id;

    //             $userWishlist = session()->get($userKey, []);

    //             $mergedWishlist = $userWishlist + $guestWishlist;

    //             session()->put($userKey, $mergedWishlist);
    //             session()->forget('guest_wishlist');
    //         }
    //         // ðŸ”¥ MOVE GUEST CART TO DATABASE
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

    //     // âœ… Login user after OTP verification
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

        // âœ… Check password manually (DO NOT Auth::attempt here)
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ]);
        }

        // âœ… Generate OTP
        $otp = random_int(1000, 9999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        // // âœ… Send OTP Mail (CORRECT FROM)
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

        // âœ… Login user HERE
        Auth::login($user);

        // âœ… Clear OTP
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        // ðŸ”¥ Move guest cart AFTER login
        $this->moveGuestCart($user);
        $this->mergeGuestWishlist($user);

        return response()->json([
            'status' => true,
            'message' => 'Login successful!',
            'redirect' => redirect()->intended(route('home'))->getTargetUrl()
        ]);
    }
    private function mergeGuestWishlist($user)
    {

        // âœ… Merge guest wishlist after login
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
        // ðŸ”¥ MOVE GUEST CART TO DATABASE
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

        // ðŸ”¥ Generate new OTP
        $otp = random_int(1000, 9999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // ðŸ”¥ Send email
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
    public function forgotPassword()
    {
        return view('frontend.pages.forgot-password');
    }

    public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);

    $user = User::where('email', $request->email)->first();

    // Generate token
    $token = Str::random(64);

    // Store token in password_reset_tokens table
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $user->email],
        [
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]
    );

    // Create reset link
    $resetLink = route('password.reset', [
        'token' => $token,
        'email' => $user->email
    ]);
    // Send Email (LIKE YOUR OTP STYLE)
    try {
        Mail::send('frontend.pages.reset_email', ['resetLink' => $resetLink, 'user' => $user], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Reset Your Password')
                        ->from($user->email, $user->name);
                });

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Password reset link sent to your email.'
    ]);
}
public function showResetForm($token)
{
    return view('frontend.pages.reset-password', [
        'token' => $token
    ]);
}
public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $record = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    if (!$record || !Hash::check($request->token, $record->token)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid or expired token.'
        ]);
    }

    $user = User::where('email', $request->email)->first();

    $user->password = Hash::make($request->password);
    $user->save();

    // Delete token after use
    DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->delete();

    return response()->json([
        'status' => true,
        'message' => 'Password reset successfully.',
        'redirect' => route('login')
    ]);
}
}
