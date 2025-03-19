<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Invoice;
use App\InvoiceOther;
use App\Customer;
use App\Product;
use App\Payment;
use App\Airline;
use App\Vendor;
use App\User;
use App\Role;
use Auth;
use Image;
use App\Refund;
use File;
use Session;
use DB;

class SaleCtrl extends Controller
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
        $type = '';
        $this->viewSalesByType($type);
    }

    public function viewSalesByType($type)
    {
        $sales = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id');
        if($type)
        {
            $sales = $sales->where('type', $type);
        }
        $sales = $sales->select('sales.*', 'customers.name', 'customers.contact', 'customers.email')->orderBy('sales.id','DESC')->paginate(20);
        
        return view('layouts.sales.view_sale', compact('sales', 'type'));
    }

    /** search invoice */
    public function searchInvoice(Request $request)
    {
        $data = $request->all();
        $type = $data['type'];
        $search = $data['search'];

        $sales = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id');
        $sales = $sales->where('sales.type', $type)
        ->where('sales.pax_name', 'like', '%'.$search.'%')
        ->orWhere('sales.ticket_no', 'like', '%'.$search.'%')
        ->select('sales.*', 'customers.name', 'customers.contact', 'customers.email')->orderBy('sales.id','DESC')->paginate(20);
        // dd($sales);
        return view('layouts.sales.view_sale', compact('sales', 'type'));
    }

    /** add new client on create invoice page */
    public function addNewClient(Request $request)
    {
        $data = $request->all();
        $type = $data['type'];

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['type']))
        {
            unset($data['type']);
        }
        
        Customer::insert($data);
        Session::flash('success', 'The client successfully created to the system.');
        return redirect()->route('sale.create.type', $type);
    }
    
    public function create()
    {
        $vendors = Vendor::all();
        return view('layouts.sales.create-sale', compact('vendors'));
    }

    public function createByType($type)
    {
        $vendors = Vendor::all();
        return view('layouts.sales.create-sale', compact('vendors', 'type'));
    }

    public function storeSession(Request $request)
    {
        $data = $request->all();
        
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        $sales = [];
        if(Session::get('_sales'))
        {
            $sales = Session::get('_sales');
        }
        array_push($sales, $data);

        Session::put('_sales', $sales);
        return redirect()->route('sale.create.type', $data['type']);
    }

    public function invoiceCopy($ticket_no)
    {
        if(Session::get('_sales'))
        {
            $invoice = [];
            $sales = Session::get('_sales');
            foreach($sales as $sale)
            {
                if($sale['ticket_no'] == $ticket_no)
                {
                    $invoice = $sale;
                    $vendors = Vendor::all();
                    $type = $sale['type'];
                    $client = Customer::find($sale['customer_id']);
                    return view('layouts.sales.create-sale', compact('vendors', 'type', 'invoice', 'client'));
                }
            }
            return back();
        }
        return redirect()->route('home');
    }

    public function invoiceSessionEdit($key)
    {
        if(Session::get('_sales'))
        {
            $sales = Session::get('_sales');
            $invoice = $sales[$key];
            $vendors = Vendor::all();
            $type = $invoice['type'];
            $client = Customer::find($invoice['customer_id']);
            return view('layouts.sales.edit-session', compact('vendors', 'type', 'invoice', 'client', 'key'));
        }
    }

    public function invoiceUpdate(Request $request, $key)
    {
        $data = $request->all();
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }
        if(isset($data['_method']))
        {
            unset($data['_method']);
        }
        if(Session::get('_sales'))
        {
            $sales = Session::get('_sales');
            $sales[$key] = array_replace($sales[$key], $data);

            Session::put('_sales', $sales);
            return redirect()->route('sale.create.type', $sales[$key]['type']);
        }
    }

    public function storeMulti()
    {
        if(Session::get('_sales'))
        {
            $sales      = Session::get('_sales');
            $client_id  = $sales[0]['customer_id'];
            $vendor_id  = $sales[0]['vendor_id'];
            $type       = $sales[0]['type'];
            $issue_date = $sales[0]['issue_date'];

            $purchase = $total_sale = $profit = $discount = 0;
            foreach($sales as $sale)
            {
                $purchase   += $sale['purchase'];
                $total_sale += $sale['client_price'];
                $profit     += $sale['profit'];
            }

            DB::table('invoices')->insert([
                'type'       => $type,
                'customer_id'=> $client_id,
                'vendor_id'  => $vendor_id,
                'purchase'   => $purchase,
                'sale'       => $total_sale,
                'profit'     => $profit,
                'issue_date' => $issue_date,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $invoice = DB::table('invoices')->orderBy('id', 'DESC')->latest()->first();
            
            foreach($sales as $sale)
            {
                $sale['invoice_id'] = $invoice->id;
                Sale::insert($sale);
            }

            /** update client balance */
            $client = Customer::find($client_id);
            Customer::where('id', $client_id)->update(['amount' => $client->amount - $total_sale]);

            /** update vendor balance */
            $vendor = Vendor::find($vendor_id);
            Vendor::where('id', $vendor_id)->update(['amount' => $vendor->amount - $purchase]);

            $report = new ReportCtrl;
            //store client report
            $report->storeReport([
                'user_id' => $client_id,
                'user_type' => 'Client',
                'report_type' => $type,
                'foreign_id' => $invoice->id,
                'name' => $type.' Created',
                'debit' => $total_sale,
                'credit' => null,
                'balance' => $client->amount - $total_sale,
            ]);

            //store vendor report
            $report->storeReport([
                'user_id' => $vendor_id,
                'user_type' => 'Vendor',
                'report_type' => $type,
                'foreign_id' => $invoice->id,
                'name' => $type.' Created',
                'debit' => $purchase,
                'credit' => null,
                'balance' => $vendor->amount - $purchase,
            ]);

            Session::forget('_sales');

            return redirect()->route('sale.invoice.print', $invoice->id);
        }

        return redirect()->route('home');
    }

    public function invoiceSessionDelete($index, $type)
    {
        $sales = Session::get('_sales');
        $invoices = [];
        if($sales)
        {
            unset($sales[$index]);
            $invoices = $sales;
            Session::forget('_sales');
            Session::put('_sales', $invoices);
        }
        return redirect()->route('sale.create.type', $type);
    }

    public function invoicePrint($id)
    {
        $invoice = DB::table('invoices')
        ->leftJoin('sales', 'sales.invoice_id', 'invoices.id')
        ->leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->leftJoin('users', 'users.id', 'invoices.created_by')
        ->select('invoices.*', 'sales.type', 'customers.name', 'users.name as user_name')
        ->where('invoices.id', $id)->first();
        $sales = Sale::where('invoice_id', $invoice->id)->get();
        return view('layouts.sales.print_sale', compact('invoice', 'sales'));
    }

    public function invoiceClose($type)
    {
        if(Session::get('_sales'))
        {
            Session::forget('_sales');
        }

        return redirect()->route('sale.create.type', $type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }
        if(isset($data['search']))
        {
            unset($data['search']);
        }

        $result = Sale::insert($data);
        $invoice = Sale::orderBy('id', 'DESC')->first();

        Session::flash('success', 'Invoice Successfully Saved.');
        return redirect()->route('sale.view.type', $invoice->type);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        $sales = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->leftJoin('vendors', 'vendors.id', 'sales.vendor_id')
        ->where('invoice_id', $id)
        ->select('sales.*', 'customers.name', 'customers.contact', 'customers.email', 'customers.passport_no', 'vendors.name as vendor_name')
        ->get();
        return view('layouts.sales.read_sale', compact('invoice', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->select('sales.*', 'customers.name', 'customers.contact', 'customers.address')->find($id);
        $type = $sale->type;
        $vendors = Vendor::orderBy('id', 'DESC')->where('status', 'Active')->get();
        $client = Customer::find($sale->customer_id);
        // dd($client);
        return view('layouts.sales.edit_sale', compact('sale', 'type', 'vendors', 'client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['_method']))
        {
            unset($data['_method']);
        }

        Sale::where('id', $id)->update($data);
        $sale = Sale::find($id);

        Session::flash('success', 'Invoice Successfully Updated.');
        return redirect('/sale/'.$sale->invoice_id);
    }

    public function reIssue($id)
    {
        $vendors = Vendor::all();
        $sale = Sale::find($id);
        $client = Customer::leftJoin('sales', 'customers.id', 'sales.customer_id')->select('customers.id', 'customers.name', 'customers.contact', 'customers.email', 'customers.passport_no', 'sales.ticket_no')->find($sale->customer_id);
        $type = $sale->type;
        return view('layouts.sales.re_issue', compact('sale', 'vendors', 'client', 'type'));
    }

    public function reIssueUpdate(Request $request, $id)
    {
        $sale = Sale::find($id);

        $data = $request->all();

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['_method']))
        {
            unset($data['_method']);
        }

        $data['status'] = 'Re-Issued';
        $data['pre_ticket_id'] = $id;
        $data['customer_id'] = $sale->customer_id;

        $type = $data['type'];

        Sale::insert($data);
        Sale::where('id', $id)->update(['status' => 'Cancelled']);

        Session::flash('success', 'The ticket re-issued successfully.');
        return redirect()->route('sale.view.type', $type);
    }

    public function viewReissued()
    {
        $type = 'Re-Issued';
        $sales = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id')->where('sales.status', 'Re-Issued');
        // if($type)
        // {
        //     $sales = $sales->where('type', $type);
        // }
        $sales = $sales->select('sales.*', 'customers.name', 'customers.contact', 'customers.email')->orderBy('sales.id','DESC')->paginate(20);
        
        return view('layouts.sales.view_sale', compact('sales', 'type'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = '';
        $sales = Sale::where('invoice_id', $id)->get();
        foreach($sales as $sale)
        {
            $type = $sale->type;
            $sale->delete();
        }
        Session::flash('success', 'The invoice successfully deleted.');
        return redirect()->route('sale.view.type', $type);
    }

    public function print($id)
    {
        $sale = Sale::find($id);
        return view('layouts.sales.print_sale', compact('sale'));
    }

    public function search($value)
    {
        $orders = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->leftJoin('users', 'users.id', 'sales.created_by')
        ->where('customers.name', 'like','%'.$value.'%')
        ->orWhere('customers.contact', 'like','%'.$value.'%')
        ->orWhere('gtotal',  'like','%'.$value.'%')
        ->select('sales.*', 'customers.name', 'customers.contact', 'customers.address', 'users.name')
        ->limit(5)->get();
        return response()->json([
            'success' => $orders
        ]);
    }

    // call by ajax to get the airlines
    public function getAirlines($name)
    {
        $items = Airline::where('name', 'like', '%'.$name.'%')->select('name')->limit(10)->get();
        return response()->json([
            'success' => $items
        ]);
    }

    public function changePrintStatus($id)
    {
        $print_status = 1;
        $sale = Sale::find($id);
        if($sale->print_status)
        {
            $print_status = $sale->print_status+1;
        }
        
        $update = Sale::find($id);
        $update->print_status = $print_status;
        $update->save();

        return response()->json('true');
    }


    /** ------------------------- invoice others --------------------- */
    public function invoiceIndex($type)
    {
        $invoices = InvoiceOther::leftJoin('customers', 'customers.id', 'invoice_others.client_id')
        ->leftJoin('vendors', 'vendors.id', 'invoice_others.vendor_id')
        ->orderBy('id', 'DESC')->where('type', $type)
        ->select('invoice_others.*', 'customers.name as client_name', 'vendors.name as vendor_name')
        ->paginate(25);
        return view('layouts.invoice_others.index', compact('invoices', 'type'));
    }
    public function invoiceCreate($type)
    {
        $vendors = Vendor::all();
        $clients = Customer::all();
        return view('layouts.invoice_others.create', compact('vendors', 'clients', 'type'));
    }

    public function invoiceStore(Request $request)
    {
        $data = $request->all();
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        $type = $data['type'];

        InvoiceOther::insert($data);
        $invoice = InvoiceOther::orderBy('id', 'DESC')->first();

        $report = new ReportCtrl;

        /** update client balance */
        if(isset($data['client_id']))
        {
            $client = Customer::find($data['client_id']);
            Customer::where('id', $data['client_id'])->update(['amount' => $client->amount - $data['total_sale']]);

            //store client report
            $report->storeReport([
                'user_id'     => $client->id,
                'user_type'   => 'Client',
                'report_type' => $type,
                'foreign_id'  => $invoice->id,
                'name'        => 'Invoice '.$type.' Created',
                'debit'       => $data['total_sale'],
                'credit'      => null,
                'balance'     => $client->amount - $data['total_sale'],
            ]);
        }
        /** update vendor balance */
        if(isset($data['vendor_id']))
        {
            $vendor = Vendor::find($data['vendor_id']);
            Vendor::where('id', $data['vendor_id'])->update(['amount' => $vendor->amount - $data['cost_price']]);

            //store vendor report
            $report->storeReport([
                'user_id'     => $vendor->id,
                'user_type'   => 'Vendor',
                'report_type' => $type,
                'foreign_id'  => $invoice->id,
                'name'        => 'Invoice '.$type.' Created',
                'debit'       => $data['cost_price'],
                'credit'      => null,
                'balance'     => $vendor->amount - $data['cost_price'],
            ]);
        }

        Session::flash('success', 'Invoice successfully saved.');
        return redirect()->route('invoice.type.index', $data['type']);
    }

    public function invoiceShow($id)
    {
        $invoice = InvoiceOther::leftJoin('customers', 'customers.id', 'invoice_others.client_id')
        ->leftJoin('vendors', 'vendors.id', 'invoice_others.vendor_id')
        ->select('invoice_others.*', 'customers.name as client_name', 'vendors.name as vendor_name')
        ->find($id);
        return view('layouts.invoice_others.read', compact('invoice'));
    }

    public function invoiceEdit($type, $id)
    {
        $invoice = InvoiceOther::find($id);
        $vendors = Vendor::all();
        $client = Customer::find($invoice->client_id);
        return view('layouts.invoice_others.edit', compact('vendors', 'client', 'type', 'invoice'));
    }

    public function invoiceOtherUpdate(Request $request, $id)
    {
        $data = $request->all();
        
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['_method']))
        {
            unset($data['_method']);
        }
        InvoiceOther::where('id', $id)->update($data);
        Session::flash('success', 'The invoice successfully udpated.');
        return redirect()->route('invoice.show', $id);
    }

    public function printOther($id)
    {
        $invoice = InvoiceOther::leftJoin('customers', 'customers.id', 'invoice_others.client_id')
        ->select('invoice_others.*', 'customers.name')
        ->find($id);
        return view('layouts.invoice_others.print_invoice', compact('invoice'));
    }

    public function invoiceDelete($id)
    {
        $invoice = InvoiceOther::find($id);
        $invoice->delete();
        Session::flash('success', 'The invoice successfully deleted.');
        return redirect()->route('invoice.type.index', $invoice->type);
    }

    /** ajax call */
    public function searchClients($name)
    {
        $clients = Customer::where('name', 'like', '%'.$name.'%')->get();
        return response()->json(['data' => $clients], 200);
    }

    public function searchInvoices($client)
    {
        $invoices = Invoice::leftJoin('sales', 'sales.invoice_id', 'invoices.id')
        ->where('sales.customer_id', $client)
        ->groupBy('sales.invoice_id')
        ->select('sales.invoice_id')
        ->get();

        $tickets = Sale::where('customer_id', $client)
        ->select('id', 'ticket_no', 'invoice_id')
        ->get();
        return response()->json(['invoices' => $invoices, 'tickets' => $tickets], 200);
    }

    public function getTicket($id)
    {
        $ticket = Sale::leftJoin('vendors', 'vendors.id', 'sales.vendor_id')
        ->select('sales.*', 'vendors.name as vendor_name')->find($id);
        return response()->json(['ticket' => $ticket], 200);
    }

    /** temp invoice update */
    // public function tempInvoiceUpdate()
    // {
    //     $sales = Sale::all();
    //     foreach($sales as $val)
    //     {
    //         Invoice::where('id', $val->invoice_id)->update(['customer_id' => $val->customer_id, 'vendor_id' => $val->vendor_id]);
    //     }
    // }
}
