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
      <h1>Vendor Reports</h1>
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
            {!! Form::open(['route' => 'report.vendor.post', 'method' => 'POST', 'files' => true]) !!}
            <div class="box-body">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Vendor Name</label>
                  <select name="client" id="client" class="form-control">
                    <option value="">Select One</option>
                    @foreach($clients as $val)
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
            @if(isset($sales))
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List of Payment</h3>
              
            </div> <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Date</th>
                  <th>Voucher No.</th>
                  <th>Vendor Name</th>
                  <th>Pay Type</th>
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Balance</th>
                  <th>Note</th>
                  <th>Actions</th>
                </tr>

                @php
                $total_debit = $total_credit = $total_balance = $client_price = $vendor_price = $profit = 0;
                @endphp

                @foreach($sales as $val)
                @php
                  $client_price += $val->client_price;
                  $vendor_price += $val->purchase;
                  $profit += $val->profit;

                  if($val->balance <= $val->pre_balance)
                  {
                    $total_debit += $val->amount;
                  }
                  else
                  {
                    $total_credit += $val->amount;
                  }
                  $total_balance = $val->balance;
                @endphp

                <tr>
                  <td>{{$source->dformat($val->date)}}</td>
                  <td>{{$val->id}}</td>
                  <td>{{$val->name}}</td>
                  <td>{{$val->payment_by}}</td>
                  <td>{{$val->balance <= $val->pre_balance ? $val->amount : '' }}</td>
                  <td>{{$val->balance > $val->pre_balance ? $val->amount : '' }}</td>
                  <td>{{$val->balance}}</td>
                  <td>{{$val->details}}</td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="4" style="text-align: right">Total = </th>
                  <th>{{$total_debit}} BDT</th>
                  <th>{{$total_credit}} BDT</th>
                  <th>{{$total_credit-$total_debit}} BDT</th>
                </tr>
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
              </div>
            </div>
          </div> <!-- /.box -->
            @endif
        </div>
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection