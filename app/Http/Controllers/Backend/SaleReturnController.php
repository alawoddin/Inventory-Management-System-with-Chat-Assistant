<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SaleReturn;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    public function AllSalesReturn() {
        $allData = SaleReturn::orderBy('id', 'desc')->get();
        return view('admin.backend.return-sale.all_return_sales', compact('allData'));
    }
}
