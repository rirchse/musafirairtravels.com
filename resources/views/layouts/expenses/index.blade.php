@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Expenses')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Expense Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Expenses</a></li>
        <li class="active">Expense Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Expense</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Deteils</th>
                  <th>Expense Date</th>
                  <th width="110">Action</th>
                </tr>

                @foreach($expenses as $expense)

                <tr>
                  <td>{{ $expense->id }}</td>
                  <td>{{$expense->title}}</td>
                  <td>{{$expense->type}}</td>
                  <td>{{$expense->amount}}</td>
                  <td>
                    @if($expense->status == 1)
                    <span class="label label-success">Paid</span>
                    @elseif($expense->status == 0)
                    <span class="label label-warning">Unpaid</span>
                    @elseif($expense->status == 3)
                    <span class="label label-danger">Returned</span>
                    @endif
                  </td>
                  <td>{{$expense->details}}</td>

                  <td>{{$source->dformat($expense->expense_date)}}</td>
                  <td>
                    <a href="{{route('expense.show',$expense->id)}}" class="label label-info" title="vendor Details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('expense.edit', $expense->id)}}" class="label label-warning" title="Edit this vendor"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$expenses->links()}} --}}
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
@endsection