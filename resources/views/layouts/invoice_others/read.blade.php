@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$sale = $invoice;
@endphp

@extends('dashboard')
@section('title', 'Invoice Details')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Invoice {{$sale->type}} Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Invoices</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- row -->
    <div class="col-md-7"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border"> <h3 style="color: #800" class="box-title">Invoice Information</h3></div>
        <div class="col-md-12 text-right toolbar-icon">

          @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
          <a href="{{route('invoice.type.create', $sale->type)}}" title="Add Invoice" class="label label-info"><i class="fa fa-plus"></i></a>
          @endif

          <a href="{{route('invoice.type.index', $sale->type)}}" title="View sales" class="label label-success"><i class="fa fa-list"></i></a>
          <a href="{{route('invoice.type.edit', [$sale->type, $sale->id])}}" class="label label-warning" title="Edit"><i class="fa fa-edit"></i></a>
          <a href="{{route('invoice.other.print', $sale->id)}}" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
          
          @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
          <a href="{{route('invoice.type.delete',$sale->id)}}" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a>
          @endif
        </div>
        <div class="col-md-12">
          <table class="table">
            <tbody>
              <tr>
                <th>Invoice Number:</th>
                <td><b># {{$sale->id}}</b></td>
              </tr>
              <tr>
                <th>Product:</th>
                <td><b>{{$sale->type}}</b></td>
              </tr>
              <tr>
                <th>Client Name:</th>
                <td>{{$sale->client_name}}</td>
              </tr>
              @if($sale->type == 'Hotel')
              <tr>
                <th>Hotel Name:</th>
                <td>{{$sale->hotel_name}}</td>
              </tr>
              <tr>
                <th>Room No.:</th>
                <td>{{$sale->room_no}}</td>
              </tr>
              @endif
              @if($sale->type == 'VISA')
              <tr>
                <th>Country:</th>
                <td>{{$sale->country}}</td>
              </tr>
              <tr>
                <th>Visa Type:</th>
                <td>{{$sale->visa_type}}</td>
              </tr>
              <tr>
                <th>Token:</th>
                <td>{{$sale->token}}</td>
              </tr>
              <tr>
                <th>Delivery:</th>
                <td>{{$sale->delivery}}</td>
              </tr>
              <tr>
                <th>Visa No.:</th>
                <td>{{$sale->visa_no}}</td>
              </tr>
              <tr>
                <th>Mofa No.:</th>
                <td>{{$sale->mofa_no}}</td>
              </tr>
              <tr>
                <th>Okala No.:</th>
                <td>{{$sale->okala_no}}</td>
              </tr>
              @endif
              <tr>
                <th>Quantity:</th>
                <td>{{$sale->quantity}}</td>
              </tr>
              <tr>
                <th>Unit Price:</th>
                <td>{{$sale->unit_price}}</td>
              </tr>
              <tr>
                <th>Total Sale:</th>
                <td>{{$sale->total_sale}}</td>
              </tr>
              <tr>
                <th>Purchase Price:</th>
                <td>{{$sale->cost_price}}</td>
              </tr>
              <tr>
                <th>Profit:</th>
                <td>{{$sale->profit}}</td>
              </tr>
              <tr>
                <th>Vendor:</th>
                <td>{{$sale->vendor_name}} </td>
              </tr>
              <tr>
                <th>Details:</th>
                <td>{{$sale->details}}</td>
              </tr>
              <tr>
                <th>Created At:</th>
                <td>{{$source->dformat($sale->created_at)}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="clearfix"></div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->


    {{-- <div class="col-md-5">
      <div class="box box-primary">
        <div class="box-header with-border"><h3 style="color: #800" class="box-title">Payment History <b>[Invoice Number #{{$sale->invoice_id}}]</b></h3>
        </div>
        <table class="table">
          <tr>
            <th>Payment Date</th>
            <th>Amount</th>
            <th>Payment Type</th>
          </tr>
          @php $total_paid =0; @endphp
          <tr>
            <td colspan=3>Total Paid: <b>{{$total_paid}}</b> tk</td>
          </tr>
        </table>
      </div>
    </div> --}}
  </div><!-- /.row -->
</section><!-- /.content -->

@endsection
