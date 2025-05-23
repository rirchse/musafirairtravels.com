<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Refund;
use App\RefundItem;
use App\Invoice;
use App\Sale;
use App\Customer;
use App\Vendor;
use App\Report;
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
      ->orderBy('refunds.id', 'DESC')
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

      $sale = Sale::find($data['sale_ids'][0]);

      $insert = New Refund;
      $insert->invoice_id = $data['invoice_id'][0];
      $insert->vendor_id = $sale->vendor_id;
      $insert->client_id = $sale->customer_id;
      $insert->client_charge = $client_charge;
      $insert->vendor_charge = $vendor_charge;
      $insert->date = date('Y-m-d');
      $insert->save();

      $refund = Refund::orderBy('id', 'DESC')->first();

      for($n = 0; count($data['sale_ids']) > $n; $n++)
      {
        RefundItem::insert([
          'refund_id'     => $refund->id,
          'sale_id'       => $data['sale_ids'][$n],
          'ticket_no'     => $data['ticket_no'][$n],
          'client_charge' => $data['client_charges'][$n],
          'vendor_charge' => $data['vendor_charges'][$n]
        ]);
      }

      $sale = Sale::find($data['sale_ids'][0]);
      $client = Customer::find($sale->customer_id);
      $vendor = Vendor::find($sale->vendor_id);

      $report = new ReportCtrl;

      if(isset($client))
      {
        /** update client balance */
        Customer::where('id', $sale->customer_id)->update(['amount' => $client->amount + ($total_sale - $client_charge) ]);
  
        /** store client report */
        $report->storeReport([
          'user_id'     => $client->id,
          'user_type'   => 'Client',
          'report_type' => 'Refund',
          'foreign_id'  => $refund->id,
          'name'        => 'Air-Ticket Refund',
          'debit'       => null,
          'credit'      => $total_sale - $client_charge,
          'balance'     => $client->amount + ($total_sale - $client_charge),
        ]);
      }

      if(isset($vendor))
      {
        /** update vendor balance */
        Vendor::where('id', $sale->vendor_id)->update([
          'amount' => $vendor->amount + ($total_purchase - $vendor_charge) 
        ]);
  
        /** store vendor report */
        $report->storeReport([
          'user_id'     => $vendor->id,
          'user_type'   => 'Vendor',
          'report_type' => 'Refund',
          'foreign_id'  => $refund->id,
          'name'        => 'Air-Ticket Refund',
          'debit'       => null,
          'credit'      => $total_purchase - $vendor_charge,
          'balance'     => $vendor->amount + ($total_purchase - $vendor_charge),
        ]);
      }
      
      Session::flash('success', 'The invoice successfully refunded.');
      return redirect()->route('sale.refund.show', $refund->id);
    }

    public function refundShow($id)
    {
        $refund = Refund::find($id);
        // leftJoin('customers', 'customers.id', 'refunds.client_id')
        // ->leftJoin('vendors', 'vendors.id', 'refunds.vendor_id')
        // ->select('refunds.*', 'customers.name as client_name', 'vendors.name as vendor_name')
        // ->find($id);

        $client = Customer::find($refund->client_id);
        $vendor = Vendor::find($refund->vendor_id);

        $items = RefundItem::leftJoin('sales', 'sales.id', 'refund_items.sale_id')
        ->where('refund_items.refund_id', $id)
        ->select('refund_items.*', 'sales.client_price', 'sales.purchase')
        ->get();
        
        return view('layouts.refunds.refund_read', compact('refund', 'items', 'client', 'vendor'));
    }

    public function refundDelete($id)
    {
      $refund_item = RefundItem::find($id);
      $refund = Refund::find($refund_item->refund_id);
      $sale = Sale::select('id', 'client_price', 'purchase')->find($refund_item->sale_id);
      $client = Customer::find($refund->client_id);
      $vendor = Vendor::find($refund->vendor_id);

      try{
        Customer::where('id', $client->id)->update([
          'amount' => $client->balance - ($sale->client_price - $refund_item->client_charge) 
        ]);

        Vendor::where('id', $vendor->id)->update([
          'amount' => $vendor->amount - ($sale->purchase - $refund_item->vendor_charge)
        ]);

        $refund_item->delete();
      }
      catch(\Exception $e)
      {
        return $e->getMessage();
      }

      Session::flash('success', 'The refund successfully deleted.');
      return redirect()->route('sale.refund.index');
    }
}