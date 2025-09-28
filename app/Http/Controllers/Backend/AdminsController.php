<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Faker\Core\File as CoreFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class AdminsController extends Controller
{
        public function AllAdmin(){
        $alladmin = User::where('role','admin')->latest()->get();
        return view('admin.backend.pages.admin.all_admin',compact('alladmin')); 
    }
    // End Method
      public function AddAdmin(){
        $roles = Role::all();
        return view('admin.backend.pages.admin.add_admin',compact('roles')); 
    }
    // End Method

    public function StoreAdmin(Request $request){

        $user = new User(); 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->save();

        if ($request->roles) {
            $role = Role::where('id',$request->roles)->where('guard_name','web')->first();
            if ($role) {
                $user->assignRole($role->name);
            }
        }

        $notification = array(
            'message' => 'New Admin Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.admin')->with($notification); 

    }
     // End Method

     public function EditAdmin($id){
        $admin = User::find($id);
        $roles = Role::all();
        return view('admin.backend.pages.admin.edit_admin',compact('admin','roles')); 
    }
    // End Method

     public function UpdateAdmin(Request $request,$id){

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email; 
        $user->role = 'admin';
        $user->save();
        
        $user->roles()->detach();

        if ($request->roles) {
            $role = Role::where('id',$request->roles)->where('guard_name','web')->first();
            if ($role) {
                $user->assignRole($role->name);
            }
        }

        $notification = array(
            'message' => 'New Admin Updated Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->route('all.admin')->with($notification); 

    }
     // End Method

    public function DeleteAdmin($id){

        $admin = User::find($id);
        if (!is_null($admin)) {
            $admin->delete();
        }

        $notification = array(
            'message' => ' Admin Deleted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification); 

    }
     // End Method


    //  backup database method 

      public function DatabaseBackup(){

        return view('admin.db_backup')->with('files',File::allFiles(storage_path('/app/private/inventorysystem')));

    }// End Method 

       public function BackupNow(){
        \Artisan::call('backup:run');

          $notification = array(
            'message' => 'Database Backup Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    }// End Method 
  

    public function DownloadDatabase($getFilename){

         $path = storage_path('app/private/inventorysystem/' . $getFilename);
        return response()->download($path);

    }// End Method 

     public function DeleteDatabase($getFilename){

        Storage::delete('inventorysystem/'.$getFilename);

         $notification = array(
            'message' => 'Database Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    }// End Method

}
