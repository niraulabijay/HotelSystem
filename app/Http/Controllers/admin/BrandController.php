<?php

namespace App\Http\Controllers\admin;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::all();
        return view('admin.brand.index',compact('brands'));
    }

    public function add(){
        return view('admin.brand.add');
    }
}
