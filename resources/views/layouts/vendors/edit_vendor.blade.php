@extends('dashboard')
@section('title', 'Edit Vendor Account')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vendor Account</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit vendor Account</li>
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
              <h3 class="box-title">Edit vendor Account</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('vendor.show',$vendor->id)}}" class="label label-info" title="vendor Details"><i class="fa fa-file-text"></i></a>
              <a href="{{route('vendor.index')}}" title="View {{Session::get('_types')}} vendors" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="{{route('vendor.delete',$vendor->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($vendor, ['route' => ['vendor.update', $vendor->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                    <div class="col-md-12">
                      <div class="form-group">
                        {!! html_entity_decode( Form::label('business_name', 'Business Name: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                        {{ Form::text('business_name', $vendor->business_name, ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('address', 'Address:', ['class' => 'control-label'])}}
                        {!! Form::textarea('address', $vendor->address,['class'=>'form-control', 'rows' => 2]) !!}
                    </div>
                    <div class="form-group">
                        {!! html_entity_decode( Form::label('name', 'Contact Name: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                        {{ Form::text('name', $vendor->name, ['class' => 'form-control'])}}
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            {!! html_entity_decode( Form::label('contact', 'Contact No: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                            {{ Form::text('contact', $vendor->contact, ['class' => 'form-control']) }}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('contact_2', 'Alternate Contact (Optional):', ['class' => 'control-label']) }}
                            {{ Form::text('contact_2', $vendor->contact_2, ['class' => 'form-control']) }}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('whatsapp', 'WhatsApp Contact (Optional):', ['class' => 'control-label']) }}
                            {{ Form::text('whatsapp', $vendor->whatsapp, ['class' => 'form-control']) }}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('email', 'Email Address: (Optional)', ['class' => 'control-label']) }}
                            {{ Form::email('email', $vendor->email, ['class' => 'form-control']) }}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Opening Balance</label>
                          <input type="number" id="amount" name="amount" class="form-control" set="0.01" value="{{$vendor->amount}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Balance Type</label>
                          <select name="balance_type" class="form-control" onchange="checkBal(this)">
                            <option value="">Select Opening Balance Type</option>
                            <option value="Advance" {{$vendor->balance_type == 'Advance'?'selected':''}}>Advance</option>
                            <option value="Due" {{$vendor->balance_type == 'Due'?'selected':''}}>Due</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                        {!! Form::textarea('details', $vendor->details,['class'=>'form-control', 'rows' => 4, 'cols' => 45]) !!}
                    </div>
                
                    <div class="col-md-6">
                      <div class="form-group">
                          <b>Status:</b> <br>
                          {{ Form::label('status', 'Active:', ['class' => 'control-label']) }}
                          <input type="checkbox" name="status" value="Active"{{$vendor->status == "Active" ?'checked':''}}>
                      </div>
                      <div class="form-group">
                          {{ Form::label('image', 'Image:', ['class' => 'control-label']) }}
                          {{ Form::file('image') }}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <a target="_blank" href="{{$vendor->image}}">
                        <img src="{{$vendor->image}}" width="100" alt="">
                      </a>
                    </div>
                    <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-restart"></i> Update</button>
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