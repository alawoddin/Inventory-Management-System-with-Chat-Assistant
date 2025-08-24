<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ReturnPurchase; 
use App\Models\ReturnPurchaseItem; 
use Illuminate\Http\Request;

class ReturnPurchaseController extends Controller
{
      public function AllReturnPurchase(){
        $allData = ReturnPurchase::orderBy('id','desc')->get();
        return view('admin.backend.return-purchase.all_return_purchase',compact('allData')); 
    }
    // End Method 
}
