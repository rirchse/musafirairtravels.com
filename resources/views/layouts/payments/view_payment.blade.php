@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Payment')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{$type != ''?$type:'All'}} Payments</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">All Payments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Payment</h3>
              <div class="box-tools">
                <a href="{{route('payment.create.type', $type)}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Payment</a>
                <style type="text/css">
                .payment_item{padding: 5px 10px;border:1px solid #ddd;display: inline-block;}
                </style>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Id</th>
                  {{-- <th>#Invoice</th> --}}
                  <th>Name</th>
                  <th>Contact Number</th>
                  <th>Previous Balance</th>
                  <th>Paid (Tk.)</th>
                  <th>Balance (Tk.)</th>
                  <th>Payment By</th>
                  <th>Date</th>
                  <th width="70">Action</th>
                </tr>

                <?php $balance = 0; ?>

                @foreach($payments as $payment)
                <?php $balance += $payment->paid_amount;?>

                <tr>
                  <td>{{$payment->id}}</td>
                  <td>{{$payment->name}}</td>
                  <td>{{$payment->contact}}</td>
                  <td>{!! $source->balance($payment->pre_balance) !!}</td>
                  <td>{{$payment->amount}}</td>
                  <td>{!! $source->balance($payment->balance) !!}</td>
                  <td>{{$payment->account_name}}</td>
                  <td>{{$source->dformat($payment->date)}}</td>
                  <td>
                    <a href="{{route('payment.type.show', [$payment->user_type, $payment->id])}}" class="label label-info" title="Payment Details"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="{{route('payment.edit',$payment->id)}}" class="label label-warning" title="Edit this payment"><i class="fa fa-edit"></i></a> --}}

                    @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                    {{-- <a href="{{route('payment.delete', $payment->id)}}" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a> --}}
                    @endif

                  </td>
                </tr>

                @endforeach
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
@endsection
