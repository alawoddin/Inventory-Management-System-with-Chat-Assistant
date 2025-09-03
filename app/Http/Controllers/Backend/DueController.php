<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SaleItem;
use App\Models\Sale;
use Illuminate\Http\Request;

class DueController extends Controller
{
    public function DueSales () {
        $sales = Sale::with(['customer' , 'warehouse'])->select('id' , 'customer_id' , 'warehouse' , 'due_amount')
        ->where('due_amount' , '>' , 0);

        return view('admin.backend.due.sale_due' , compact('sales'));
    }
}
