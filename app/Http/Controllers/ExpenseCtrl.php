<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Vendor;
use App\Expense;
use App\Employee;
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
        $expenses = Expense::orderBy('id','desc')->get();
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
        return view('layouts.expenses.create', compact('users', 'employees'));
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
        ->select('expenses.*', 'employees.name')
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
        return view('layouts.expenses.edit', compact('expense', 'users'));
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

        Session::flash('success', 'The Expense Successfully Deleted');
        return redirect()->route('expense.index');
    }
    
}