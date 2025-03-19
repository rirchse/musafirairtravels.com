<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Customer;
use App\Vendor;
use App\Airline;
use App\Payment;
use App\Report;
use App\Invoice;
use App\Refund;
use DB;

class ReportCtrl extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function create()
  {
    return view('layouts.reports.create');
  }


  public function saleCreate()
  {
    $airlines = Airline::all();
    $vendors = Vendor::all();
    $customers = Customer::all();
    return view('layouts.reports.index', compact('airlines','vendors','customers'));
  }

  public function saleIndex(Request $request)
  {
    $airlines = Airline::all();
    $vendors = Vendor::all();
    $customers = Customer::all();

    $data = $request->all();
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];

    $sales = Sale::leftJoin('customers', 'customers.id', 'sales.customer_id')
    ->leftJoin('vendors', 'vendors.id', 'sales.vendor_id')
    ->orderBy('sales.created_at', 'ASC');

    if(isset($data['sale_type']))
    {
      $sales = $sales->where('type', $data['sale_type']);
    }
    
    if(isset($data['vendor']))
    {
      $sales = $sales->where('vendor_id', $data['vendor']);
    }
    
    if(isset($data['client']))
    {
      $sales = $sales->where('customer_id', $data['client']);
    }
    
    if(isset($data['airline']))
    {
      $sales = $sales->where('airline', $data['airline']);
    }

    if($start_date && $end_date)
    {
      $sales = $sales->whereRaw('DATE(sales.created_at) >= ?', [$start_date])
      ->whereRaw('DATE(sales.created_at) <= ?', [$end_date]);
    }

    $sales = $sales->select('sales.*', 'customers.name as client_name', 'vendors.name as vendor_name')->get();

    return view('layouts.reports.index', compact('sales', 'airlines','vendors','customers'));
  }

  public function clientReport()
  {
    $clients = Customer::all();
    return view('layouts.reports.client_report', compact('clients'));
  }

  public function clientPost(Request $request)
  {
    $airlines = Airline::all();
    $vendors = Vendor::all();
    $clients = Customer::all();

    $data = $request->all();
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];

    $sales = Report::leftJoin('customers', 'customers.id', 'reports.user_id')
    ->orderBy('reports.id', 'ASC')
    ->where('user_type', $data['user_type']);
    
    if(isset($data['client']))
    {
      $sales = $sales->where('reports.user_id', $data['client']);
    }

    if($start_date && $end_date)
    {
      $sales = $sales->whereRaw('DATE(reports.created_at) >= ?', [$start_date])
      ->whereRaw('DATE(reports.created_at) <= ?', [$end_date]);
    }

    $sales = $sales->select('reports.*', 'customers.name as user_name')
    ->get();

    $reports = [];
    foreach($sales as $val)
    {
      if($val->report_type == 'Air-Ticket' || $val->report_type == 'Non-Commission' || $val->report_type == 'Reissue')
      {
        $val['foreign'] = Sale::where('invoice_id', $val->foreign_id)
        ->select('sales.pax_name', 'sales.pnr', 'sales.ticket_no', 'sales.route')->get();
      }

      if($val->report_type == 'VISA' || $val->report_type == 'Hotel' || $val->report_type == 'Other')
      {
        $val['foreign'] = DB::table('invoice_others')->where('client_id', $val->user_id)
        ->get();
      }

      if($val->report_type == 'Refund')
      {
        $val['foreign'] = DB::table('refund_items')
        ->where('refund_id', $val->foreign_id)
        ->leftJoin('sales', 'sales.id', 'refund_items.sale_id')
        ->select('refund_items.*', 'sales.pax_name', 'sales.ticket_no', 'sales.pnr', 'sales.route')
        ->get();
      }

      if($val->report_type == 'Payment')
      {
        $val['foreign'] = Payment::leftJoin('accounts', 'accounts.id', 'payments.account_id')
        ->select('payments.*', 'accounts.name')
        ->find($val->foreign_id);
      }

      array_push($reports, $val);
    }
    $sales = $reports;

    $customer = [];
    if(isset($data['client']))
    {
      $customer = Customer::find($data['client']);
    }

    return view('layouts.reports.client_report', compact('sales', 'airlines','vendors', 'clients', 'data', 'customer'));
  }

  public function vendorReport()
  {
    $vendors = Vendor::all();
    return view('layouts.reports.vendor_report', compact('vendors'));
  }

  public function vendorPost(Request $request)
  {
    $airlines = Airline::all();
    $vendors = Vendor::all();
    $clients = Customer::all();

    $data = $request->all();
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];

    $sales = Report::leftJoin('vendors', 'vendors.id', 'reports.user_id')
    ->orderBy('reports.id', 'ASC')
    ->where('user_type', $data['user_type']);
    
    if(isset($data['vendor']))
    {
      $sales = $sales->where('reports.user_id', $data['vendor']);
    }

    if($start_date && $end_date)
    {
      $sales = $sales->whereRaw('DATE(reports.created_at) >= ?', [$start_date])
      ->whereRaw('DATE(reports.created_at) <= ?', [$end_date]);
    }

    $sales = $sales->select('reports.*', 'vendors.name as user_name')
    ->get();

    $reports = [];
    foreach($sales as $val)
    {
      if($val->report_type == 'Air-Ticket' || $val->report_type == 'Non-Commission' || $val->report_type == 'Reissue')
      {
        $val['foreign'] = Sale::where('invoice_id', $val->foreign_id)
        ->select('sales.pax_name', 'sales.pnr', 'sales.ticket_no', 'sales.route')->get();
      }

      if($val->report_type == 'VISA' || $val->report_type == 'Hotel' || $val->report_type == 'Other')
      {
        $val['foreign'] = DB::table('invoice_others')->where('client_id', $val->user_id)
        ->get();
      }

      if($val->report_type == 'Refund')
      {
        $val['foreign'] = DB::table('refund_items')
        ->where('refund_id', $val->foreign_id)
        ->leftJoin('sales', 'sales.id', 'refund_items.sale_id')
        ->select('refund_items.*', 'sales.pax_name', 'sales.ticket_no', 'sales.pnr', 'sales.route')
        ->get();
      }

      if($val->report_type == 'Payment')
      {
        $val['foreign'] = Payment::leftJoin('accounts', 'accounts.id', 'payments.account_id')
        ->select('payments.*', 'accounts.name')
        ->find($val->foreign_id);
      }

      array_push($reports, $val);
    }
    $sales = $reports;

    $vendor = [];
    if(isset($data['vendor']))
    {
      $vendor = Vendor::find($data['vendor']);
    }

    return view('layouts.reports.vendor_report', compact('sales', 'airlines','vendors', 'clients', 'vendor'));
  }

  // public function reportTest()
  // {
  //   $data = [
  //     'user_id' => 1,
  //     'user_type' => 'Client',
  //     'report_type' => 'Air-Ticket',
  //     'foreign_id' => 1,
  //     'name' => 'Air-Ticket Report',
  //     'debit' => 500,
  //     'credit' => 500,
  //     'balance' => 500,
  //   ];

  //   return $this->storeReport($data);
  // }

  public function storeReport(array $data)
  {
    try{
      Report::insert($data);
    }
    catch(\E $e)
    {
      return $e;
    }
    return true;
  }

  // public function tempReportUpdate()
  // {
  //   $reports = Report::where('user_type', 'Vendor')->where('report_type', '!=', 'Payment')->where('report_type', '!=', 'Refund')->get();
  //   // dd($reports);
    
  //   foreach($reports as $val)
  //   {
  //     // if($val->debit == NULL)
  //     if($val->debit && $val->credit)
  //     {
  //       Report::where('id', $val->id)->update(['debit' => $val->credit, 'credit' => NULL]);
  //     }
  //   }
  // }

}