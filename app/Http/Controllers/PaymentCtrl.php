<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Payment;
use App\Sale;
use App\Customer;
use App\Vendor;
use App\Product;
use App\User;
use App\Role;
use Auth;
use Image;
use Session;
use File;

class PaymentCtrl extends Controller
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
        $payments = Payment::leftJoin('sales', 'sales.id', 'payments.sales_id')
        ->leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->select('payments.*', 'customers.name', 'customers.contact')
        ->orderBy('payments.id', 'ASC')
        ->get();
        $type='';
        return view('layouts.payments.view_payment', compact('payments', 'type'));
    }

    public function getPaymentByType($type)
    {
        if($type == 'All'){
            return $this->index();
        }

        $payments = Payment::leftJoin('accounts', 'accounts.id', 'payments.account_id')
        ->where('payments.user_type', $type);

        if($type == 'Client')
        {
            $payments = $payments->leftJoin('customers', 'customers.id', 'payments.user_id')
            ->select('payments.*', 'customers.name', 'customers.contact', 'accounts.name as account_name');
        }

        if($type == 'Vendor')
        {
            $payments = $payments->leftJoin('vendors', 'vendors.id', 'payments.user_id')
            ->select('payments.*', 'vendors.name', 'vendors.contact', 'accounts.name as account_name');
        }

        $payments = $payments
        ->orderBy('payments.id', 'DESC')->paginate(20);
        // dd($payments);
        return view('layouts.payments.view_payment', compact('payments', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPayment($id)
    {   
        $sale = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->select('sales.*', 'customers.full_name', 'customers.contact')->find($id);
        return view('layouts.payments.create_payment', compact('sale'));
    }

    public function create()
    {
        $clients = Customer::get();
        $sale = Sale::first();
        return view('layouts.payments.create_payment', compact('clients', 'sale'));
    }

    public function createType($type)
    {
        $clients = Customer::get();
        $vendors = Vendor::get();
        $sale = Sale::first();
        $accounts = Account::get();
        return view('layouts.payments.create_payment', compact('clients', 'vendors', 'sale', 'type', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type'         => 'required',
            'user_id'      => 'nullable',
            'pre_balance'  => 'required',
            'amount'       => 'required',
            'balance'      => 'nullable',
            'account_balance' => 'nullable',
            'account_id'   => 'required',
            'date'         => 'nullable',
            'details'      => 'nullable|max:9000'
            ]);

        $data = $request->all();

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        Payment::insert($data);
        $payment = Payment::orderBy('id', 'DESC')->first();

        /** get account */
        $account = Account::find($data['account_id']);

        /** report object */
        $report = new ReportCtrl;

        /** update client balance */
        if($data['user_type'] == 'Client')
        {
            $client = Customer::find($data['user_id']);
            Customer::where('id', $data['user_id'])->update([
                'amount' => $data['balance']
            ]);

            //store client report
            $report->storeReport([
                'user_id'     => $client->id,
                'user_type'   => 'Client',
                'report_type' => 'Payment',
                'foreign_id'  => $payment->id,
                'name'        => 'Client Payment',
                'debit'       => null,
                'credit'      => $data['amount'],
                'balance'     => $data['balance'],
            ]);
        }

        /** update vendor balance */
        if($data['user_type'] == 'Vendor')
        {
            $vendor = Vendor::find($data['user_id']);
            Vendor::where('id', $data['user_id'])->update([
                'amount' => $data['balance']
            ]);

            //store vendor report
            $report->storeReport([
                'user_id'     => $vendor->id,
                'user_type'   => 'Vendor',
                'report_type' => 'Payment',
                'foreign_id'  => $payment->id,
                'name'        => 'Vendor Payment',
                'debit'       => null,
                'credit'      => $data['amount'],
                'balance'     => $data['balance'],
            ]);
        }

        /** update account balance */
        if($data['type'] == 'Pay')
        {
            Account::where('id', $data['account_id'])->update(['balance' => $account->balance - $data['amount']]);
        }
        elseif($data['type'] == 'Receive')
        {
            Account::where('id', $data['account_id'])->update(['balance' => $account->balance + $data['amount']]);
        }
        
        Session::flash('Success', 'Payment Successfully Saved.');
        return redirect()->route('payment.type.show', [$data['user_type'], $payment->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $sale = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->leftJoin('accounts', 'accounts.id', 'payments.account_id')
        ->select('sales.*', 'customers.name', 'accounts.name as account_name')
        ->find($id);
        $payment = Payment::find($id);
        return view('layouts.payments.read_payment', compact('sale','payment'));
    }

    public function typeShow($type, $id)
    {
        $payment = Payment::leftJoin('accounts', 'accounts.id', 'payments.account_id')->where('user_type', $type);
        if($type == 'Client')
        {
            $payment = $payment->leftJoin('customers', 'customers.id', 'payments.user_id')
            ->select('payments.*', 'customers.name', 'accounts.name as account_name');
        }
        if($type == 'Vendor')
        {
            $payment = $payment->leftJoin('vendors', 'vendors.id', 'payments.user_id')
            ->select('payments.*', 'vendors.name', 'accounts.name as account_name');
        }
        $payment = $payment->find($id);
        return view('layouts.payments.read_payment', compact('payment'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $payment = Payment::find($id);
        return view('layouts.payments.edit_payment', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return null;
    }

    public function print($id)
    {
        $payment = Payment::find($id);
        $invoice = Payment::leftJoin('customers', 'customers.id', 'payments.user_id')
        ->leftJoin('vendors', 'vendors.id', 'payments.user_id')
        ->leftJoin('accounts', 'accounts.id', 'payments.account_id');
        if($payment->user_type == 'Vendor')
        {
            $invoice = $invoice->select('payments.*', 'vendors.name as user_name', 'accounts.bank_name');
        }else
        {
            $invoice = $invoice->select('payments.*', 'customers.name as user_name', 'accounts.bank_name');
        }
        $invoice = $invoice->find($id);
        // dd($invoice);
        return view('layouts.payments.print_money_receipt', compact('invoice'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        Session::flash('success', 'This payment successfully deleted.');
        return redirect()->route('payment.type.index', $payment->user_type);
    }

    /** get vendor balance by ajax */
    public function getBalance($type, $id)
    {
        $balance = [];
        if($type == 'Vendor')
        {
            $balance = Vendor::select('balance_type', 'amount')->find($id);
        }

        if($type == 'Client')
        {
            $balance = Customer::select('balance_type', 'amount')->find($id);
        }
        return response()->json(['success' => $balance], 200);
    }
}
