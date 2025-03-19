<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Vendor;
use App\Expense;
use App\Employee;
use App\Sale;
use App\Refund;
use App\RefundItem;
use App\Account;
use Auth;
use Image;
use File;
use Session;


class ExpenseCtrl extends Controller
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
        $expenses = Expense::orderBy('id','desc')
        ->leftJoin('accounts', 'accounts.id', 'expenses.account_id')
        ->select('expenses.*', 'accounts.name')
        ->get();
        return view('layouts.expenses.index', compact('expenses'));
    }

    public function filter(Request $request)
    {
        $data = $request->all();
        $expenses = Expense::orderBy('id','DESC')
        ->leftJoin('accounts', 'accounts.id', 'expenses.account_id')
        ->leftJoin('employees', 'employees.id', 'expenses.pay_to')
        ->select('expenses.*', 'accounts.name', 'employees.name as paid_to')
        ->get();
        return view('layouts.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('name', 'id')->get();
        $employees = Employee::get();
        $accounts = Account::all();
        return view('layouts.expenses.create', compact('users', 'employees', 'accounts'));
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
        $data = $request->all();
        
    //    $this->validate($request, [
    //         'name'              => 'required|max:255',
    //         'business_name'     => 'required|max:255',
    //         'contact'           => 'required|max:11',            
    //     ]);

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['image']))
        {
           $data['image'] = $source->uploadImage($data['image'], 'expense/');
        }

        $account = Account::find($data['account_id']);
        if($account)
        {
            $balance = $account->balance - $data['amount'];
            $data['account_bal'] = $balance;
            Account::where('id', $account->id)->update(['balance' => $balance]);
        }

        try{
            Expense::insert($data);
        }
        catch(e $message)
        {
            //
        }
        $expense_id = Expense::orderBy('id', 'DESC')->first()->id;

        Session::flash('success', 'Expense Successfully Saved');
        return redirect()->route('expense.show', $expense_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::leftJoin('employees', 'employees.id', 'expenses.pay_to')
        ->leftJoin('accounts', 'expenses.account_id', 'accounts.id')
        ->select('expenses.*', 'employees.name', 'accounts.bank_name')
        ->find($id);
        return view('layouts.expenses.read', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::find($id);
        $users = User::select('name', 'id')->get();
        $accounts = Account::all();
        return view('layouts.expenses.edit', compact('expense', 'users', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $source = New SourceCtrl;
        $expense = Expense::find($id);
        $ex_image = public_path($expense->image);

        $this->validate($request, [
            'title'    => 'nullable|max:255',
            'type'     => 'required|max:255',
            'amount'   => 'required|max:11',            
        ]);
        
        $data = $request->all();

        if(isset($data['_method']))
        {
            unset($data['_method']);
        }
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }
        
        if(isset($data['image']))
        {
           $data['image'] = $source->uploadImage($data['image'], 'expense/');
           
           if (File::exists($ex_image))
            {
                File::delete($ex_image);
            }
        }
        
        try{
            Expense::where('id', $id)->update($data);
        }
        catch(e $message)
        {
            //
        }

        Session::flash('success', 'The Expense Successfully Update');
        return redirect()->route('expense.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $ex_image = public_path($expense->image);
        if (File::exists($ex_image))
        {
            File::delete($ex_image);
        }
        // dd(File::exists(public_path($expense->image)));
        $expense->delete();

        // update account
        $account = Account::find($expense->account_id);
        if($account)
        {
            $balance = $account->balance + $expense->amount;
            Account::where('id', $account->id)->update(['balance' => $balance]);
        }

        Session::flash('success', 'The Expense Successfully Deleted');
        return redirect()->route('expense.index');
    }

    public function tracking()
    {
        $office = $salary = $agent = $discount = $other = $total = 0;
        $data = [];
        $expense = Expense::all();
        foreach($expense as $val)
        {
            if($val->type == 'Office Rent' || $val->type == 'Electricity Bill' || $val->type == 'Gas Bill')
            {
                $office += $val->amount;
            }
            elseif($val->type == 'Staff Salary' || $val->type == 'Staff Bonus')
            {
                $salary += $val->amount;
            }
            else
            {
                $other += $val->amount;
            }
        }

        $data['ait'] = Sale::sum('ait');
        $data['bank_charge'] = Expense::where('type', 'Bank Charge')->sum('amount');

        $data['office'] = $office;
        $data['salary'] = $salary;
        $data['agent'] = $agent;
        $data['discount'] = Sale::sum('discount');
        $data['other'] = $other;
        $data['total'] = $office + $salary + $agent + $discount + $other;

        /** sales and profit */
        $data['sales'] = Sale::sum('client_price');
        $data['purchase'] = Sale::sum('purchase');
        $data['profit'] = Sale::sum('profit');
        $data['tour_profit'] = 0;
        $data['service_charge'] = 0;
        $data['refund'] = RefundItem::sum('client_charge') - RefundItem::sum('vendor_charge');
        $data['void'] = 0;
        $data['gross_profit'] = $data['profit']+$data['refund'];

        return view('/layouts.expenses.tracking', compact('data'));
    }
    
    public function earningPost(Request $request)
    {
        $office = $salary = $agent = $discount = $other = $total = 0;
        $data = [];
        $expense = Expense::whereRaw('DATE(expense_date) >= ?', [$request->start_date])->whereRaw('DATE(expense_date) <= ?', [$request->end_date])->get();
        foreach($expense as $val)
        {
            if($val->type == 'Office Rent' || $val->type == 'Electricity Bill' || $val->type == 'Gas Bill')
            {
                $office += $val->amount;
            }
            elseif($val->type == 'Staff Salary' || $val->type == 'Staff Bonus')
            {
                $salary += $val->amount;
            }
            else
            {
                $other += $val->amount;
            }
        }

        $data['ait'] = Sale::whereRaw('DATE(created_at) >= ?', [$request->start_date])->whereRaw('DATE(created_at) <= ?', [$request->end_date])->sum('ait');
        
        $data['bank_charge'] = Expense::whereRaw('DATE(expense_date) >= ?', [$request->start_date])->whereRaw('DATE(expense_date) <= ?', [$request->end_date])->where('type', 'Bank Charge')->sum('amount');

        $data['office'] = $office;
        $data['salary'] = $salary;
        $data['agent'] = $agent;

        $data['discount'] = Sale::whereRaw('DATE(created_at) >= ?', [$request->start_date])->whereRaw('DATE(created_at) <= ?', [$request->end_date])->sum('discount');

        $data['other'] = $other;
        $data['total'] = $office + $salary + $agent + $discount + $other;

        /** sales and profit */
        $data['sales'] = Sale::whereRaw('DATE(created_at) >= ?', [$request->start_date])->whereRaw('DATE(created_at) <= ?', [$request->end_date])->sum('client_price');

        $data['purchase'] = Sale::whereRaw('DATE(created_at) >= ?', [$request->start_date])->whereRaw('DATE(created_at) <= ?', [$request->end_date])->sum('purchase');

        $data['profit'] = Sale::whereRaw('DATE(created_at) >= ?', [$request->start_date])->whereRaw('DATE(created_at) <= ?', [$request->end_date])->sum('profit');

        $data['tour_profit'] = 0;
        $data['service_charge'] = 0;

        $data['refund'] = RefundItem::leftJoin('refunds', 'refunds.id', 'refund_items.refund_id')
        ->whereRaw('DATE(refunds.date) >= ?', [$request->start_date])->whereRaw('DATE(refunds.date) <= ?', [$request->end_date])
        ->sum('refund_items.client_charge') - RefundItem::leftJoin('refunds', 'refunds.id', 'refund_items.refund_id')
        ->whereRaw('DATE(refunds.date) >= ?', [$request->start_date])->whereRaw('DATE(refunds.date) <= ?', [$request->end_date])
        ->sum('refund_items.vendor_charge');

        $data['void'] = 0;
        $data['gross_profit'] = $data['profit'] + $data['refund'];
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        return view('/layouts.expenses.tracking', compact('data'));
    }
}