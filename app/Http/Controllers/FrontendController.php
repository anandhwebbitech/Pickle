<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Errors\SignatureVerificationError;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;



class FrontendController extends Controller
{
    //
    public function Home()
    {
        $products = Product::where('status', 1)->get();
        $wishlistIds = [];
        $categories = Category::where('status', 1)->get();
        if (auth()->check()) {
            $userId = auth()->id();
            $wishlist = session()->get('wishlist_' . $userId, []);
            $wishlistIds = array_keys($wishlist);
        }
        return view('frontend.pages.index', compact('products', 'wishlistIds','categories'));
    }
    public function About()
    {
        return view('frontend.pages.about');
    }
    public function Contact()
    {
        return view('frontend.pages.contact');
    }
    public function Private_Policy()
    {
        return view('frontend.pages.private-policy');
    }
    public function Terms()
    {
        return view('frontend.pages.terms-and-condition');
    }
    public function Shipping_policy()
    {
        return view('frontend.pages.shipping-policy');
    }
    public function Product(Request $request)
    {
        $query = Product::where('status', 1);

        // ✅ Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // // ✅ Sorting (optional)
        // if ($request->sort == 'low-high') {
        //     $query->orderBy('price', 'asc');
        // } elseif ($request->sort == 'high-low') {
        //     $query->orderBy('price', 'desc');
        // } else {
        //     $query->latest();
        // }

        $products = $query->paginate(15)->withQueryString();

        // ✅ Wishlist Logic (your existing logic preserved)
        $wishlistIds = [];

        if (auth()->check()) {
            $userId = auth()->id();
            $wishlist = session()->get('wishlist_' . $userId, []);
            $wishlistIds = array_keys($wishlist);
        }

        $categories = Category::where('status', 1)->get();

        return view(
            'frontend.pages.product-list',
            compact('products', 'wishlistIds', 'categories')
        );
    }
    public function Wishlist()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userId = auth()->id();
        $wishlist = session()->get('wishlist_' . $userId, []);

        $productIds = array_keys($wishlist);

        $products = Product::whereIn('id', $productIds)->get();

