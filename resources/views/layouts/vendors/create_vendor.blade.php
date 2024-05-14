@extends('dashboard')
@section('title', 'Add New Vendor')
@section('content')
 <section class="content-header">
      <h1>Add Vendor</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vendors</a></li>
        <li class="active">Add Vendor</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-7">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Vendor Information</h3>
            </div>
            {!! Form::open(['route' => 'vendor.store', 'method' => 'POST', 'files' => true]) !!}
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! html_entity_decode( Form::label('business_name', 'Business Name: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                            {{ Form::text('business_name', null, ['class' => 'form-control', 'required' => 'required'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('address', 'Address:', ['class' => 'control-label'])}}
                            {!! Form::textarea('address',null,['class'=>'form-control', 'rows' => 2]) !!}
                        </div>
                        <div class="form-group">
                            {!! html_entity_decode( Form::label('name', 'Contact Name: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                            {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required'])}}
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                {!! html_entity_decode( Form::label('contact', 'Contact No: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                                {{ Form::text('contact', null, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('contact_2', 'Alternate Contact (Optional):', ['class' => 'control-label']) }}
                                {{ Form::text('contact_2', null, ['class' => 'form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('whatsapp', 'WhatsApp Contact (Optional):', ['class' => 'control-label']) }}
                                {{ Form::text('whatsapp', null, ['class' => 'form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('email', 'Email Address: (Optional)', ['class' => 'control-label']) }}
                                {{ Form::email('email', null, ['class' => 'form-control']) }}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Opening Balance</label>
                              <input type="number" id="amount" name="amount" class="form-control" set="0.01">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Balance Type</label>
                              <select name="balance_type" class="form-control" onchange="checkBal(this)">
                                <option value="">Select Opening Balance Type</option>
                                <option value="Advance">Advance</option>
                                <option value="Due">Due</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                            {!! Form::textarea('details',null,['class'=>'form-control', 'rows' => 4, 'cols' => 45]) !!}
                        </div>
                    <div class="form-group">
                        {{ Form::label('status', '', ['class' => 'control-label']) }}
                        {!! Form::checkbox('status', 'Active','checked'); !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('image', 'Image:', ['class' => 'control-label']) }}
                        {{ Form::file('image') }}
                    </div>
                    <div class="form-group">
                      <label for="">Record Creation Date</label>
                      <input type="date" class="form-control" name="created_at" value="{{date('Y-m-d')}}">
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
                    <div class="clearfix"></div>
            {!! Form::close() !!}
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
    
    <script>
      function checkBal(e)
      {
        var amount = document.getElementById('amount');
        if(amount.value > 0 && e.options[e.selectedIndex].value == 'Due')
        {
          amount.value = '-'+amount.value;
        }
        else if(amount.value < 0)
        {
          amount.value = amount.value.substring(1);
        }
      }
    </script>
@endsection