@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Employee Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Employee Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Employees</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Employee Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('employee.index')}}" title="View {{Session::get('_types')}} employees" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('employee.edit', $employee->id)}}" class="label label-warning" title="Edit this employee"><i class="fa fa-edit"></i></a>
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}

            @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
            <form style="width:32px; display:inline" action="{{route('employee.destroy', $employee->id)}}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this?');" title="Delete"><i class="fa fa-trash"></i></button></form>
            @endif
            
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th>Full Name:</th>
                  <td>{{$employee->name}}</td>
                </tr>
                <tr>
                  <th>Designation:</th>
                  <td>{{$employee->designation}}</td>
                </tr>
                <tr>
                  <th>Contact:</th>
                  <td>{{$employee->contact}}</td>
                </tr>
                <tr>
                  <th>Alternate Contact:</th>
                  <td>{{$employee->contact_2}}</td>
                </tr>
                <tr>
                  <th>WhatsApp:</th>
                  <td>{{$employee->whatsapp}}</td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>{{$employee->email}}</td>
                </tr>
                <tr>
                  <th>Gender:</th>
                  <td>{{$employee->gender}}</td>
                </tr>
                <tr>
                  <th>Join Date:</th>
                  <td>{{$source->dformat($employee->join_date) }} </td>
                </tr>
                <tr>
                  <th>Updated On:</th>
                  <td>{{$source->dtformat($employee->updated_at) }} </td>
                </tr>
                <tr>
                  <th>Photo: </th>
                  <td><a href="{{$employee->image}}" target="_blank"><img src="{{$employee->image}}" style="width:100%;max-width:200px"></a></td>
                </tr>
                <tr>
                  <th>Date of Birth:</th>
                  <td>{{$source->dformat($employee->birth_date)}}</td>
                </tr>
                <tr>
                  <th>NID No.:</th>
                  <td>{{$employee->nid}}</td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td>{{$employee->details}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          {{-- <p><a href="{{route('employee.delete',$employee->id)}}" onclick="return confirm('Are sure you want to permanently delete this employee?')" class="text-danger" style="padding:15px">x</a></p> --}}
        </div>
      </div><!-- /.box -->

      {{-- <div class="col-md-7">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Invoice History</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-bordered table-hover">
              <tr>
                <th>#Invoice</th>
                <th>Total (tk)</th>
                <th>Paid (tk)</th>
                <th>Due (tk)</th>
                <th>Sales Date</th>
                <th>Status</th>
                <th width="60">Action</th>
              </tr>

              <tbody  id="ordersTable">

              @foreach(App\Sale::where('employee_id', $employee->id)->get() as $sale)
              <tr>
                <td>{{$sale->order_no}}</td>
                <td>{{$sale->gtotal}}</td>
                <td>{{$sale->paid}}</td>
                <td>{{$sale->due}}</td>
                <td>{{date('d M Y', strtotime($sale->sales_date))}}</td>
                <td>
                  @if($sale->status == 0)
                  <span class="label label-info">New Order</span>
                  @elseif($sale->status == 1)
                  <span class="label label-warning">Confirmed</span>
                  @elseif($sale->status == 2)
                  <span class="label label-success">Completed</span>
                  @elseif($sale->status == 3)
                  <span class="label label-danger">Cancelled</span>
                  @endif
                </td>
                <td>
                  <a href="{{route('sale.show',$sale->id)}}" class="label label-info" title="sale Details"><i class="fa fa-file-text"></i></a>
                </td>
              </tr>

              @endforeach
            </tbody>
            </table>
          </div> <!-- /.box-body -->
        </div> <!-- /.box -->
      </div> --}}
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
