<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Pest\ArchPresets\Custom;

class CustomerController extends Controller
{
    public function AllCustomer() {
        $customer = Customer::latest()->get();
        return view('admin.backend.customer.all_customer' , compact('customer'));
    }
    //end method 

    public function AddCustomer() {
        return view('admin.backend.customer.add_customer');
    }

    //end method

    public function StoreCustomer(Request $request) {

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.customer')->with($notification);
    }

    public function EditCustomer($id) {
        $customer = Customer::find($id);
        return view('admin.backend.customer.edit_customer', compact('customer'));
    }

    //end method

    public function UpdateCustomer(Request $request) {
        $customer_id = $request->id;

        Customer::find($customer_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $notification = array(
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.customer')->with($notification);
    }

    // end method

    public function DeleteCustomer($id) {
        Customer::find($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
