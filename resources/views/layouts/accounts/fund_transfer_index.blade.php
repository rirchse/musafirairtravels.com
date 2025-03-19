@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Fund Transfers</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">All Fund Transfers</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Transfer</h3>
              <div class="box-tools">
                {{-- <a href="{{route('account.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Account</a> --}}
                <style type="text/css">
                .account_item{padding: 5px 10px;border:1px solid #ddd;display: inline-block;}
                </style>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Id</th>
                  <th>From Account</th>
                  <th>To Account</th>
                  <th>Amount</th>
                  <th>From Account Balance</th>
                  <th>To Account Balance</th>
                  <th>Date</th>
                  {{-- <th width="70">Action</th> --}}
                </tr>

                @foreach($transfers as $val)

                <tr>
                  <td>{{$val->id}}</td>
                  <td>{{$val->from_name}}</td>
                  <td>{{$val->to_name}}</td>
                  <td>{{$val->amount}}</td>
                  <td>{{$val->account_from_balance}}</td>
                  <td>{{$val->account_to_balance}}</td>
                  <td>{{$source->dformat($val->date)}}</td>
                  {{-- <td>{{$val->created_by}}</td> --}}
                  <td>
                    {{-- <a href="{{route('val.show', $val->id)}}" class="label label-info" title="val Details"><i class="fa fa-file-text"></i></a> --}}
                    {{-- <a href="{{route('val.edit', $val->id)}}" class="label label-warning" title="Edit this val"><i class="fa fa-edit"></i></a> --}}
                    {{-- <a href="{{route('fund.transfer.create', $val->id)}}" class="label label-success" title="Fund Transfer"><i class="fa fa-exchange"></i></a> --}}

                    @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                    {{-- <a href="{{route('account.delete', $val->id)}}" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a> --}}
                    @endif

                  </td>
                </tr>

                @endforeach
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$transfers->links()}}
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
@endsection