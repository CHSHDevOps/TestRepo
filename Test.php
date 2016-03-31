<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

use App\Objects\Customer;

class CustomerController extends Controller
{
    /**
     * @return Modal with a form to create a new Customer
     */
    public function create_modal()
    {
        return view('customer.create_modal', [
            'submit_target' => 'customer.post'
            ]);
    }

    /**
     * @param  Request containing a Customer->id 'id'
     * @return Modal with a form to edit the Customer targetted in the Request
     */
    public function edit_modal(Request $request)
    {
        $customer = Customer::where(['id' => $request->get('id')])->first();

        return view('customer.edit_modal', [
            'customer'      => $customer,
            'submit_target' => 'customer.patch'
            ]);
    }

    /**
     * @param  Request containing fields of a new Customer
     * @return Redirect to customer.show
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->all());
        $customer->save();

        return redirect()->route('customer.show');
    }

    /**
     * @param  Request containing fields of a modified Customer including id
     * @return Redirect to customer.show
     */
    public function update(CustomerRequest $request)
    {
        $customer = Customer::where(['id' => $request->get('id')])->first();
        $customer->update($request->all());
        $customer->save();

        return redirect()->route('customer.show');
    }

    /**
     * @return Page displaying current Customers in a table
     */
    public function show()
    {
        return view('customer.show', [
                'customers'  => Customer::all()
            ]);
    }
}
