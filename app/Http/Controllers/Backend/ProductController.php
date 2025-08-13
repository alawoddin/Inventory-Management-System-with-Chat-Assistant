<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\WareHouse;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
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

     public function StoreProduct(Request $request){

        $product = Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'warehouse_id' => $request->warehouse_id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price,
            'stock_alert' => $request->stock_alert,
            'note' => $request->note,
            'product_qty' => $request->product_qty,
            'status' => $request->status,
            'created_at' => now(), 
        ]);

        $product_id = $product->id;

        /// Multiple Image Upload 
        if ($request->hasFile('image')) {
           foreach($request->file('image') as $img) {
           $manager = new ImageManager(new Driver());
           $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
           $imgs = $manager->read($img);
           $imgs->resize(150,150)->save(public_path('upload/productimg/'.$name_gen));
           $save_url = 'upload/productimg/'.$name_gen;

           ProductImage::create([
            'product_id' => $product_id,
            'image' => $save_url
           ]);
           }
        }

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.product')->with($notification);

    }
    //End Method 

       public function EditProduct($id){
        $editData = Product::find($id);
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        $multiimg = ProductImage::where('product_id',$id)->get();
        return view('admin.backend.product.edit_product',compact('categories','brands','suppliers','warehouses','editData','multiimg')); 
    }
     //End Method 
}
