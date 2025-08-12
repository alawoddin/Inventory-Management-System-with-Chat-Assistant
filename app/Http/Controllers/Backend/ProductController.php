<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\WareHouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function AllProduct() {
        $allData = Product::orderBy('id', 'DESC')->get();
        return view('admin.backend.product.product_list', compact('allData'));
    }

    //end method 

   public function AddProduct(){
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        return view('admin.backend.product.add_product',compact('categories','brands','suppliers','warehouses')); 
    }
    //End Method 
}
