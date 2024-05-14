<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Sale;
use App\InvoiceOther;
use App\Customer;
use App\Vendor;
use App\Expense;
use App\Payment;
use App\Account;
use Session;

class AccountCtrl extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $accounts = Account::orderBy('id', 'DESC')->paginate(25);
    return view('layouts.accounts.index', compact('accounts'));
  }

  public function create()
  {
    return view('layouts.accounts.create');
  }

  public function store(Request $request)
  {
    $data = $request->all();
    if(isset($data['_token']))
    {
      unset($data['_token']);
    }

    // dd($data);

    try{
      Account::insert($data);
    }
    catch(\E $e)
    {
      return $e;
    }

    Session::flash('success', 'The account successfully created.');
    return redirect()->route('account.index');
  }

  public function edit($id)
  {
    $account = Account::find($id);
    return view('layouts.accounts.edit', compact('account'));
  }

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

    try{
      Account::where('id', $id)->update($data);
    }
    catch(\E $e)
    {
      return $e;
    }

    Session::flash('success', 'The account successfully updated.');
    return redirect()->route('account.index');
  }

  /** ajax call */
  public function getBalance($id)
  {
    $account = Account::find($id);
    return response()->json(['account' => $account->balance], 200);
  }



  /** ----------------------- */

  public function statement()
  {
    return view('layouts.accounts.statement');
  }

  public function getStatement(Request $request)
  {
    $data = $request->all();

    $start_date = $data['start_date'];
    $end_date = $data['end_date'];

    $payments = Payment::orderBy('date', 'ASC');

    if($data['payment_by'])
    {
      $payments = $payments->where('payment_by', $data['payment_by']);
    }

    if($start_date && $end_date)
    {
      $payments = $payments->whereRaw('DATE(date) >= ?', [$start_date])
      ->whereRaw('DATE(date) <= ?', [$end_date]);
    }

    $payments = $payments->get();
    // dd($payments);
    return view('layouts.accounts.statement', compact('payments', 'data'));
  }
}