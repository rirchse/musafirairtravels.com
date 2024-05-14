@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Expense Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Expense Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Expenses</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Expense Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('expense.index')}}" title="View {{Session::get('_types')}} expenses" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('expense.edit',$expense->id)}}" class="label label-warning" title="Edit this expense"><i class="fa fa-edit"></i></a>
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
            
            <form action="{{route('expense.destroy', $expense->id)}}" method="POST" style="max-width: 32px; display:inline-block">
              @csrf
              @method('DELETE')
              <button type="submit" class="label label-danger" onclick="return confirm('Are you sure you want to delete this?');" title="Delete"><i class="fa fa-trash"></i></button></form>
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Title:</th>
                    <td>{{$expense->title}}</td>
                  </tr>
                  <tr>
                    <th>Expense Type:</th>
                    <td>{{$expense->type}}</td>
                  </tr>
                  <tr>
                    <th>Paid To:</th>
                    <td>{{$expense->name}}</td>
                  </tr>
                  <tr>
                    <th>Amount:</th>
                    <td>{{$expense->amount}}</td>
                  </tr>
                  <tr>
                    <th>Expense at:</th>
                    <td>{{$source->dformat($expense->expense_date)}}</td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$expense->details}}</td>
                  </tr>              
                
                   <tr>
                    <th>Status:</th>
                    <td>
                      @if($expense->status == 0)
                      <span class="label label-warning">Unpaid</span>
                      @elseif($expense->status == 1)
                      <span class="label label-success">Paid</span>
                      @elseif($expense->status == 2)
                      <span class="label label-danger">Returned</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{$source->dformat($expense->created_at)}} </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td>{{$source->dformat($expense->updated_at)}} </td>
                  </tr>
                  <tr>
                    <th>Receipt:</th>
                    <td>
                      <a target="_blank" href="{{$expense->image}}">
                        <img src="{{$expense->image}}" width="200" alt="">
                      </a>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          {{-- <p><a href="{{route('expense.delete', $expense->id)}}" onclick="return confirm('Are sure you want to permanently delete this vendor?')" class="text-danger" style="padding:15px">Permanently Remove?</a></p> --}}
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
