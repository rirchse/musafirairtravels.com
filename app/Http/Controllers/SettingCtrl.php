<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Airline;
use DB;

class SettingCtrl extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function airlines()
  {
    $airlines = DB::table('airlines')->orderBy('id', 'DESC')->paginate(25);
    return view('layouts.settings.airlines', compact('airlines'));
  }

  public function airlinesStore(Request $request)
  {
    $data = $request->all();

    if(isset($data['_token']))
    {
      unset($data['_token']);
    }

    // $array = explode(', ', $data['name']);

    // // dd($array);
    // foreach($array as $key => $arr)
    // {
    //   $data['name'] = $arr;
    //   DB::table('airlines')->insert($data);
    // }
      
    try{
      DB::table('airlines')->insert($data);
    }
    catch(e $e)
    {
      //
    }

    return redirect()->route('airlines');
  }

  public function airlineDelete($id)
  {
    $air = Airline::find($id)->delete();
    return redirect()->route('airlines');
  }
}