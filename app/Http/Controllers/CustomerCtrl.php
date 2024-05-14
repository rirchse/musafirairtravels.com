<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Auth;
use Image;
use File;
use Session;


class CustomerCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('layouts.customers.view_customer', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.customers.create_customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $source = New SourceCtrl;
        // Session::flash('success', 'working on back-end');
        // return back();
        
    //  $this->validate($request, [
    //     'full_name' => 'required|max:255',
    //     'contact'   => 'required|regex:/(01)[0-9]{9}/|max:11',
    //     'email'     => 'email|max:32|nullable',
    //     'address'   => 'required|max:255',
    //     'status'    => 'max:10',
    //     'details'   => 'max:99999',
    // ]);


     $data = $request->all();

     if(isset($data['_token']))
     {
        unset($data['_token']);
     }

     if(isset($data['image']))
     {
       $data['image'] = $source->uploadImage($data['image'], 'customers/');
     }

     $data['created_at'] = date('Y-m-d');

     try{
        Customer::insert($data);
     }
     catch(e $message)
     {
        //
     }

    $customer_id = Customer::orderBy('id', 'DESC')->first()->id;

    Session::flash('success', 'Customer Successfully Saved');
    return redirect()->route('customer.show',$customer_id);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return view('layouts.customers.read_customer',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('layouts.customers.edit_customer',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this->validate($request, [
        //     'full_name' => 'required|max:255',
        //     'contact'   => 'required|regex:/(01)[0-9]{9}/|max:11',
        //     'email'     => 'email|max:32|nullable',
        //     'address'   => 'required|max:255',
        //     'status'    => 'max:10',
        //     'details'   => 'max:99999',
        // ]);


        $data = $request->all();

        if(isset($data['_method']))
        {
            unset($data['_method']);
        }

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(!isset($data['status']))
        {
            $data['status'] = '';
        }

        try{
            Customer::where('id', $id)->update($data);
        }
        catch(e $message)
        {
            //
        }

        Session::flash('success', 'Customer information successfully updated.');
        return redirect('/customer/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);           
        if (File::exists($customer->image)) {
            File::delete($customer->image);
        }
        $customer->delete();
        Session::flash('success', 'Customer Successfully Delete');
        return redirect()->route('customer.index');
    }

    /** Ajax Call: search clients/customers by name, mobile, email, ticket number */
    public function searchCustomer($value)
    {
        $customer = Customer::leftJoin('sales', 'customers.id', 'sales.customer_id')
        ->where('customers.name', 'like', '%'.$value.'%')
        ->orWhere('customers.contact', 'like', '%'.$value.'%')
        ->orWhere('customers.email', 'like', '%'.$value.'%')
        ->orWhere('sales.ticket_no', 'like', '%'.$value.'%')
        ->select('customers.id', 'customers.name', 'customers.contact', 'customers.email', 'sales.ticket_no', 'customers.amount')
        ->first();
        return response()->json([
            'data' => $customer
        ]);
    }
}
