@extends('dashboard')
@section('title', 'Edit Expense')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Expense</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Expense</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Expense</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('expense.show',$expense->id)}}" class="label label-info" title="expense Details"><i class="fa fa-file-text"></i></a>
              <a href="{{route('expense.index')}}" title="View {{Session::get('_types')}} expenses" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="{{route('expense.delete',$expense->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($expense, ['route' => ['expense.update', $expense->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="">Expense Title:</label>
                      <input type="text" class="form-control" name="title" value="{{$expense->title}}">
                  </div>
                  <div class="form-group">
                      <label for="type">Expense Type</label>
                      <select class="form-control" name="type" id="type">
                        <option value="">Select Expense Type</option>
                        <option value="Office Rent" {{$expense->type == "Office Rent"? 'selected':''}}>Office Rent</option>
                        <option value="Electricity Bill" {{$expense->type == "Electricity Bill"? 'selected':''}}>Electricity Bill</option>
                        <option value="Gas Bill" {{$expense->type == "Gas Bill"? 'selected':''}}>Gas Bill</option>
                        <option value="Service Charge"{{$expense->type == "Service Charge"? 'selected':''}}>Service Charge</option>
                        <option value="Staff Salary"{{$expense->type == "Staff Salary"? 'selected':''}}>Staff Salary</option>
                        <option value="Staff Bonus"{{$expense->type == "Staff Bonus"? 'selected':''}}>Staff Bonus</option>
                        <option value="Staff Travel Allowance"{{$expense->type == "Staff Travel Allowance"? 'selected':''}}>Staff Travel Allowance</option>
                        <option value="Staff Dining Allowance"{{$expense->type == "Staff Dining Allowance"? 'selected':''}}>Staff Dining Allowance</option>
                        <option value="Office entertainment Expense"{{$expense->type == "Office entertainment Expense"? 'selected':''}}>Office entertainment Expense</option>
                        <option value="Partner's withdrawal"{{$expense->type == "Partner's withdrawal"? 'selected':''}}>Partner's withdrawal</option>
                        <option value="Others"{{$expense->type == "Others"? 'selected':''}}>Others</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="">Pay To (Optinal):</label>
                    <select class="form-control" name="pay_to" id="">
                      <option value="">Select Employee</option>
                      @foreach($users as $user)
                      <option value="{{$user->name}}" {{$expense->pay_to == $user->name? 'selected':''}}>{{$user->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {!! html_entity_decode( Form::label('amount', 'Expense Amount: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                        {{ Form::text('amount', $expense->amount, ['class' => 'form-control'])}}
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Expense Date</label>
                          <input type="date" class="form-control" name="expense_date" value="{{$expense->expense_date}}">
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
                    <div class="col-md-6">
                      <div class="form-group">
                          <b>Status:</b> <br>
                          {{ Form::label('status', 'Active:', ['class' => 'control-label']) }}
                          {!! Form::checkbox('status', '1','checked'); !!}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <a target="_blank" href="{{$expense->image}}">
                        <img src="{{$expense->image}}" width="200" alt="">
                      </a>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Update</button>
                  </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection