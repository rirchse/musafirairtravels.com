<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;
use Image;
use File;
use Session;


class EmployeeCtrl extends Controller
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
        $employees = Employee::get();
        return view('layouts.employees.view', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.employees.create');
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
        
    //  $this->validate($request, [
    //     'full_name' => 'required|max:255',
    //     'contact'   => 'required|regex:/(01)[0-9]{9}/|max:11',
    //     'email'     => 'email|max:32|nullable',
    //     'address'   => 'required|max:255',
    //     'status'    => 'max:10',
    //     'details'   => 'max:99999',
    // ]);


     $data = $request->all();

     if(isset($data['_token']))
     {
        unset($data['_token']);
     }

     if(isset($data['image']))
     {
       $data['image'] = $source->uploadImage($data['image'], 'employees/');
     }

     try{
        Employee::insert($data);
     }
     catch(e $message)
     {
        //
     }

    $id = Employee::orderBy('id', 'DESC')->first()->id;

    Session::flash('success', 'Employee successfully saved');
    return redirect()->route('employee.show', $id);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return view('layouts.employees.read',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('layouts.employees.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $source = new SourceCtrl;
        $employee = Employee::find($id);
        $ex_image = public_path($employee->image);
        // $this->validate($request, [
        //     'full_name' => 'required|max:255',
        //     'contact'   => 'required|regex:/(01)[0-9]{9}/|max:11',
        //     'email'     => 'email|max:32|nullable',
        //     'address'   => 'required|max:255',
        //     'status'    => 'max:10',
        //     'details'   => 'max:99999',
        // ]);


        $data = $request->all();

        if(isset($data['_method']))
        {
            unset($data['_method']);
        }

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(!isset($data['status']))
        {
            $data['status'] = '';
        }
        if(isset($data['image']))
        {
            $data['image'] = $source->uploadImage($data['image'], 'employees/');
            if(File::exists($ex_image))
            {
                File::delete($ex_image);
            }
        }

        try{
            Employee::where('id', $id)->update($data);
        }
        catch(e $message)
        {
            //
        }

        Session::flash('success', 'Employee information successfully updated.');
        return redirect()->route('employee.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $ex_image = public_path($employee->image);
        if (File::exists($ex_image)) {
            File::delete($ex_image);
        }
        $employee->delete();
        Session::flash('success', 'Employee successfully deleted');
        return redirect()->route('employee.index');
    }
}
