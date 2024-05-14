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
@section('title', 'Transaction History')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Transactions</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Transactions</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            {!! Form::open(['route' => 'account.post', 'method' => 'POST', 'files' => true]) !!}
            <div class="box-body">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Payment By</label>
                  <select name="payment_by" id="payment_by" class="form-control">
                    <option value="">Select Payment By</option>
                    <option value="Cash" {{$payment_by == 'Cash'? 'selected':''}}>Cash</option>
                    <option value="Trust Bank" {{$payment_by == 'Trust Bank'? 'selected':''}}>Trust Bank</option>
                    <option value="DBBL" {{$payment_by == 'DBBL'? 'selected':''}}>DBBL</option>
                    <option value="ISBL" {{$payment_by == 'ISBL'? 'selected':''}}>ISBL</option>
                    <option value="Bank" {{$payment_by == 'Bank'? 'selected':''}}>Bank</option>
                    <option value="Others" {{$payment_by == 'Others'? 'selected':''}}>Others</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="start_date">Start Date</label>
                  <input type="date" name="start_date" class="form-control" value="{{$start_date}}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="end_date">End Date</label>
                  <input type="date" name="end_date" class="form-control" value="{{$end_date}}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group"><br>
                  <button type="submit" class="btn btn-primary" >Submit</button>
                </div>
              </div>
                <div class="clearfix"></div>
            {!! Form::close() !!}
            
          </div> <!-- /.box -->
        </div>
      </div>

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Transaction History</h3>
              
            </div> <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Balance</th>
                </tr>
                @if(isset($payments))

                @php
                $debit = $credit = $balance = 0;
                @endphp

                @foreach($payments as $val)
                @php
                if($val->user_type == 'Client')
                {
                  $balance += $val->amount;
                  $credit += $val->amount;
                }
                elseif($val->user_type == 'Vendor')
                {
                  $balance -= $val->amount;
                  $debit += $val->amount;
                }
                @endphp

                <tr>
                  <td>{{$source->dformat($val->date)}}</td>
                  <td>
                    @if($val->user_type == 'Client')
                    Receive from Client
                    @endif
                    @if($val->user_type == 'Vendor')
                    Paid to Vendor
                    @endif
                  </td>
                  <td>{{$val->user_type == 'Vendor'? $val->amount:''}}</td>
                  <td>{{$val->user_type == 'Client'? $val->amount:''}}</td>
                  <td>{{$balance}}</td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="2" style="text-align: right">Total = </th>
                  <th>{{$debit}}</th>
                  <th>{{$credit}}</th>
                  <th>{{$balance}}</th>
                </tr>
                @endif
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection