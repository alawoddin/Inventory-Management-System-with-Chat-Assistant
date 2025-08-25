<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\WareHouse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function AllSales() {
        $allData = Sale::orderBy('id', 'desc')->get();

        return view(('admin.backend.sales.all_sales'), compact('allData'));
    }

    public function AddSales() {

        $customers = Customer::all();
        $warehouses = WareHouse::all();

        return view('admin.backend.sales.add_sales', compact('customers', 'warehouses'));

    }
}
