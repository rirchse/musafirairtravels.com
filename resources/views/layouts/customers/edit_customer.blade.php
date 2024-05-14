@extends('dashboard')
@section('title', 'Edit Customer Account')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Customer Account</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Customer Account</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row"><!-- left column -->
    <div class="col-md-8"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Customer Account</h3>
        </div>
        <div class="col-md-12 text-right toolbar-icon">
          <a href="{{route('customer.show',$customer->id)}}" class="label label-info" title="customer Details"><i class="fa fa-file-text"></i></a>
          <a href="{{route('customer.index')}}" title="View {{Session::get('_types')}} customers" class="label label-success"><i class="fa fa-list"></i></a>
          {{-- <a href="{{route('customer.delete',$customer->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
        </div>
        <!-- /.box-header -->
        @php
        $client = $customer;
        @endphp
        <!-- form start -->
        {!! Form::model($customer, ['route' => ['customer.update', $customer->id], 'method' => 'PUT', 'files' => true]) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="category">Category</label>                  
                  <select class="form-control" id="category" name="category">
                    <option value="">Select Client Category</option>
                    <option value="All Service" {{$client->category == 'All Service'? 'selected':''}}>All Service</option>
                    <option value="Air Ticket" {{$client->category == 'Air Ticket'? 'selected':''}}>Air Ticket</option>
                    <option value="Hajj" {{$client->category == 'Hajj'? 'selected':''}}>Hajj</option>
                    <option value="Other" {{$client->category == 'Other'? 'selected':''}}>Other</option>
                  </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="client_type">Client Type</label>                 
                  <select class="form-control" id="client_type" name="client_type">
                    <option value="">Select Client Type</option>
                    <option value="Individual" {{$client->client_type == 'Individual'? 'selected':''}}>Individual</option>
                    <option value="Corporate" {{$client->client_type == 'Corporate'? 'selected':''}}>Corporate</option>
                  </select>
                </div>
            </div>
          </div>
          <div class="form-group">
            {!! html_entity_decode( Form::label('name', 'Full Name: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
            {{ Form::text('name', $customer->name, ['class' => 'form-control'])}}
        </div>
          <div class="form-group">
              {{Form::label('address', 'Address:', ['class' => 'control-label'])}}
              {!! Form::textarea('address', $customer->address,['class'=>'form-control', 'rows' => 2]) !!}
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  {!! html_entity_decode( Form::label('contact', 'Contact No: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                  {{ Form::text('contact', $customer->contact, ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('contact_2', 'Alternate Contact (Optional):', ['class' => 'control-label']) }}
                  {{ Form::text('contact_2', $customer->contact_2, ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('whatsapp', 'WhatsApp Contact (Optional):', ['class' => 'control-label']) }}
                  {{ Form::text('whatsapp', $customer->whatsapp, ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('email', 'Email Address: (Optional)', ['class' => 'control-label']) }}
                  {{ Form::email('email', $customer->email, ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="gender">Gender</label><br>
                <label>
                    <input class="" type="radio" name="gender" value="Male" {{$client->gender == 'Male'?'checked':''}}> Male
                </label>&nbsp;
                <label>
                    <input class="" type="radio" name="gender" value="Female" {{$client->gender == 'Female'?'checked':''}}> Female
                </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="walking_customer"> Walking Customer?</label><br>
                  <label>
                    <input class="" type="radio" name="walking_customer" value="Yes" {{$client->walking_customer == 'Yes'?'checked':''}}> Yes
                </label>&nbsp;
                <label>
                    <input class="" type="radio" name="walking_customer" value="No" {{$client->walking_customer == 'No'?'checked':''}}> No
                </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="amount">Opening Balance</label>
                  <input class="form-control" id="amount" type="number" name="amount" placeholder="00.00 BDT" set="0.01" value="{{$client->amount}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="balance">Balance Type</label>
                  <select class="form-control" id="balance" name="balance_type" onchange="checkBal(this)">
                    <option value="">Select Balance Type</option>
                    <option value="Advance" {{$client->balance_type == 'Advance'?'selected':''}}>Advance</option>
                    <option value="Due" {{$client->balance_type == 'Due'?'selected':''}}>Due</option>
                  </select>
                </div>
            </div>
          </div>
          <div class="row">
          <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Pax & Passport Details:</h3>
          </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_name">Pax Name</label>
                    <input class="form-control" id="pax_name" type="text" name="pax_name" placeholder="Pax Name" value="{{$customer->pax_name}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_type">Pax Type</label>
                    <select class="form-control" id="pax_type" name="pax_type">
                      <option value="">Select PAX Type</option>
                      <option value="Adult" {{$client->pax_type == 'Adult'?'selected':''}}>Adult</option>
                      <option value="Child" {{$client->pax_type == 'Child'?'selected':''}}>Child</option>
                      <option value="Infant" {{$client->pax_type == 'Infant'?'selected':''}}>Infant</option>
                      <option value="Others" {{$client->pax_type == 'Others'?'selected':''}}>Others</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_mobile">Mobile Number</label>
                    <input class="form-control" id="pax_mobile" type="phone" name="pax_mobile" placeholder="Mobile Number" value="{{$customer->pax_mobile}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_email">Email</label>
                    <input class="form-control" id="pax_email" type="email" name="pax_email" placeholder="Email" value="{{$customer->pax_email}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="passport">Passport No.</label>
                    <input class="form-control" id="passport" type="text" name="passport_no" placeholder="Passport No." value="{{$customer->passport_no}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="nid">NID No.</label>
                    <input class="form-control" id="nid" type="text" name="nid" placeholder="NID No." value="{{$customer->nid}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_issue_date">Passport Issue Date</label>
                    <input class="form-control" id="pax_issue_date" type="date" name="pax_issue_date" placeholder="Passport Issue Date" value="{{$customer->pax_issue_date}}">
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label" for="pax_expire_date">Passport Expire Date</label>
                <input class="form-control" id="pax_expire_date" type="date" name="pax_expire_date" placeholder="Passport Expire Date" value="{{$customer->pax_expire_date}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="birth_date">Date of Birth</label>
                    <input class="form-control" id="birth_date" type="date" name="birth_date" placeholder="Date of Birth" value="{{$customer->birth_date}}">
                </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                  {!! Form::textarea('details', $customer->details,['class'=>'form-control', 'rows' => 4, 'cols' => 45]) !!}
              </div>
            </div>
          <div class="col-md-6">
            <div class="form-group">
                <b>Status:</b> <br>
                {{ Form::label('status', 'Active:', ['class' => 'control-label']) }}
                <input type="checkbox" name="status" value="Active"{{$customer->status == "Active" ?'checked':''}}>
            </div>
            <div class="form-group">
                {{ Form::label('image', 'Image:', ['class' => 'control-label']) }}
                {{ Form::file('image') }}
            </div>
          </div>
          <div class="col-md-6">
            <a target="_blank" href="{{$customer->image}}">
              <img src="{{$customer->image}}" width="100" alt="">
            </a>
          </div>
        <div class="clearfix"></div>
      </div>

      <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
      </div></div>
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