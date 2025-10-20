<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\WareHouse;
use Illuminate\Http\Request;

class WareHouseController extends Controller
{
    public function AllWarehouse() {
        //  if (!auth()->user()->hasPermissionTo('all.warehouse')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $warehouse = WareHouse::latest()->get();
        return view('admin.backend.warehouse.all_warehouse', compact('warehouse'));
    }
    //end method

    public function AddWarehouse() {
        return view('admin.backend.warehouse.add_warehouse');
    }

      public function StoreWarehouse(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:ware_houses,email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
        ]);

        $warehouse = WareHouse::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ]);

        Activity::create([
            'user_id'  => auth()->id(),
            'action'   => 'Created',
            'model'    => 'WareHouse',
            'model_id' => $warehouse->id,
        ]);

          

        $notification = array(
            'message' => 'WareHouse Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.warehouse')->with($notification);

    }
    //End Method 

    public function EditWarehouse($id){
        $warehouse = WareHouse::find($id);
        return view('admin.backend.warehouse.edit_warehouse',compact('warehouse'));
    }
     //End Method 


     public function UpdateWarehouse(Request $request){
        $ware_id = $request->id;

        $warehouse = WareHouse::find($ware_id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:ware_houses,email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
        ]);

        WareHouse::find($ware_id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
        ]);

           Activity::create([
            'user_id'  => auth()->id(),
            'action'   => 'Updated',
            'model'    => 'WareHouse',
            'model_id' => $warehouse->id,
        ]);

        $notification = array(
            'message' => 'WareHouse Updated Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.warehouse')->with($notification);

    }
    //End Method 

public function DeleteWarehouse($id)
{
    // Fetch warehouse before delete to get name (optional but good)
    $warehouse = WareHouse::find($id);

    if ($warehouse) {
        // Delete the record
        $warehouse->delete();

        // 📝 Log Delete Activity
        Activity::create([
            'user_id'  => auth()->id(),
            'action'   => 'Deleted',
            'model'    => 'Warehouse',
            'model_id' => $id,
        ]);
    }

    $notification = [
        'message' => 'Warehouse Deleted Successfully',
        'alert-type' => 'success'
    ];
    
    return redirect()->back()->with($notification);
}
//End Method
}