        return view('frontend.pages.wishlist', compact('products'));
    }
    public function Login()
    {
        return view('frontend.pages.login');
    }
    public function Signup()
    {
        return view('frontend.pages.signup');
    }
    public function Checkout()
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $coupon = session()->get('coupon', []);

        $discount = 0;

        // ✅ Validate coupon belongs to current user
        if (!empty($coupon) && isset($coupon['user_id']) && $coupon['user_id'] == $userId) {
            $discount = $coupon['discount'];
        } else {
            // If not matching user → remove it
            session()->forget('coupon');
        }

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }
        $gst_rate = 18; // GST %
        $gst_total = ($subtotal * $gst_rate) / 100; // GST on subtotal
        $cgst = $gst_total / 2; // CGST 9%
        $sgst = $gst_total / 2; // SGST 9%

        $delivery = 0;
        $total = $subtotal + $gst_total - $discount + $delivery ;

        // $total = $subtotal - $discount + $delivery;

        $user_delivery_address = UserAddress::where('status', 1)->where('is_default', 1)->first();
        // If no default address found
        if (!$user_delivery_address) {
            $user_delivery_address = UserAddress::where('user_id', auth()->id())
                ->where('status', 1)
                ->first();
        }

        return view('frontend.pages.checkout', compact(
            'cartItems',
            'subtotal',
            'discount',
            'delivery',
            'gst_total',
            'total',
            'coupon',
            'user_delivery_address'
        ));
    }

    public function Profile()
    {
        $user = Auth::user(); // get logged-in user

        $addresses = UserAddress::where('user_id', $user->id)
            ->where('status', 1)
            ->get();
        return view('frontend.pages.user-dashboard', compact('user', 'addresses'));
    }
    public function ProductDetails($id)
    {
        $product = Product::findOrFail($id);
        $contains = json_decode($product->contains, true); // convert to array
        $related_products = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(4)->get();

        $wishlistIds = [];
        if (auth()->check()) {
            $userId = auth()->id();
            $wishlist = session()->get('wishlist_' . $userId, []);
            $wishlistIds = array_keys($wishlist);
        }

        return view('frontend.pages.product-details', compact('product', 'contains', 'related_products', 'wishlistIds'));
    }

    public function toggleWishlist($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Please login first'
            ]);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $userId = auth()->id();

        // Get wishlist for logged in user
        $wishlist = session()->get('wishlist_' . $userId, []);

        if (isset($wishlist[$id])) {

            unset($wishlist[$id]);
            $added = false;
        } else {

            $price = $product->discount_price ?? $product->price;

            $wishlist[$id] = [
                "id"           => $product->id,
                "product_name" => $product->product_name ?? $product->name,
                "price"        => $price,
                "quantity"     => 1,
                "product_img"  => $product->image ?? null,
            ];

            $added = true;
        }

        // Store back to session
        session()->put('wishlist_' . $userId, $wishlist);

        return response()->json([
            'status'  => true,
            'added'   => $added,
            'count'   => count($wishlist),
            'message' => $added ? 'Added to wishlist' : 'Removed from wishlist'
        ]);
    }

    public function wishlistData()
    {
        try {

            if (!auth()->check()) {
                return response()->json([
                    'status' => false,
                    'html'   => '<div class="col-12 text-center">
                                <h5>Please login first ❤️</h5>
                             </div>'
                ]);
            }

            $userId   = auth()->id();
            $wishlist = session()->get('wishlist_' . $userId, []);
            $productIds = array_keys($wishlist);

            $products = Product::whereIn('id', $productIds)->get();

            $html = '';
            // dd($products);
            foreach ($products as $product) {

                // ✅ Safe JSON decode
                $prices = [];
                if (!empty($product->weight)) {
                    $decoded = json_decode($product->weight, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $prices = $decoded;
                    }
                }

                $firstPrice = !empty($prices) && isset($prices[0]['price'])
                    ? $prices[0]['price']
                    : 0;

                $oldPrice = !empty($prices) && isset($prices[0]['mrp'])
                    ? $prices[0]['mrp']
                    : null;

                // ✅ Discount badge
                $discountBadge = '';
                if ($oldPrice && $oldPrice > $firstPrice) {
                    $discount = round((($oldPrice - $firstPrice) / $oldPrice) * 100);
                    $discountBadge = '<span class="badge bg-danger position-absolute top-0 start-0 m-2" style="z-index:5;">' . $discount . '%</span>';
                }

                // ✅ Safe image
                // $image = $product->image
                //     ? asset('public/uploads/products/' . $product->image)
                //     : asset('assets/img/product/default.webp');
                // ✅ Safe image
                    $defaultImage =  $product->image;

                    // Decode JSON string if needed
                    $images = is_array($product->image) 
                                ? $product->image 
                                : (is_string($product->image) ? json_decode($product->image, true) : [$product->image]);

                    // Ensure $images is an array
                    $images = is_array($images) ? $images : [];

                    // Get main and hover images with fallback
                    $mainImage = $images[0] ?? $defaultImage;
                    $hoverImage = $images[1] ?? $defaultImage;

                    // Build asset URLs
                    $mainImageUrl  = asset('public/uploads/products/' . $mainImage);
                    $hoverImageUrl = asset('public/uploads/products/' . $hoverImage);

                // ✅ Safe route
                // $productUrl = route('product.details', $product->id);

                $html .= '
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card p-3 border shadow-sm bg-white">

                    <div class="img-container mb-3">

                        ' . $discountBadge . '

                        <button class="save-btn active" 
                                onclick="toggleSave(this)" 
                                data-id="' . $product->id . '">
                            <i class="bi bi-heart-fill text-danger"></i>
                        </button>

                        <img src="' . $mainImageUrl . '" class="img-main">
                        <img src="' . $hoverImageUrl . '" class="img-hover">

                        <div class="view-overlay">
                            <a href="' . route('product-details', $product->id) . ' "
                               class="btn btn-light rounded-pill btn-sm fw-bold shadow-sm px-3">
                               View Product
                            </a>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-1">' . e($product->name) . '</h6>

                    <p class="text-muted small mb-3">
                        Spicy • Tangy • Traditional
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold fs-5 text-danger">
                                ₹' . number_format($firstPrice, 2) . '
                            </span>';

                if ($oldPrice && $oldPrice > $firstPrice) {
                    $html .= '
                    <small class="text-muted text-decoration-line-through ms-1">
                        ₹' . number_format($oldPrice, 2) . '
                    </small>';
                }
                $prices = json_decode($product->weight, true);
                $firstWeight = $prices[0]['weight'] ?? null;
                $firstPrice  = $prices[0]['price'] ?? 0;

                $html .= '
                        </div>

                        <div class="qty-pill">
                            <span class="qty-btn" onclick="updateQty(this, -1)">-</span>
                            <span class="local-qty fw-bold">1</span>
                            <span class="qty-btn" onclick="updateQty(this, 1)">+</span>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 rounded-pill mt-3 py-2 fw-bold"
                        onclick="handleCartClick(this)"
                        data-id="' . $product->id . '"
                        data-url="' . route('cart.add', $product->id) . '"
                        data-weight="' . $firstWeight . '"
                        data-price= "' . $firstPrice . '">
                        Add to Cart
                    </button>

                </div>
            </div>';
            }

            // ✅ Empty wishlist
            if ($products->isEmpty()) {
                $html = '
            <div class="col-12 text-center">
                <h5>Your wishlist is empty ❤️</h5>
                <a href="' . route('home') . '" class="btn btn-dark mt-3">
                    Continue Shopping
                </a>
            </div>';
            }

            return response()->json([
                'status' => true,
                'html'   => $html
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage(),
                'line'   => $e->getLine()
            ]);
        }
    }
    public function addToCart11(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        $prices = json_decode($product->weight, true);
        $price = $prices[0]['price'] ?? 0;

        $userId = auth()->id();

        // Check if already in cart
        $existingCart = Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += 1;
            $existingCart->total_amount = $existingCart->quantity * $price;
            $existingCart->save();
        } else {

            Cart::create([
                'user_id'     => $userId,
                'product_id'  => $product->id,
                'category_id' => $product->category_id ?? null,
                'quantity'    => 1,
                'weight'      => $prices[0]['weight'] ?? null,
                'price'       => $price,
                'discount'    => 0,
                'total_amount' => $price,
                'status'      => 1
            ]);
        }

        $cartCount = Cart::where('user_id', $userId)->count();

        return response()->json([
            'status' => true,
            'count'  => $cartCount,
            'message' => 'Product added to cart successfully'
        ]);
    }
    public function addToCart(Request $request, $id)
    {
        // Check login manually
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'redirect' => route('login'),
                'message' => 'Please login first'
            ]);
        }

        $request->validate([
            'weight'   => 'required',
            'price'    => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        $userId = auth()->id();

        $weight   = $request->weight;
        $price    = $request->price;
        $quantity = $request->quantity;

        // Check if same product + same weight already exists
        $existingCart = Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->where('weight', $weight)
            ->first();

        if ($existingCart) {

            // Increase quantity
            $existingCart->quantity += $quantity;
            $existingCart->price = $price;
            $existingCart->total_amount = $existingCart->quantity * $price;
            $existingCart->save();
        } else {

            Cart::create([
                'user_id'      => $userId,
                'product_id'   => $product->id,
                'category_id'  => $product->category_id ?? null,
                'quantity'     => $quantity,
                'weight'       => $weight,
                'price'        => $price,
                'discount'     => 0,
                'total_amount' => $price * $quantity,
                'status'       => 1
            ]);
        }

        // Total quantity count for badge
        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json([
            'status'  => true,
            'count'   => $cartCount,
            'message' => 'Product added to cart successfully'
        ]);
    }
    public function ProductShow($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.pages.product-details');
    }

    public function Cart()
    {
        session()->forget('coupon');
        return view('frontend.pages.cart');
    }
    public function getCartItems(Request $request)
    {
        $user_id = Auth::id();

        $cartItems = Cart::where('user_id', $user_id)
            ->where('status', 1)
            ->with('product') // assuming Cart model has a product() relation
            ->get();


        $subtotal = 0;
        $html = '';

        foreach ($cartItems as $item) {
            // ✅ Safe image
                $defaultImage = $item->product->image;

                // Decode JSON string if needed
                $images = is_array($item->product->image) 
                            ? $item->product->image 
                            : (is_string($item->product->image) ? json_decode($item->product->image, true) : [$item->product->image]);

                // Ensure $images is an array
                $images = is_array($images) ? $images : [];

                // Get main and hover images with fallback
                $mainImage = $images[0] ?? $defaultImage;
                $hoverImage = $images[1] ?? $defaultImage;

                // Build asset URLs
                $mainImageUrl  = asset('public/uploads/products/' . $mainImage);
                $hoverImageUrl = asset('public/uploads/products/' . $hoverImage);
            $totalAmount = $item->quantity * $item->price;
            $subtotal += $totalAmount;
            $html .= '
            <div class="yp-cart-item shadow-sm" data-id="' . $item->id . '">
                <img src="' . $mainImageUrl . '" class="yp-item-thumb" alt="' . $item->product->name . '">
                <div class="yp-item-details">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="yp-item-name">' . $item->product->name . '</span>
                        <i class="bi bi-trash3 yp-btn-remove" title="Remove Item" data-id="' . $item->id . '"></i>
                    </div>
                    <span class="yp-item-spec">Volume: ' . $item->weight . ' | Price: ₹' . $item->price . '</span>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="yp-qty-pill">
                                <button class="yp-qty-btn" onclick="updateQty(this,' . $item->id . ',-1)">-</button>
                                <span class="yp-qty-num">' . $item->quantity . '</span>
                                <button class="yp-qty-btn" onclick="updateQty(this,' . $item->id . ', 1)">+</button>
                            </div>
                            <a href="' . route('product-details', $item->product_id) . '"  class="yp-btn-view-only" title="View Product">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>

                        <span class="yp-item-price">₹' . $item->total_amount . '</span>
                    </div>
                </div>
            </div>';
        }
        $gst_rate = 18; // GST %
        $gst_total = ($subtotal * $gst_rate) / 100; // GST on subtotal
        $cgst = $gst_total / 2; // CGST 9%
        $sgst = $gst_total / 2; // SGST 9%

        $delivery = 0;
        $total = $subtotal + $gst_total + $delivery;
        // return response()->json(['html' => $html]);
        return response()->json([
            'html' => $html,
            'subtotal' => $subtotal,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'gst_total' => $gst_total,
            'delivery' => $delivery, // you can calculate delivery if needed
            'total' => $total // can apply discounts later
        ]);
    }
    public function removeCartItem($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Item not found']);
        }

        $cart->delete();

        return response()->json(['success' => true]);
    }

    public function updateCartItem11(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity += $request->change;
        if ($cart->quantity < 1) $cart->quantity = 1;
        $cart->total_amount = $cart->quantity * $cart->price;
        $cart->save();
        return response()->json(['success' => true]);
    }
    public function updateCartItem(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        if ($request->change > 0) {
            $cart->increment('quantity', $request->change);
        } else {
            $cart->decrement('quantity', abs($request->change));
        }

        // Refresh model
        $cart->refresh();

        if ($cart->quantity < 1) {
            $cart->quantity = 1;
            $cart->save();
        }

        $cart->total_amount = $cart->quantity * $cart->price;
        $cart->save();

        return response()->json([
            'status' => true,
            'quantity' => $cart->quantity,
            'total' => $cart->total_amount
        ]);
    }
    // public function applyDiscount(Request $request)
    // {
    //     $code = $request->code;
    //     $userId = auth()->id();

    //     // Find the discount
    //     $discount = Coupon::where('code', $code)->where('status', 1)->first();
    //     if (!$discount) {
    //         return response()->json(['success' => false, 'message' => 'Invalid or expired code']);
    //     }

    //     // Calculate subtotal
    //     $cartItems = Cart::where('user_id', $userId)->where('status', 1)->get();
    //     $subtotal = $cartItems->sum(function($item) {
    //         return $item->price * $item->quantity;
    //     });

    //     // Apply discount
    //     if ($discount->type == 1) { // percentage
    //         $discountAmount = ($subtotal * $discount->value) / 100;
    //     } else { // fixed amount
    //         $discountAmount = $discount->value;
    //     }

    //     $total = max(0, $subtotal - $discountAmount);

    //     return response()->json([
    //         'success' => true,
    //         'subtotal' => $subtotal,
    //         'discount' => $discountAmount,
    //         'total' => $total
    //     ]);
    // }


    public function applyDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $code = strtoupper($request->code);

        $userId = Auth::id(); // logged in user

        // ✅ Get cart items from database
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ]);
        }

        // ✅ Calculate subtotal from DB
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // ✅ Get coupon from DB
        $coupon = Coupon::where('code', $code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code'
            ]);
        }
        // Check expiry date
        if ($coupon->expiry_date && now()->greaterThan($coupon->expiry_date)) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired'
            ]);
        }
        // Check use limit
        // Count how many times this user has already used this coupon
        $userUseCount = Order::where('user_id', $userId)
            ->where('coupon_code', $coupon->code)
            ->count();

        // Compare with use_limit
        if ($coupon->use_limit && $userUseCount >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'You have already used this coupon the maximum number of times'
            ]);
        }
        $userUseCount = Order::where('coupon_code', $coupon->code)
            ->count();

        // Compare with use_limit
        if ($coupon->use_limit && $userUseCount >= $coupon->use_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon Reched Use Limit'
            ]);
        }


        $discount = 0;

        /*
        type = 0 → Fixed
        type = 1 → Percentage
    */

        if ($coupon->type == 0) {
            $discount = $coupon->value;
        } else {
            $discount = ($subtotal * $coupon->value) / 100;
        }

        // Prevent over discount
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $delivery = 0;
        $gst_rate = 18;
        $gst_total = ($subtotal * $gst_rate) / 100;
        $total = $subtotal + $gst_total - $discount + $delivery;    

        // ✅ Store only coupon in session
        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'user_id' => $userId
        ]);

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ]);
    }
    public function storeAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile' => 'required',
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required'
        ]);

        $userId = Auth::id();

        // If default checked → remove old default
        if ($request->has('is_default')) {
            UserAddress::where('user_id', $userId)
                ->update(['is_default' => 0]);
        }

        $address = UserAddress::create([
            'user_id' => $userId,
            'name' => $request->full_name,
            'mobile' => $request->mobile,
            'address' => $request->address_line1,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'is_default' => $request->has('is_default') ? 1 : 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address saved successfully'
        ]);
    }
    public function updateAddress(Request $request, $id)
    {
        $address = UserAddress::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // If set as default → remove other defaults
        if ($request->edit_is_default) {
            UserAddress::where('user_id', auth()->id())
                ->update(['is_default' => 0]);
        }

        $address->update([
            'name'     => $request->edit_full_name,
            'mobile'   => $request->edit_mobile,
            'address'  => $request->edit_address_line1,
            'city'     => $request->edit_city,
            'state'    => $request->edit_state,
            'pincode'  => $request->edit_pincode,
            'is_default' => $request->edit_is_default ? 1 : 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully!'
        ]);
    }

    public function navbarCart()
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => true,
                'html' => '<div class="text-center py-4">Please login 🛒</div>',
                'total' => 0
            ]);
        }

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();
        $cartItemsCount = Cart::with('product')->where('user_id', auth()->id())->count();
       
        $html = '';
        $grandTotal = 0;

        foreach ($cartItems as $item) {

            if (!$item->product) continue;

            $product = $item->product;

            $qty    = $item->quantity;
            $price  = $item->price;
            $weight = $item->weight;

            $itemTotal = $qty * $price;
            $grandTotal += $itemTotal;

                $defaultImage = $product->image;

                // Decode JSON string if needed
                $images = is_array($product->image) 
                            ? $product->image 
                            : (is_string($product->image) ? json_decode($product->image, true) : [$product->image]);

                // Ensure $images is an array
                $images = is_array($images) ? $images : [];

                // Get main and hover images with fallback
                $mainImage = $images[0] ?? $defaultImage;
                $hoverImage = $images[1] ?? $defaultImage;

                // Build asset URLs
                $mainImageUrl  = asset('public/uploads/products/' . $mainImage);
                $hoverImageUrl = asset('public/uploads/products/' . $hoverImage);

            $html .= '
        <div class="cart-item d-flex align-items-center mb-4 p-3 bg-light rounded-4"
             data-id="' . $item->id . '"
             data-price="' . $price . '">

            <div class="cart-img-container me-3">
                <img src="' . $mainImageUrl . '" class="rounded-3 shadow-sm" width="60">
            </div>

            <div class="flex-grow-1">
                <h6 class="mb-0 fw-bold">' . e($product->name) . '</h6>
                <small class="text-muted">' . $weight . 'g</small>

                <div class="d-flex align-items-center mt-2 gap-3">

                    <div class="d-flex align-items-center bg-white rounded-pill px-2 border"style="cursor: pointer;">
                        <span class="btn-minus p-1"
                              onclick="updateQtyNav(this,' . $item->id . ', -1)">-</span>

                        <span class="qty fw-bold mx-2 yp-qty-num">' . $qty . '</span>

                        <span class="btn-plus p-1"
                              onclick="updateQtyNav(this,' . $item->id . ', 1)">+</span>
                    </div>

                    <div class="fw-bold text-calor">
                        ₹<span class="item-total">' . number_format($itemTotal, 2) . '</span>
                    </div>

                </div>
            </div>

            <button class="btn btn-sm text-muted btn-remove nav-cart-remove ms-2" data-id="' . $item->id . '"
                    >
                <i class="bi bi-x-circle-fill fs-5"></i>
            </button>
        </div>';
        }

        if ($cartItems->isEmpty()) {
            $html = '<div class="text-center py-4">Cart is empty 🛒</div>';
        }

        return response()->json([
            'status' => true,
            'html'   => $html,
            'total'  => number_format($grandTotal, 2),
            'cartcount' => $cartItemsCount
        ]);
    }

    public function placeCodOrder(Request $request)
    {
        try {
            $userId = auth()->id();

            $cartItems = Cart::where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart is empty'
                ]);
            }

            // Get extra details from AJAX
            $addressId  = $request->address_id;
            $couponCode = $request->coupon_code ?? 0;
            $subtotal   = $request->subtotal ?? 0;
            $discount   = $request->discount ?? 0;
            $total      = $request->total ?? 0;

            // You could store one row per cart item or create a single order with multiple items
            foreach ($cartItems as $item) {

                Order::create([
                    'product_id'   => $item->product_id,
                    'cart_id'      => $item->id,
                    'user_id'      => $userId,
                    'address_id'   => $addressId,      // store delivery address
                    'weight'       => $item->weight,
                    'price'        => $item->price,
                    'discount'     => $item->discount ?? 0,
                    'coupon_code'  => $couponCode,
                    'total'        => $item->total_amount,
                    'payment_type' => 2, // 2 = COD
                    'status'       => 1, // 1 = pending
                    'order_date'   => now(),
                    'delivery_date' => now()->addDays(7),
                ]);
            }

            // Clear cart after order
            Cart::where('user_id', $userId)->delete();

            return response()->json([
                'status'   => true,
                'redirect' => route('product') // you can redirect to order confirmation page
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function createRazorpayOrder(Request $request)
    {
        try {

            $userId = auth()->id();

            if (!$userId) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ]);
            }

            $cartItems = Cart::where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart is empty'
                ]);
            }

            DB::beginTransaction();

            $createdOrders = [];

            foreach ($cartItems as $item) {

                $order = Order::create([
                    'user_id'       => $userId,
                    'address_id'    => $request->address_id,
                    'product_id'    => $item->product_id,
                    'cart_id'      => $item->id,
                    'weight'       => $item->weight,
                    'price'         => $item->price,
                    'discount'      => $request->discount ?? 0,
                    'coupon_code'   => $request->coupon_code ?? 0,
                    'total'         => $item->total_amount,
                    'payment_type'  => 1, // Razorpay
                    'status'        => 0,
                    'order_date'    => now(),
                    'delivery_date' => now()->addDays(7),
                ]);

                Cart::where('user_id', $userId)->where('id', $item->id)->delete();
                $createdOrders[] = $order->id;
            }

            // Create Razorpay order using total amount
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );
            $rOrder = $api->order->create([
                'receipt'  => 'order_group_' . time(),
                'amount'   => $request->total * 100,
                'currency' => 'INR'
            ]);

            DB::commit();

            return response()->json([
                'status'            => true,
                'key'               => config('services.razorpay.key'),
                'amount'            => $rOrder['amount'],
                'razorpay_order_id' => $rOrder['id'],
                'order_ids'         => $createdOrders
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function verifyRazorpayPayment() {}

    public function savePayment(Request $request)
    {
        DB::beginTransaction();

        try {

            $orderIds = $request->order_ids;

            // Convert JSON string to array
            if (is_string($orderIds)) {
                $decoded = json_decode($orderIds, true);
                $orderIds = $decoded ?? [$orderIds];
            }

            // If single value, convert to array
            if (!is_array($orderIds)) {
                $orderIds = [$orderIds];
            }

            if (empty($orderIds)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid order IDs'
                ]);
            }

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $attributes = [
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // ✅ Update all orders
            Order::whereIn('id', $orderIds)->update([
                'status' => 1
            ]);

            // ✅ Create payment row for EACH order

            PaymentDetail::create([
                'order_id'          =>  json_encode($orderIds), // Always integer
                'payment_id'        => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'signature'         => $request->razorpay_signature,
                'amount'            => $request->amount ? $request->amount / 100 : 0,
                'payment_method'    => 'Razorpay',
                'payment_status'    => 1,
                'status'            => 1
            ]);

            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return response()->json([
                'status'   => 'success',
                'redirect' => route('home')
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function userOrdersDatatable(Request $request)
    {
        $orders = Order::with('product')->where('user_id', auth()->id())
            ->latest();

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_number', function ($row) {
                return '#OR-' . $row->id;
            })
            ->addColumn('productname', function ($row) {
                return $row->product->name ?? '-';
            })

            ->addColumn('date', function ($row) {
                return $row->created_at->format('M d, Y');
            })

            ->addColumn('amount', function ($row) {
                return '₹' . number_format($row->total, 2);
            })

            ->addColumn('status', function ($row) {

                if ($row->status == 2) {
                    return '<span class="badge bg-success">Delivered</span>';
                } elseif ($row->status == 0 ) {
                    return '<span class="badge bg-warning">Pending</span>';
                } elseif ($row->status == 1 ) {
                    return '<span class="badge bg-info">Order Confirm</span>';
                } elseif ($row->status == 4 ) {
                    return '<span class="badge bg-danger">Returned</span>';
                } else {
                    return '<span class="badge bg-danger">Cancelled</span>';
                }
            })
            // ✅ NEW ACTION COLUMN
            ->addColumn('action', function ($row) {

                // View Button
                $viewBtn = '<a href="' . route('product-details', $row->product_id) . '" 
                                class="btn btn-sm btn-primary rounded-circle d-inline-flex align-items-center justify-content-center me-1" style="width:28px; height:28px; padding:0;">
                                <i class="bi bi-eye "style="font-size:10px;"></i>
                            </a>';

                $cancelBtn = '';
                $returnBtn = '';

                // Show Cancel only if Pending
                if ($row->status == 1) {
                    $cancelBtn = '<button class="btn btn-sm btn-danger rounded-circle d-inline-flex align-items-center justify-content-center me-1 cancel-order" 
                                        data-id="' . $row->id . '" style="width:28px; height:28px; padding:0;">
                                        <i class="bi bi-x-circle "style="font-size:10px;"></i>
                                </button>';
                }

                // Show Return only if Delivered
                if ($row->status == 2) {
                    $returnBtn = '<button class="btn btn-sm btn-warning rounded-circle d-inline-flex align-items-center justify-content-center return-order" 
                                        data-id="' . $row->id . '" style="width:28px; height:28px; padding:0;">
                                        <i class="bi bi-arrow-counterclockwise "style="font-size:10px;"></i>
                                </button>';
                }

                return $viewBtn . $cancelBtn . $returnBtn;
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $order->status = 3; // cancelled
        $order->save();

        return response()->json([
            'message' => 'Your order has been cancelled successfully.'
        ]);
    }

    public function returnOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $order->status = 4; // returned
        $order->save();

        return response()->json([
            'message' => 'Return request submitted successfully.'
        ]);
    }

    public function send(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // 2. Prepare email data
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone_number ?? 'N/A',
            'messageBody' => $request->message,
        ];

        // 3. Send email using Blade template
        Mail::send('frontend.pages.email', $data, function ($message) use ($data) {
            $message->to('anandhwebbitech@gmail.com')
                ->subject('New Enquiry Recived')
                ->from($data['email'], $data['fullname']); // optional: sender's email
        });

        // 4. Return JSON response
        return response()->json(['success' => 'Message sent successfully!']);
    }
    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->keyword . '%')
                    ->where('status', 1)
                    ->take(5)
                    ->get();

        return response()->json($products);
    }
}
