<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function AllPermission() {

        $permissions = Permission::all();

        return view('admin.backend.pages.permission.all_permission' , compact('permissions'));
    } 

    //end method 

    public function AddPermission() {
        return view('admin.backend.pages.permission.add_permission');
    }

    //end method 

    public function StorePermission(Request $request) {

        Permission::create([
            'name' =>$request->name,
            'group_name' => $request->group_name,
        ]);

          $notification = [
            'message' => 'Permission  Insert  Successfully',
            'alert-type' => 'success'
        ]; 

        return redirect()->route('all.permission')->with($notification);

    }

    public function EditPermission($id) {
        $permissions = Permission::find($id);

        return view('admin.backend.pages.permission.edit_permission' , compact('permissions'));
    }

    public function UpdatePermission(Request $request) {

        $per_id = $request->id;

             Permission::find($per_id)->update([
            'name' =>$request->name,
            'group_name' => $request->group_name,
        ]);

          $notification = [
            'message' => 'Permission  Update  Successfully',
            'alert-type' => 'success'
        ]; 

           return redirect()->route('all.permission')->with($notification);

    }

    public function DeletePermission($id) {
        
        Permission::find($id)->delete();

         $notification = [
            'message' => 'Permission  Delete  Successfully',
            'alert-type' => 'success'
        ]; 

           return redirect()->route('all.permission')->with($notification);



    }
}
