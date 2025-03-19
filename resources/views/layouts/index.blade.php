@extends('dashboard')
@section('title', 'Dashboard')
@section('content')

<section class="content-header">
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  </ol>
</section>
<style type="text/css">
.home_items{padding: 30px;border: 1px solid #ddd}
    </style>

    <!-- Main content -->
    <section class="content">
      {{-- <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Air-Ticket Invoice</span>
              <span class="info-box-number">{{$new}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Non-Commission Invoice</span>
              <span class="info-box-number">{{$confirmed}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Invoice VISA</span>
              <span class="info-box-number">{{$completed}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col --><!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Invoice Hotel</span>
              <span class="info-box-number">{{$cancelled}}</span>
            </div> <!-- /.info-box-content -->
          </div> <!-- /.info-box -->
        </div> <!-- /.col -->
      </div> --}}

      <div class="row">
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Account Details</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <table class="table">
                @foreach($accounts as $key => $val)
                <tr>
                  <th style="border-top:1px solid #aaa">{{$val->name}}</th>
                  <td style="border-top:1px solid #aaa">Account No. <b>{{$val->account_no}}</b></td>
                </tr>
                <tr>
                  <td>Balance: <b>{{$val->balance}}</b></td>
                  <td>Routing No. <b>{{$val->routing_no}}</b></td>
                </tr>
                <tr>
                  <td>Bank Name: <b>{{$val->bank_name}}</b></td>
                  <td>Branch <b>{{$val->branch}}</b></td>
                </tr>
                @endforeach
              </table>
            </div> <!-- /.box-body -->
          </div> <!-- /.box -->

        </div> <!-- /.col (LEFT) -->
      </div> <!-- /.row -->

      <div class="row">
        <div class="col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Daily Report</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <table class="table">
                <tr>
                  <th>Sales Amount</th>
                  <td>{{$daily['sale']}}</td>
                </tr>
                <tr>
                  <th>Received Amount</th>
                  <td>{{$daily['receive']}}</td>
                </tr>
                <tr>
                  <th>Office Expense</th>
                  <td>{{$daily['expense']}}</td>
                </tr>
              </table>
            </div> <!-- /.box-body -->
          </div> <!-- /.box -->

        </div> <!-- /.col (LEFT) -->
      </div> <!-- /.row -->

    </section>
    
@endsection