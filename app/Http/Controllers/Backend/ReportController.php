<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product; 
use App\Models\Customer;  
use App\Models\WareHouse; 
use App\Models\Sale; 
use App\Models\SaleReturn; 
use Illuminate\Support\Facades\DB; 
use App\Models\Purchase;  
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function AllReport() {
        $purchases = Purchase::with(['purchaseItems.product','supplier','warehouse'])->get();

        return view('admin.backend.report.all_report' , compact('purchases'));
    }
}
