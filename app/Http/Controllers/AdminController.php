<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    //
    public function Dashboard(){
        return view(view: 'admin.pages.dashboard');
    }
    public function Product(){
        $categories = Category::where('status', 1)->get();
        return view('admin.pages.product', compact('categories'));
    }
    public function Categories(){
        return view('admin.pages.categories');
    }
    public function Coupon(){
        return view('admin.pages.coupon-code');
    }
}
