@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Expenses')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Expenses</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Expenses</a></li>
        <li class="active">Expenses</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="col-md-12">
              <h4><i class="fa fa-sliders"></i> Filter</h4>
              <form action="{{route('expense.filter')}}" method="POST">
                @csrf
                <div class="col-md-4">
                  <label for="">Expense Type</label>
                  <div class="form-group">
                    <select class="form-control select2" name="type">
                      <option value="">Select One</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">Paid To</label>
                  <div class="form-group">
                    <select class="form-control select2" name="paid_to">
                      <option value="">Select One</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">Paid From Account</label>
                  <div class="form-group">
                    <select class="form-control select2" name="paid_from">
                      <option value="">Select One</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">Start Date</label>
                  <div class="form-group">
                    <input type="date" class="form-control" name="start_date">
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">End Date</label>
                  <div class="form-group">
                    <input type="date" class="form-control" name="end_date">
                  </div>
                </div>
                <div class="col-md-4">
                  <br>
                  <div class="form-group">
                    <button class="btn btn-info"><i class="fa fa-search"></i> Search</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="clearfix"></div>
          </div>
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
                  <th>Amount BDT</th>
                  <th>Paid To</th>
                  <th>Paid Account</th>
                  <th>Balance</th>
                  <th>Expense Date</th>
                  <th>Status</th>
                  <th width="110">Action</th>
                </tr>

                @php
                $total = 0;
                @endphp

                @foreach($expenses as $expense)
                @php
                $total += $expense->amount;
                @endphp

                <tr>
                  <td>{{ $expense->id }}</td>
                  <td>{{$expense->title}}</td>
                  <td>{{$expense->type}}</td>
                  <td>{{$expense->amount}}</td>
                  <td>{{$expense->paid_to}}</td>
                  <td>{{$expense->name}}</td>
                  <td>{{$expense->account_bal}}</td>
                  <td>{{$source->dformat($expense->expense_date)}}</td>
                  <td>
                    @if($expense->status == 1)
                    <span class="label label-success">Paid</span>
                    @elseif($expense->status == 0)
                    <span class="label label-warning">Unpaid</span>
                    @elseif($expense->status == 3)
                    <span class="label label-danger">Returned</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{route('expense.show',$expense->id)}}" class="label label-info" title="vendor Details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('expense.edit', $expense->id)}}" class="label label-warning" title="Edit this vendor"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>

                @endforeach
                <tr>
                  <th colspan="3" style="text-align: right">Total = </th>
                  <th>{{$total}}</th>
                </tr>
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
@section('scripts')
<script>
  $(function(){$('.select2').select2();});
</script>
@endsection