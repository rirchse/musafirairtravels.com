<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Sale;
use App\Payment;
use App\Expense;
use App\InvoiceOther;
use App\Account;

class HomeCtrl extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    public function signup(Request $request)
    {
        return view('home');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Auth::user()->authorizeRoles(['SuperAdmin', 'Admin', 'Editor', 'Sales']);
        $daily = $monthly = $yearly = [];

        /** daily reports */
        $sale = Sale::whereRaw('DATE(created_at) >=?', [date('Y-m-d')])
        ->whereRaw('DATE(created_at) <= ?', [date('Y-m-d')])
        ->sum('client_price');

        $other = InvoiceOther::whereRaw('DATE(created_at) >= ?', [date('Y-m-d')])
        ->whereRaw('DATE(created_at) <= ?', [date('Y-m-d')])
        ->sum('total_sale');

        $receive = Payment::whereRaw('DATE(date) >= ?', [date('Y-m-d')])
        ->whereRaw('DATE(date) <= ?', [date('Y-m-d')])
        ->where('user_type', 'Client')
        ->sum('amount');

        $expense = Expense::where('type', 'Office Rent')
        ->whereAnd('type', 'Electricity Bill')
        ->whereAnd('type', 'Gas Bill')
        ->whereRaw('DATE(expense_date) >= ?', [date('Y-m-d')])
        ->whereRaw('DATE(expense_date) <= ?', [date('Y-m-d')])
        ->sum('amount');

        $daily['sale'] = $sale + $other;
        $daily['receive'] = $receive;
        $daily['expense'] = $expense;

        /** account details */
        $accounts = Account::all();
        // dd($accounts);
        return view('layouts.index', compact('daily', 'monthly', 'yearly', 'accounts'));
    }

    /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');
        return view(‘some.view’);
      }
      */
}
