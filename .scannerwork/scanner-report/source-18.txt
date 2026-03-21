<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Brand;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function AllBrand() {
        //    if (!auth()->user()->hasPermissionTo('all.brand')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $brand = Brand::latest()->get();
        return view('admin.backend.brand.all_brand', compact('brand'));
    }

    //end method 

    public function AddBrand() {
        return view('admin.backend.brand.add_brand');
    }
    // end method

public function StoreBrand(Request $request)
{
    if ($request->file('image')) {
        $image = $request->file('image');
        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($image);
        $img->resize(100, 90)->save(public_path('upload/brand/'.$name_gen));
        $save_url = 'upload/brand/'.$name_gen;

        // Create Brand
        $brand = Brand::create([
            'name'  => $request->name,
            'image' => $save_url
        ]);

        // 📝 Now Log Activity AFTER Saving
        Activity::create([
            'user_id'  => auth()->id(),
            'action'   => 'Created',
            'model'    => 'Brand',
            'model_id' => $brand->id,
        ]);
    }

    $notification = [
        'message' => 'Brand Inserted Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('all.brand')->with($notification);
}

    public function EditBrand($id){
        //   if (!auth()->user()->hasPermissionTo('edit.brand')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $brand = Brand::find($id);
        return view('admin.backend.brand.edit_brand',compact('brand'));

    }
     //End Method


public function UpdateBrand(Request $request)
{
    $brand_id = $request->id;
    $brand = Brand::find($brand_id);

    if ($request->file('image')) {
        $image = $request->file('image');
        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($image);
        $img->resize(100,90)->save(public_path('upload/brand/'.$name_gen));
        $save_url = 'upload/brand/'.$name_gen;

        // Delete old image
        if (file_exists(public_path($brand->image))) {
            @unlink(public_path($brand->image));
        }

        // Update Brand with new image
        $brand->update([
            'name'  => $request->name,
            'image' => $save_url
        ]);

        // 📝 Log Activity - With Image Update
        Activity::create([
            'user_id'  => auth()->id(),
            'action'   => 'Updated',
            'model'    => 'Brand',
            'model_id' => $brand->id,
        ]);

        $notification = [
            'message' => 'Brand Updated with image Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.brand')->with($notification);

    } else {

        // Update Brand without image
        $brand->update([
            'name' => $request->name,
        ]);

        // 📝 Log Activity - Without Image Update
        Activity::create([
            'user_id'  => auth()->id(),
            'action'   => 'Updated',
            'model'    => 'Brand',
            'model_id' => $brand->id,
        ]);

        $notification = [
            'message' => 'Brand Updated without image Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.brand')->with($notification);
    }
}
//End Method

    public function DeletBrand($id) {
        $brand = Brand::find($id);
        $img = $brand->image;
        unlink($img);

        Brand::find($id)->delete();

           Activity::create([
            'user_id'  => auth()->id(),
            'action'   => 'Deleted',
            'model'    => 'Brand',
            'model_id' => $id,
        ]);

        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);
    }
}
