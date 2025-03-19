@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">All Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Account</h3>
              <div class="box-tools">
                <a href="{{route('account.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Account</a>
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
                  <th>Name</th>
                  <th>Account Type</th>
                  <th>Balance</th>
                  <th>Bank Name</th>
                  <th>Account No.</th>
                  <th>Branch</th>
                  <th>Card No.</th>
                  <th>Routing No.</th>
                  <th width="70">Action</th>
                </tr>

                <?php $balance = 0; ?>

                @foreach($accounts as $account)
                <?php $balance += $account->paid_amount;?>

                <tr>
                  <td>{{$account->id}}</td>
                  <td>{{$account->name}}</td>
                  <td>{{$account->type}}</td>
                  <td>{{$account->balance}}</td>
                  <td>{{$account->bank_name}}</td>
                  <td>{{$account->account_no}}</td>
                  <td>{{$account->branch}}</td>
                  <td>{{$account->card_no}}</td>
                  <td>{{$account->routing_no}}</td>
                  <td>
                    {{-- <a href="{{route('account.show', $account->id)}}" class="label label-info" title="account Details"><i class="fa fa-file-text"></i></a> --}}
                    <a href="{{route('account.edit',$account->id)}}" class="label label-warning" title="Edit this account"><i class="fa fa-edit"></i></a>
                    <a href="{{route('fund.transfer.create',$account->id)}}" class="label label-success" title="Fund Transfer"><i class="fa fa-exchange"></i></a>

                    @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                    {{-- <a href="{{route('account.delete', $account->id)}}" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a> --}}
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