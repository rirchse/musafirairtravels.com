@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;

$client = $start_date = $end_date = '';
if(isset($data))
{
  $client = $data['client'];
  $start_date = $data['start_date'];
  $end_date = $data['end_date'];
}

$name = $email = $contact = $address = '';
if(isset($customer))
{
  $name = isset($customer->name) ? $customer->name:'';
  $email = isset($customer->email) ? $customer->email:'';
  $contact = isset($customer->contact) ? $customer->contact:'';
  $address = isset($customer->address) ? $customer->address:'';
}
@endphp

@extends('dashboard')
@section('title', 'Reports')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Client Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            {!! Form::open(['route' => 'report.client.post', 'method' => 'POST', 'files' => true]) !!}
            <input type="hidden" name="user_type" value="Client">
            <div class="box-body">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Sales By Client</label>
                  <select name="client" id="client" class="form-control select2">
                    <option value="">Select One</option>
                    @foreach($clients as $val)
                    <option value="{{$val->id}}" {{$client == $val->id? 'selected':''}}>{{$val->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="start_date">Start Date</label>
                  <input type="date" name="start_date" class="form-control" value="{{$start_date}}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="end_date">End Date</label>
                  <input type="date" name="end_date" class="form-control" value="{{$end_date}}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group"><br>
                  <button type="submit" class="btn btn-primary" >Search</button>
                </div>
              </div>
              <div class="col-md-2"><br>
                <button type="button" href="#" title="Print" class="btn btn-info" onclick="printDiv()"><i class="fa fa-print"></i></button>
              </div>
                <div class="clearfix"></div>
                {!! Form::close() !!}
              </div> <!-- /.box -->
            </div>
          </div>

        <div class="col-md-12">
          @if(!empty($sales))
          <div class="box box-primary" id="table">
            <table style="width:100%">
              <tr>
                <td style="width: 70%;">
                  <div style="display: none" id="heading">
                    @include('layouts.print_header')
                  </div>
                </td>
                <td style="width:30%">
                  @if($name)
                  <table class="info" style="width:100%; margin-bottom:15px;max-width:450px;border:1px solid #ddd">
                  <tr>
                    <td>Client Name: </td>
                    <td> <b>{{$name}}</b></td>
                  </tr>
                  <tr>
                    <td>Email: </td>
                    <td>{{$email}}</td>
                  </tr>
                  <tr>
                    <td>Mobile: </td>
                    <td>{{$contact}}</td>
                  </tr>
                  <tr>
                    <td>Address: </td>
                    <td>{{$address}}</td>
                  </tr>
                </table>
                @endif
                </td>
              </tr>
            </table>

            <div class="box-header">
              <h3 class="box-title">Client Report</h3>
              
            </div> <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Date</th>
                  <th>Particulars</th>
                  <th>Voucher No.</th>
                  <th>Pax Name</th>
                  <th>Ticket No.</th>
                  <th>PNR</th>
                  <th>Route</th>
                  <th>Pay Type</th>
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Balance</th>
                  <th>Note</th>
                  {{-- <th>Actions</th> --}}
                </tr>

                @php
                $total_debit = $total_credit = $total_balance = $client_price = $vendor_price = $profit = 0;
                @endphp

                @foreach($sales as $val)
                @php
                  $client_price += $val->client_price;
                  $vendor_price += $val->purchase;
                  $profit += $val->profit;

                  $total_debit += $val->debit;
                  $total_credit += $val->credit;
                @endphp

                <tr>
                  <td>{{$source->dformat($val->created_at)}}</td>
                  <td>{{$val->name}}</td>
                  <td>{{$val->id}}</td>
                    @if($val->report_type == 'Air-Ticket' || $val->report_type == 'Non-Commission' || $val->report_type == 'Reissue')
                    <td>
                      @foreach($val->foreign as $pax)
                      {{$pax->pax_name}}<br>
                      @endforeach
                    </td>
                    <td>
                      @foreach($val->foreign as $ticket)
                      {{$ticket->ticket_no}}<br>
                      @endforeach
                    </td>
                    <td>
                      @foreach($val->foreign as $pnr)
                      {{$pnr->pnr}}<br>
                      @endforeach
                    </td>
                    <td>
                      @foreach($val->foreign as $route)
                      {{$route->route}}<br>
                      @endforeach
                    </td>
                    @elseif($val->report_type == 'VISA' || $val->report_type == 'Hotel' || $val->report_type == 'Other')
                    <td>
                      @foreach($val->foreign as $other)
                      {{$other->pax_name}}<br>
                      @endforeach
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @elseif($val->report_type == 'Refund')
                    <td>
                      @foreach($val->foreign as $refund)
                      {{$refund->pax_name}}<br>
                      @endforeach
                    </td>
                    <td>
                      @foreach($val->foreign as $ticket)
                      {{$ticket->ticket_no}}<br>
                      @endforeach
                    </td>
                    <td></td>
                    <td></td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                  <td>
                    @if($val->report_type == 'Payment' && isset($val->foreign->name))
                    {{$val->foreign->name}}
                    @endif
                  </td>
                  <td>{{$val->debit}}</td>
                  <td>{{$val->credit}}</td>
                  <td>{!!$source->balance($val->balance)!!}</td>
                  <td>{{$val->details}}</td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="8" style="text-align: right">Total = </th>
                  <th>{{$total_debit}} BDT</th>
                  <th>{{$total_credit}} BDT</th>
                  <th>{{$total_credit-$total_debit}} BDT</th>
                  <th></th>
                </tr>
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
              </div>
            </div>
          </div> <!-- /.box -->
        @else
        <div class="box box-default" style="text-align: center;padding:25px"><h4>No Records Found!</h4></div>
        @endif
        </div>
      </div> <!-- /.row -->
    </section> <!-- /.content -->
    <script>
      //js print a div
    function printDiv()
    {
      document.getElementById('heading').style.display = 'block';
      var divToPrint = document.getElementById('table');
      var htmlToPrint = '' +
          '<style type="text/css">' +
          '.heading{display:block}'+
          '.pageheader{font-size:15px}'+
          'table { border-collapse:collapse; font-size:15px;width:100%}' +
          '.table tr th, .table tr td { padding: 10px; border:1px solid #ddd; text-align:left}' +
          'table tr{background: #ddd}'+
          '.receipt{display:none}'+
          '</style>';
      htmlToPrint += divToPrint.outerHTML;
      newWin = window.open(htmlToPrint);
      newWin.document.write(htmlToPrint);
      newWin.print();
      newWin.close();
      document.getElementById('heading').style.display = 'none';
    }
    </script>
@endsection
@section('scripts')
<script> $(function(){ $('.select2').select2(); }); </script>
@endsection