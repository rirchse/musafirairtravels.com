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
use Auth;
use DB;

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
    
    return view('layouts.accounts.statement', compact('payments', 'data'));
  }

  /** fund transfer */
  public function fundTransfer($id)
  {
    $account = Account::find($id);
    $accounts = Account::all();
    return view('layouts.accounts.fund_transfer', compact('account', 'accounts'));
  }

  public function fundTransferStore(Request $request)
  {
    $data = $request->all();
    if(isset($data['_token']))
    {
      unset($data['_token']);
    }

    $account_from = Account::find($data['account_from']);
    $account_to = Account::find($data['account_to']);

    $from_balance = $account_from->balance - $data['amount'];
    $to_balance = $account_to->balance + $data['amount'];

    $data['account_from_balance'] = $from_balance;
    $data['account_to_balance'] = $to_balance;

    $data['created_by'] = Auth::id();

    try{
      DB::table('fund_transfers')->insert($data);
    }
    catch(\E $e)
    {
      return $e;
    }

    /** update from account */
    Account::where('id', $account_from->id)->update(['balance' => $from_balance]);

    /** update to account */
    Account::where('id', $account_to->id)->update(['balance' => $to_balance]);

    Session::flash('success', 'Fund transfer successfully completed');
    return redirect()->route('account.index');
  }

  public function fundTransferIndex()
  {
    $transfers = DB::table('fund_transfers')
    ->leftJoin('accounts as account_from', 'account_from.id', 'fund_transfers.account_from')
    ->leftJoin('accounts as account_to', 'account_to.id', 'fund_transfers.account_to')
    ->orderBy('fund_transfers.id', 'DESC')
    ->select('fund_transfers.*', 'account_from.bank_name as from_name', 'account_to.bank_name as to_name')
    ->paginate(25);
    
    return view('layouts.accounts.fund_transfer_index', compact('transfers'));
  }
}