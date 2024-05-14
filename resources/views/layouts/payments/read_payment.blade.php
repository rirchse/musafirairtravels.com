@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Payment Details')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>{{$payment->user_type}} Payment Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- left column -->
    <div class="col-md-6"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Payment Information</h3>
        </div>
        <div class="col-md-12 text-right toolbar-icon">
          <a href="{{route('payment.type.index', $payment->user_type)}}" title="View payments" class="label label-success"><i class="fa fa-list"></i></a>
          {{-- <a href="{{route('payment.edit',$payment->id)}}" class="label label-warning" title="Edit this payment"><i class="fa fa-edit"></i></a> --}}
          <a href="{{route('payment.print', $payment->id)}}" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
          
          <form action="{{route('payment.destroy', $payment->id)}}"  method="POST" style="width:32px;display:inline">
            @csrf
            @method('delete')
            <button type="submit" class="label label-danger" onclick="return confirm('Are you sure want to delete this?');" title="Delete this account"><i class="fa fa-trash"></i></button>
          </form>
        </div>
        <div class="col-md-12">
          <table class="table">
            <tbody>
              {{-- <tr>
                <th>Payment Id:</th>
                <td>{{$payment->sales_id}}</td>
              </tr>
              <tr>
                <th>Invoice Number:</th>
                <td>{{$payment->invoice_id}}</td>
              </tr> --}}
              <tr>
                <th>{{$payment->user_type}} Name:</th>
                <td>{{$payment->name}}</td>
              </tr>
              {{-- <tr>
                <th>User Type:</th>
                <td>{{$payment->user_type}}</td>
              </tr> --}}
              <tr>
                <th>Previous Balance:</th>
                <td>{!! $source->balance($payment->pre_balance) !!}</td>
              </tr>
              <tr>
                <th>Paid Amount:</th>
                <td>{{$payment->amount}}</td>
              </tr>
              <tr>
                <th>Current Balance:</th>
                <td>{!! $source->balance($payment->balance) !!}</td>
              </tr>
              <tr>
                <th>Payment Method:</th>
                <td>{{$payment->account_name}}</td>
              </tr>
              <tr>
                <th>Payment Date:</th>
                <td>{{$source->dformat($payment->date)}}</td>
              </tr>
              {{-- <tr>
                <th>Received By:</th>
                <td>{{$payment->received_by}}</td>
              </tr> --}}
                               
              <tr>
                <th>Deteils:</th>
                <td>{{$payment->details}}</td>
              </tr>
              {{-- <tr>
                <th>Status:</th>
                <td>
                  @if($payment->status == 0)
                  <span class="label label-warning">Unactive</span>
                  @elseif($payment->status == 1)
                  <span class="label label-success">Active</span>
                  @elseif($payment->status == 2)
                  <span class="label label-danger">Disabled</span>
                  @endif
                </td>
              </tr> --}}
              <tr>
                <th>Record Created On:</th>
                <td>{{$source->dtformat($payment->created_at)}} </td>
              </tr>                 
            </tbody>
          </table>
        </div>
        <div class="clearfix"></div>
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</section><!-- /.content -->

@endsection
