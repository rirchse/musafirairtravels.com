@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;

$payment_by = $start_date = $end_date = '';
if(isset($data))
{
  $payment_by = $data['payment_by'];
  $start_date = $data['start_date'];
  $end_date = $data['end_date'];
}
@endphp

@extends('dashboard')
@section('title', 'Reports')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Sales Reports</h1>
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
            {!! Form::open(['route' => 'report.sale.post', 'method' => 'POST', 'files' => true]) !!}
            <div class="box-body">
              {{-- <div class="col-md-3">
                <div class="form-group">
                  <label for="">Sales Type</label>
                  <select name="sale_type" id="sale_type" class="form-control">
                    <option value="">Select One</option>
                    <option value="Air-Ticket">Air-Ticket</option>
                    <option value="Non-Commission">Non-Commission</option>
                    <option value="VISA">VISA</option>
                    <option value="Hotel">Hotel</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div> --}}
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Sales By Vendor</label>
                  <select name="vendor" id="vendor" class="form-control">
                    <option value="">Select One</option>
                    @foreach($vendors as $val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Sales By Airline</label>
                  <select name="airline" id="airline" class="form-control">
                    <option value="">Select One</option>
                    @foreach($airlines as $val)
                    <option value="{{$val->name}}">{{$val->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Sales By Client</label>
                  <select name="client" id="client" class="form-control">
                    <option value="">Select One</option>
                    @foreach($customers as $val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
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
                <div class="clearfix"></div>
            {!! Form::close() !!}
            
          </div> <!-- /.box -->
        </div>
      </div>

        <div class="col-md-12">
          @if(!empty($sales))
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List of Sales</h3>
              <button class="btn btn-info pull-right" onclick="printDiv()"><i class="fa fa-print"></i></button>
              
            </div> <!-- /.box-header -->
            <div id="table" class="box-body table-responsive no-padding">
              <table style="width:100%">
                <tr>
                  <td style="width: 100%; display:none" id="heading">
                    @include('layouts.print_header')
                  </td>
                </tr>
                <tr><th colspan="2" style="padding:15px">Sales Report</th></tr>
              </table>
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Date</th>
                  <th>Sales Type</th>
                  <th>Vendor</th>
                  <th>Airline</th>
                  <th>Client</th>
                  <th>Ticket No.</th>
                  <th>Client Price</th>
                  <th>Vendor Price</th>
                  <th>Profit</th>
                </tr>

                @php
                $client_price = $vendor_price = $profit = 0;
                @endphp

                @foreach($sales as $val)
                @php
                  $client_price += $val->client_price;
                  $vendor_price += $val->purchase;
                  $profit += $val->profit;
                @endphp

                <tr>
                  <td>{{$source->dformat($val->created_at)}}</td>
                  <td>{{$val->type}}</td>
                  <td>{{$val->vendor_name}}</td>
                  <td>{{$val->airline}}</td>
                  <td>{{$val->client_name}}</td>
                  <td>{{$val->ticket_no}}</td>
                  <td>{{$val->client_price}}</td>
                  <td>{{$val->purchase}}</td>
                  <td>{{$val->profit}}</td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="6" style="text-align: right">Total = </th>
                  <th>{{$client_price}} BDT</th>
                  <th>{{$vendor_price}} BDT</th>
                  <th>{{$profit}} BDT</th>
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