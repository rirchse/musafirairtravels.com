@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Customer Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Customer Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Customer Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('customer.index')}}" title="View {{Session::get('_types')}} customers" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('customer.edit',$customer->id)}}" class="label label-warning" title="Edit this customer"><i class="fa fa-edit"></i></a>
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}

            @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
            <a href="{{route('customer.delete',$customer->id)}}" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-trash"></i></a>
            @endif
            
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th width=250>Category:</th>
                  <td>{{$customer->category}}</td>
                </tr>
                <tr>
                  <th>Client:</th>
                  <td>{{$customer->client_type}}</td>
                </tr>
                <tr>
                  <th>Full Name:</th>
                  <td>{{$customer->name}}</td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>{{$customer->email}}</td>
                </tr>
                <tr>
                  <th>Contact:</th>
                  <td>{{$customer->contact}}</td>
                </tr>
                <tr>
                  <th>Alternate Contact:</th>
                  <td>{{$customer->contact_2}}</td>
                </tr>
                <tr>
                  <th>WhatsApp:</th>
                  <td>{{$customer->whatsapp}}</td>
                </tr>
                <tr>
                  <th>Gender:</th>
                  <td>{{$customer->gender}}</td>
                </tr>
                <tr>
                  <th>Walking Customer:</th>
                  <td>{{$customer->walking_customer}}</td>
                </tr>
                <tr>
                  <th>Opening Balance Type:</th>
                  <td>{{$customer->balance_type}}</td>
                </tr>
                <tr>
                  <th>Current Balance:</th>
                  <td>{{$customer->amount}}</td>
                </tr>
                <tr>
                  <th>Address:</th>
                  <td>{{$customer->address}}</td>
                </tr>
                <tr>
                  <th>Created On:</th>
                  <td>{{$source->dtformat($customer->created_at) }} </td>
                </tr>
                <tr>
                  <th>Updated On:</th>
                  <td>{{$source->dtformat($customer->updated_at) }} </td>
                </tr>
                {{-- <tr>
                  <th>Created By:</th>
                  <td>{{App\User::find($customer->created_by)?App\User::find($customer->created_by)->name:'Unknown'}}</td>
                </tr> --}}
                {{-- <tr>
                  <th>Updated By:</th>
                  <td>{{App\User::find($customer->updated_by)?App\User::find($customer->updated_by)->name:''}}</td>
                </tr> --}}
                <tr>
                  <th>Photo: </th>
                  <td><a href="{{$customer->image}}" target="_blank"><img src="{{$customer->image}}" width=60></a></td>
                </tr>
                <tr>
                  <th>Pax Name:</th>
                  <td>{{$customer->pax_name}}</td>
                </tr>
                <tr>
                  <th>Pax Type:</th>
                  <td>{{$customer->pax_type}}</td>
                </tr>
                <tr>
                  <th>Pax Mobile Number:</th>
                  <td>{{$customer->pax_mobile}}</td>
                </tr>
                <tr>
                  <th>Pax Email:</th>
                  <td>{{$customer->pax_email}}</td>
                </tr>
                <tr>
                  <th>Passport No.:</th>
                  <td>{{$customer->passport_no}}</td>
                </tr>
                <tr>
                  <th>NID No.:</th>
                  <td>{{$customer->nid}}</td>
                </tr>
                <tr>
                  <th>Date of Birth:</th>
                  <td>{{$source->dformat($customer->birth_date)}}</td>
                </tr>
                <tr>
                  <th>Passport Issue Date:</th>
                  <td>{{$customer->pax_issue_date}}</td>
                </tr>
                <tr>
                  <th>Passport Expire Date:</th>
                  <td>{{$customer->pax_expire_date}}</td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td>{{$customer->details}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          {{-- <p><a href="{{route('customer.delete',$customer->id)}}" onclick="return confirm('Are sure you want to permanently delete this customer?')" class="text-danger" style="padding:15px">x</a></p> --}}
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

              @foreach(App\Sale::where('customer_id', $customer->id)->get() as $sale)
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
