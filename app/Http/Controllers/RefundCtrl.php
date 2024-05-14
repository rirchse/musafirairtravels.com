<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Refund;
use App\RefundItem;
use App\Sale;
use App\Customer;
use App\Vendor;
use Auth;
use Session;

class RefundCtrl extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /** ------------------ Re-Funded Methods ---------------- */    

    /** view refund index */
    public function refundIndex()
    {
      $sales = Refund::leftJoin('refund_items', 'refund_items.refund_id', 'refunds.id')
      ->leftJoin('sales', 'sales.id', 'refund_items.sale_id')
      ->leftJoin('customers', 'customers.id', 'sales.customer_id')
      ->select('refunds.*', 'customers.name', 'sales.ticket_no', 'sales.pax_name', 'sales.client_price', 'sales.purchase')
      ->paginate(25);
      return view('layouts.refunds.view_refund', compact('sales'));
    }

    public function refundCreate()
    {
      $sale = Sale::all();
      $clients = Customer::all();
      return view('layouts.refunds.refund_create', compact('sale', 'clients'));
    }

    public function refundStore(Request $request)
    {
      $data = $request->all();
      if(isset($data['_token']))
      {
        unset($data['_token']);
      }
      $data['created_by'] = Auth::id();

      if($request->client_id && $request->invoice_id && $request->ticket_no)
      {
        $tickets = Sale::leftJoin('vendors', 'vendors.id', 'sales.vendor_id')
        ->whereIn('sales.id', $data['ticket_no'])
        ->select('sales.id', 'sales.invoice_id', 'sales.ticket_no', 'sales.pax_name', 'sales.pnr', 'sales.profit', 'sales.client_price', 'sales.purchase', 'sales.discount', 'vendors.name', 'sales.airline')
        ->get();
        $clients = Customer::all();
        
        return view('layouts.refunds.refund_create', compact('tickets', 'clients'));
      }

      $client_charge = $vendor_charge = $total_sale = $total_purchase = 0;

      $total_sale = Sale::whereIn('id', $data['sale_ids'])->sum('client_price');
      $total_purchase = Sale::whereIn('id', $data['sale_ids'])->sum('purchase');

      for($n = 0; count($data['sale_ids']) > $n; $n++)
      {
        $client_charge += $data['client_charges'][$n];
        $vendor_charge += $data['vendor_charges'][$n];
      }

      $data['invoice_id'] = $data['invoice_id'][0];
      $data['client_charge'] = $client_charge;
      $data['vendor_charge'] = $vendor_charge;

      // dd($data);

      $insert = New Refund;
      $insert->invoice_id = $data['invoice_id'][0];
      $insert->client_charge = $client_charge;
      $insert->vendor_charge = $vendor_charge;
      $insert->date = date('Y-m-d');
      $insert->save();

      $refund = Refund::orderBy('id', 'DESC')->first();

      for($n = 0; count($data['sale_ids']) > $n; $n++)
      {
        RefundItem::insert([
          'refund_id' => $refund->id,
          'sale_id' => $data['sale_ids'][$n],
          'ticket_no' => $data['ticket_no'][$n],
          'client_charge' => $data['client_charges'][$n],
          'vendor_charge' => $data['vendor_charges'][$n]
        ]);
      }

      $sale = Sale::find($data['sale_ids'][0]);
      $client = Customer::find($sale->customer_id);
      $vendor = Vendor::find($sale->vendor_id);

      /** update client balance */
      Customer::where('id', $sale->customer_id)->update(['amount' => $client->amount + ($total_sale - $client_charge) ]);

      /** udpate vendor balance */
      Vendor::where('id', $sale->vendor_id)->update(['amount' => $vendor->amount + ($total_purchase - $vendor_charge) ]);
      
      Session::flash('success', 'The invoice successfully refunded.');
      return redirect()->route('sale.refund.show', $refund->id);
    }

    public function refundShow($id)
    {
        $refund = Refund::leftJoin('customers', 'customers.id', 'refunds.client_id')
        ->leftJoin('vendors', 'vendors.id', 'refunds.vendor_id')
        ->select('refunds.*', 'customers.name as client_name', 'vendors.name as vendor_name')
        ->find($id);

        $items = RefundItem::leftJoin('sales', 'sales.id', 'refund_items.sale_id')
        ->where('refund_items.refund_id', $id)
        ->select('refund_items.*', 'sales.client_price', 'sales.purchase')
        ->get();
        // dd($items);
        return view('layouts.refunds.refund_read', compact('refund', 'items'));
    }

    public function refundDelete($id)
    {
        $refund = Refund::find($id);
        $refund->delete();
        Session::flash('success', 'The refund successfully deleted.');
        return redirect()->route('sale.refund.index');
    }
}