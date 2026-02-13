<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FrontendController extends Controller
{
    //
    public function Home()
    {
        $products = Product::where('status', 1)->get();
        $wishlistIds = [];

        if (auth()->check()) {
            $userId = auth()->id();
            $wishlist = session()->get('wishlist_' . $userId, []);
            $wishlistIds = array_keys($wishlist);
        }
        return view('frontend.pages.index', compact('products', 'wishlistIds'));
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

        $delivery = 0;
        $total = $subtotal - $discount + $delivery;

        $user_delivery_address = UserAddress::where('status',1)->where('is_default',1)->first();

        return view('frontend.pages.checkout', compact(
            'cartItems',
            'subtotal',
            'discount',
            'delivery',
            'total',
            'coupon','user_delivery_address'
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
                $image = $product->image
                    ? asset('public/uploads/products/' . $product->image)
                    : asset('assets/img/product/default.webp');

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

                        <img src="' . $image . '" class="img-main">
                        <img src="' . $image . '" class="img-hover">

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
            $totalAmount = $item->quantity * $item->price;
            $subtotal += $totalAmount;
            $html .= '
            <div class="yp-cart-item shadow-sm" data-id="' . $item->id . '">
                <img src="' . asset('public/uploads/products/' . $item->product->image) . '" class="yp-item-thumb" alt="' . $item->product->name . '">
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
                            <a href="/product/' . $item->product_id . '" class="yp-btn-view-only" title="View Product">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>

                        <span class="yp-item-price">₹' . $item->total_amount . '</span>
                    </div>
                </div>
            </div>';
        }

        // return response()->json(['html' => $html]);
        return response()->json([
            'html' => $html,
            'subtotal' => $subtotal,
            'delivery' => 0, // you can calculate delivery if needed
            'total' => $subtotal // can apply discounts later
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

    public function updateCartItem(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity += $request->change;
        if ($cart->quantity < 1) $cart->quantity = 1;
        $cart->total_amount = $cart->quantity * $cart->price;
        $cart->save();
        return response()->json(['success' => true]);
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
        $total = $subtotal - $discount + $delivery;

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

            $image = $product->image
                ? asset('public/uploads/products/' . $product->image)
                : asset('assets/img/product/default.webp');

            $html .= '
        <div class="cart-item d-flex align-items-center mb-4 p-3 bg-light rounded-4"
             data-id="' . $item->id . '"
             data-price="' . $price . '">

            <div class="cart-img-container me-3">
                <img src="' . $image . '" class="rounded-3 shadow-sm" width="60">
            </div>

            <div class="flex-grow-1">
                <h6 class="mb-0 fw-bold">' . e($product->name) . '</h6>
                <small class="text-muted">' . $weight . 'g</small>

                <div class="d-flex align-items-center mt-2 gap-3">

                    <div class="d-flex align-items-center bg-white rounded-pill px-2 border">
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
            'total'  => number_format($grandTotal, 2)
        ]);
    }
}
