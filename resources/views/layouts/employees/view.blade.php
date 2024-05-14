@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View All Employees')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Employees Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Employees</a></li>
        <li class="active">Employees Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Employee Accounts</h3>
              <div class="box-tools">
                <a href="{{route('employee.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Add New Employee</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Designation</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  <th width="110">Action</th>
                </tr>

                @foreach($employees as $employee)

                <tr>
                  <td>{{$employee->id}}</td>
                  <td>{{$employee->name}}</td>
                  <td>{{$employee->designation}}</td>
                  <td>{{$employee->contact}}</td>
                  <td>{{$employee->email}}</td>
                  <td>{{$employee->gender}}</td>
                  <td>
                    <span class="label label-{{$employee->status == 'Active'?'success':'primary'}}">{{$employee->status}}</span>
                  </td>

                  <td>{{ $source->dformat($employee->join_date) }}</td>
                  <td>
                    <a href="{{route('employee.show',$employee->id)}}" class="label label-info" title="employee details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('employee.edit',$employee->id)}}" class="label label-warning" title="Edit this employee"><i class="fa fa-edit"></i></a>
                    {{-- @if($employee->status == 1)
                    <a href="/admin/employee_login/{{$employee->email}}" class="label label-success" title="Login to this account" target="_blank"><i class="fa fa-search-plus"></i></a>
                    @endif
                    @if($employee->status == 0)
                    <a href="/admin/resend_email_verification/{{$employee->id}}" class="label label-primary" onclick="return confirm('Are you sure you want to resend email verification to this employee?')" title="Resend verification email."><i class="fa fa-envelope-o"></i></a>
                    @endif
                    @if($employee->status == 3)
                    <a href="/admin/employee/{{$employee->id}}/restore" class="label label-success" title="Restore the account" onclick="return confirm('Are you sure you want to restore the account?')"><i class="fa fa-undo"></i></a>
                    @endif --}}
                  </td>
                </tr>

                @endforeach
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$Employees->links()}} --}}
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
@endsection