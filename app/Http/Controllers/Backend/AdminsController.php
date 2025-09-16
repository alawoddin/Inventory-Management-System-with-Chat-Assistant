<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; 

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
}
