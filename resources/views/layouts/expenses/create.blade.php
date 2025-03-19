@extends('dashboard')
@section('title', 'Add New Expense')
@section('content')
 <section class="content-header">
      <h1>Add Expense</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Expenses</a></li>
        <li class="active">Add Expense</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row"> <!-- left column -->
        <div class="col-md-7"> <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Expense Information</h3>
            </div>
                <div class="box-body">
            {!! Form::open(['route' => 'expense.store', 'method' => 'POST', 'files' => true]) !!}
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">Expense Title:</label>
                          <input type="text" class="form-control" name="title">
                      </div>
                      <div class="form-group">
                          <label for="type">Expense Type</label>
                          <select class="form-control" name="type" id="type" required>
                            <option value="">Select Expense Type</option>
                            <option value="Office Rent">Office Rent</option>
                            <option value="Electricity Bill">Electricity Bill</option>
                            <option value="Gas Bill">Gas Bill</option>
                            <option value="Service Charge">Service Charge</option>
                            <option value="Staff Salary">Staff Salary</option>
                            <option value="Staff Bonus">Staff Bonus</option>
                            <option value="Staff Travel Allowance">Staff Travel Allowance</option>
                            <option value="Staff Dining Allowance">Staff Dining Allowance</option>
                            <option value="Office entertainment Expense">Office entertainment Expense</option>
                            <option value="Partner's withdrawal">Partner's withdrawal</option>
                            <option value="Lunch & Snacks Bill">Lunch & Snacks Bill</option>
                            <option value="Office Stationery">Office Stationery</option>
                            <option value="Office Expenses">Office Expenses</option>
                            <option value="Miscellaneous Expenses">Miscellaneous Expenses</option>
                            <option value="Bank Charge">Bank Charge</option>
                            <option value="Others">Others</option>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="">Pay To (Optinal):</label>
                        <select class="form-control" name="pay_to" id="">
                          <option value="">Select Employee</option>
                          @foreach($employees as $user)
                          <option value="{{$user->id}}">{{$user->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Pay from:</label>
                        <select class="form-control" name="account_id" id="" required>
                          <option value="">Select One</option>
                          @foreach($accounts as $val)
                          <option value="{{$val->id}}">{{$val->bank_name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            {!! html_entity_decode( Form::label('amount', 'Expense Amount: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                            {{ Form::text('amount', null, ['class' => 'form-control'])}}
                        </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              {!! html_entity_decode( Form::label('date', 'Expense Date: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                              {{ Form::date('expense_date', null, ['class' => 'form-control']) }}
                          </div>
                        </div>
                      </div>
                        <div class="form-group">
                            {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                            {!! Form::textarea('details',null,['class'=>'form-control', 'rows' => 4, 'cols' => 45]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('image', 'Attach Receipt Paper (Optinal):', ['class' => 'control-label']) }}
                            {{ Form::file('image') }}
                        </div>
                        <div class="form-group">
                            <b>Status:</b> <br>
                            {{ Form::label('status', 'Active:', ['class' => 'control-label']) }}
                            {!! Form::checkbox('status', '1','checked'); !!}
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                      </div>
                    <div class="clearfix"></div>
            {!! Form::close() !!}
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection