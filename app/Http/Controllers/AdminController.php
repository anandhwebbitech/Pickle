<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Short;


class AdminController extends Controller
{
    //
    public function Login()
    {
        return view( 'admin.layouts.login');
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
    public function SubCategories()
    {
        $category = Category::where('status',1)->get();
        return view('admin.pages.sub-categories', compact('category'));
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
        return view('admin.pages.Payment-list');
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


public function SubCategoryIndex(Request $request)
{
    if ($request->ajax()) {

        $data = SubCategory::with('category')->latest()->get(); 

        return DataTables::of($data)

            ->addIndexColumn()

            ->addColumn('category', function ($row) {
                return $row->category->name ?? '-';
            })
            ->addColumn('subcategory', function ($row) {
                return $row->sub_category_name ?? '-';
            })

            ->addColumn('status', function ($row) {
                return $row->status
                    ? '<span class="badge-active">Active</span>'
                    : '<span class="badge-inactive">Inactive</span>';
            })

            ->addColumn('action', function ($row) {

                $editUrl = route('subcategories.update', $row->id);

                return '
                    <button class="btn btn-sm btn-warning editBtn"
                        data-id="'.$row->id.'"
                        data-name="'.$row->sub_category_name.'"
                        data-category="'.$row->category_id.'"
                        data-status="'.$row->status.'"
                        data-url="'.$editUrl.'">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button class="btn btn-sm btn-danger deleteBtn"
                        data-id="'.$row->id.'">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })

            ->rawColumns(['status','action'])
            ->make(true);
    }
}
public function SubCategoryStore(Request $request)
{
    $request->validate([
        'name' => 'required',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required'
    ]);

    SubCategory::create([
        'sub_category_name' => $request->name,
        'category_id' => $request->category_id,
        'status' => $request->status
    ]);

    return response()->json(['message' => 'Sub Category added successfully']);
}
public function SubCategoryUpdate(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'category_id' => 'required',
        'status' => 'required'
    ]);

    $sub = SubCategory::findOrFail($id);

    $sub->update([
        'sub_category_name' => $request->name,
        'category_id' => $request->category_id,
        'status' => $request->status
    ]);

    return response()->json(['message' => 'Updated successfully']);
}
public function SubCategoryDelete($id)
{
    SubCategory::findOrFail($id)->delete();

    return response()->json(['message' => 'Deleted successfully']);
}


    public function Banner(Request $request)
    {
        if ($request->ajax()) {

            $data = Banner::latest();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('image', function ($row) {
                    return '<img src="'.asset('public/uploads/banners/'.$row->image).'" width="60">';
                })

                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {

                    $editUrl = route('banners.update', $row->id);

                    return '
                        <button class="btn btn-sm btn-warning editBtn"
                            data-id="'.$row->id.'"
                            data-name="'.$row->name.'"
                            data-image="'.$row->image.'"
                            data-status="'.$row->status.'"
                            data-url="'.$editUrl.'">
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

        return view('admin.pages.banner');
    }
    public function Bannerstore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required'
        ]);

        $imageName = time().'_'.$request->file('image')->getClientOriginalName();
        $request->image->move(public_path('uploads/banners'), $imageName);

        Banner::create([
            'name' => $request->name,
            'image' => $imageName,
            'status' => $request->status
        ]);

        return response()->json(['message'=>'Banner Added']);
    }

    // UPDATE
    public function Bannerupdate(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $imageName = $banner->image;

        if ($request->hasFile('image')) {

            if ($banner->image && file_exists(public_path('uploads/banners/'.$banner->image))) {
                unlink(public_path('uploads/banners/'.$banner->image));
            }

            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->image->move(public_path('uploads/banners'), $imageName);
        }

        $banner->update([
            'name' => $request->name,
            'image' => $imageName,
            'status' => $request->status
        ]);

        return response()->json(['message'=>'Banner Updated']);
    }

    // DELETE
    public function Bannerdestroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && file_exists(public_path('uploads/banners/'.$banner->image))) {
            unlink(public_path('uploads/banners/'.$banner->image));
        }

        $banner->delete();

        return response()->json(['message'=>'Banner Deleted']);
    }

    public function Shorts(Request $request)
    {
        if ($request->ajax()) {

            $data = Short::latest();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('video', function ($row) {
                    return '<iframe width="100" height="180"
                        src="'.$row->youtube_url.'"
                        frameborder="0" allowfullscreen></iframe>';
                })

                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <button class="btn btn-sm btn-warning editBtn"
                            data-id="'.$row->id.'"
                            data-title="'.$row->title.'"
                            data-url="'.$row->youtube_url.'"
                            data-status="'.$row->status.'"
                            data-update="'.route('shorts.update',$row->id).'">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-danger deleteBtn"
                            data-id="'.$row->id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['video','status','action'])
                ->make(true);
        }

        return view('admin.pages.shorts');
    }


// STORE
public function ShortsStore(Request $request)
{
    $request->validate([
        'youtube_url' => 'required|string',
        'title' => 'nullable|string',
        'status' => 'required'
    ]);

    Short::create([
        'title' => $request->title,
        'youtube_url' => $this->shortEmbed($request->youtube_url), // ✅ clean save
        'status' => $request->status
    ]);

    return response()->json(['message'=>'Short added']);
}


// UPDATE
public function ShortsUpdate(Request $request, $id)
{
    $short = Short::findOrFail($id);

    $short->update([
        'title' => $request->title,
        'youtube_url' => $this->shortEmbed($request->youtube_url),
        'status' => $request->status
    ]);

    return response()->json(['message'=>'Short updated']);
}

// DELETE
public function ShortsDelete($id)
{
    Short::findOrFail($id)->delete();

    return response()->json(['message'=>'Short deleted']);
}


// HELPER
private function shortEmbed($url)
{
    if (!$url) return null;

    if (str_contains($url, 'shorts/')) {
        $id = explode('shorts/', $url)[1];
    } elseif (str_contains($url, 'watch?v=')) {
        $id = explode('watch?v=', $url)[1];
    } elseif (str_contains($url, 'youtu.be/')) {
        $id = explode('youtu.be/', $url)[1];
    } else {
        return $url;
    }

    if (str_contains($id, '?')) {
        $id = explode('?', $id)[0];
    }

    return 'https://www.youtube.com/embed/' . $id;
}

}
