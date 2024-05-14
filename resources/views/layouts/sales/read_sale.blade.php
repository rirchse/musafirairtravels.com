@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Invoice Details')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Invoice {{$invoice->type}} Details</h1>
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
        <div class="box-header with-border"> <h3 style="color: #800" class="box-title">Invoices Information</h3></div>
        <div class="col-md-12 text-right toolbar-icon">

          @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
          <a href="{{route('sale.create.type', $invoice->type)}}" title="Add Invoice" class="label label-info"><i class="fa fa-plus"></i></a>
          @endif

          <a href="{{route('sale.view.type', $invoice->type)}}" title="View" class="label label-success"><i class="fa fa-list"></i></a>
          
          <a href="{{route('sale.invoice.print', $invoice->id)}}" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
          
          @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
          <a href="{{route('sale.delete', $invoice->id)}}" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a>
          @endif
        </div>
        <div class="col-md-12">
          <table class="table">
              <tr>
                <th colspan="2" style="text-align:center"><h4>Invoice Details:</h4></th>
              </tr>
              <tr>
                <th>Invoice Number:</th>
                <td><b># {{$invoice->id}}</b></td>
              </tr>
              <tr>
                <th>Sale:</th>
                <td>{{$invoice->sale}}</td>
              </tr>
              <tr>
                <th>Purchase:</th>
                <td>{{$invoice->purchase}}</td>
              </tr>
              <tr>
                <th>Profit:</th>
                <td>{{$invoice->profit}}</td>
              </tr>
          </table>
          <table class="table">
            <tr>
              <th colspan="7" style="text-align:center"><h4>Ticket Details:</h4></th>
            </tr>
              <tr>
                <th>SL</th>
                <th>Ticket No.</th>
                <th>Pax Name</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            @foreach($sales as $key => $sale)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$sale->ticket_no}}</td>
                <td>{{$sale->pax_name}}</td>
                <td>{{$sale->gross_fare}}</td>
                <td>{{$sale->discount}}</td>
                <td>{{$sale->gross_fare - $sale->discount}}</td>
                <td>
                  <a class="label label-info" onclick="showHide(this)"><i class="fa fa-angle-down"></i> View</a>
                  <a href="{{route('sale.edit', $sale->id)}}" class="label label-warning" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
              </tr>

              <tr class="hide">
                <td colspan="7">
                  <table class="table">
                    <tr>
                      <th>Ticket Number:</th>
                      <td>{{$sale->ticket_no}}</td>
                    </tr>
                    <tr>
                      <th>Customer Name:</th>
                      <td>{{$sale->name}}</td>
                    </tr>
                    <tr>
                      <th>Mobile Number:</th>
                      <td>{{$sale->contact}}</td>
                    </tr>
                    <tr>
                      <th>Email Address:</th>
                      <td>{{$sale->email}}</td>
                    </tr>
                    <tr>
                      <th>Passport No.:</th>
                      <td>{{$sale->passport_no}}</td>
                    </tr>
                    <tr>
                      <th>Vendor:</th>
                      <td>{{$sale->vendor_name}}</td>
                    </tr>
                    <tr>
                      <th>Airline:</th>
                      <td>{{$sale->airline}}</td>
                    </tr>
                    @if($sale->type == 'Air-Ticket')
                    <tr>
                      <th>Gross Fare(Sale):</th>
                      <td>{{$sale->gross_fare}}</td>
                    </tr>
                    <tr>
                      <th>Base Fare(Buy):</th>
                      <td>{{$sale->base_fare}} </td>
                    </tr>
                    <tr>
                      <th>Commission %:</th>
                      <td>{{$sale->commission}}</td>
                    </tr>
                    <tr>
                      <th>Commission Amount:</th>
                      <td>{{$sale->commission_amount}}</td>
                    </tr>
                    <tr>
                      <th>Net Commission:</th>
                      <td>{{$sale->net_commission}}</td>
                    </tr>
                    <tr>
                      <th>AIT:</th>
                      <td>{{$sale->ait}}</td>
                    </tr>
                    <tr>
                      <th>Discount:</th>
                      <td>{{$sale->discount}}</td>
                    </tr>
                    <tr>
                      <th>Other Bonus:</th>
                      <td>{{$sale->other_bonus}}</td>
                    </tr>
                    <tr>
                      <th>Extra Fee:</th>
                      <td>{{$sale->extra_fee}}</td>
                    </tr>
                    <tr>
                      <th>Other Expense:</th>
                      <td>{{$sale->other_expense}}</td>
                    </tr>
                    <tr>
                      <th>VAT:</th>
                      <td>{{$sale->vat}}</td>
                    </tr>
                    <tr>
                      <th>Tax:</th>
                      <td>{{$sale->tax}}</td>
                    </tr>
                    <tr>
                      <th>GDS:</th>
                      <td>{{$sale->gds}}</td>
                    </tr>
                    <tr>
                      <th>Segment:</th>
                      <td>{{$sale->segment}}</td>
                    </tr>
                    @endif
                    <tr>
                      <th>Route/Sector:</th>
                      <td>{{$sale->route}}</td>
                    </tr>
                    <tr>
                      <th>PNR:</th>
                      <td>{{$sale->pnr}}</td>
                    </tr>
                    <tr>
                      <th>Issue Date:</th>
                      <td>{{$source->dformat($sale->issue_date)}}</td>
                    </tr>
                    <tr>
                      <th>Journey Date:</th>
                      <td>{{$source->dformat($sale->journey_date)}}</td>
                    </tr>
                    <tr>
                      <th>Return Date:</th>
                      <td>{{$source->dformat($sale->return_date)}}</td>
                    </tr>
                    <tr>
                      <th>Note:</th>
                      <td>{{$sale->details}}</td>
                    </tr>
                    <tr>
                      <th>Status:</th>
                      <td>
                        @if($sale->status == 'Active')
                        <span class="label label-success">{{$sale->status}}</span>
                        @elseif($sale->status == 'Cancelled')
                        <span class="label label-danger">{{$sale->status}}</span>
                        @else
                        <span class="label label-warning">{{$sale->status}}</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <th>Record Created On:</th>
                      <td>{{$source->dtformat($sale->created_at)}}</td>
                    </tr>
                    <tr>
                      <th colspan="2" style="text-align:center"><h4>PAX Details:</h4></th>
                    </tr>
                    <tr>
                      <th>PAX Name:</th>
                      <td>{{$sale->pax_name}}</td>
                    </tr>
                    <tr>
                      <th>Mobile Number:</th>
                      <td>{{$sale->pax_mobile}}</td>
                    </tr>
                    <tr>
                      <th>Email:</th>
                      <td>{{$sale->pax_email}}</td>
                    </tr>
                    <tr>
                      <th>Passport No.:</th>
                      <td>{{$sale->passport_no}}</td>
                    </tr>
                    <tr>
                      <th>NID No.:</th>
                      <td>{{$sale->nid}}</td>
                    </tr>
                    <tr>
                      <th>Date of Birth:</th>
                      <td>{{$sale->birth_date}}</td>
                    </tr>
                    <tr>
                      <th>Passport Issue Date:</th>
                      <td>{{$sale->pax_issue_date}}</td>
                    </tr>
                    <tr>
                      <th>Passport Expire Date:</th>
                      <td>{{$sale->pax_expire_date}}</td>
                    </tr>
                  </table>
                </td>
              </tr>
              @endforeach
          </table>
        </div>
        <div class="clearfix"></div>
      </div> <!-- /.box -->
    </div> <!--/.col (left) -->

  </div> <!-- /.row -->
</section> <!-- /.content -->

<script>
  function showHide(e)
  {
    e.parentNode.parentNode.nextElementSibling.classList.toggle('hide');
  }
</script>

@endsection
