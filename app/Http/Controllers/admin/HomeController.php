<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $data['categories'] = count(Category::all());
        $data['products'] = count(Product::all());
        $data['orders'] = count(Order::all());
        $data['customers'] = count(User::all());
        $data['subCategories'] = count(SubCategory::all());
        $data['brands'] = count(Brand::all());
        return view('admin.dashboard', $data);

    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
