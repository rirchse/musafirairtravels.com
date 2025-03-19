<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Vendor;
use Auth;
use Image;
use File;
use Session;


class VendorCtrl extends Controller
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
        $vendors = Vendor::orderBy('business_name','ASC')->paginate(25);
        return view('layouts.vendors.view_vendor', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.vendors.create_vendor');
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
        // dd($data);
        
       $this->validate($request, [
            'name'              => 'required|max:255',
            'business_name'     => 'required|max:255',
            'contact'           => 'required|max:18',            
        ]);
        $vendor_id = 0;

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['image']))
        {
        $data['image'] = $source->uploadImage($data['image'], 'vendors/');
        }

        try{
            Vendor::insert($data);
        }
        catch(e $message)
        {
            //
        }
        $vendor_id = Vendor::orderBy('id', 'DESC')->first()->id;

        Session::flash('success', 'Vendor Successfully Saved');
        return redirect()->route('vendor.show', $vendor_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::find($id);
        return view('layouts.vendors.read_vendor', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor =vendor::find($id);
        return view('layouts.vendors.edit_vendor', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'              => 'required|max:255',
            'business_name'     => 'required|max:255',
            'contact'           => 'required|max:18',            
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
        
        try{
            Vendor::where('id', $id)->update($data);
        }
        catch(e $message)
        {

        }

        Session::flash('success', 'Vendor Successfully Update');
        return redirect()->route('vendor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
             if (File::exists('img/vendor/' .$vendor->image)) {
                File::delete('img/vendor/' .$vendor->image);
            }
            $vendor->delete();
        Session::flash('success', 'Vendor Successfully Deleted');
        return redirect()->route('vendor.index');
    }


    /** other required methods */
    public function search(Request $request)
    {
        $data = $request->all();
        if(isset($data['search']))
        {
            $vendors = Vendor::orderBy('id', 'DESC')
            ->where('name', 'Like', '%'.$data['search'].'%')
            ->orWhere('contact', 'Like', '%'.$data['search'].'%')
            ->orWhere('email', 'Like', '%'.$data['search'].'%')
            ->orWhere('business_name', 'Like', '%'.$data['search'].'%')
            ->paginate(25);
            return view('layouts.vendors.view_vendor', compact('vendors'));
        }
        else 
        {
           return $this->index();
        }
    }
    
}
