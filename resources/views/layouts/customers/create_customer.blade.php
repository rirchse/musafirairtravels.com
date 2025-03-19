@extends('dashboard')
@section('title', 'Add New Customer')
@section('content')
 <section class="content-header">
      <h1>Add Customer</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Customers</a></li>
        <li class="active">Add Customer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Customer Information</h3>
            </div>
            {!! Form::open(['route' => 'customer.store', 'method' => 'POST', 'files' => true]) !!}
                <div class="box-body">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="category">Category</label>                  
                        <select class="form-control" id="category" name="category">
                          <option value="">Select Client Category</option>
                          <option value="All Service">All Service</option>
                          <option value="Air Ticket">Air Ticket</option>
                          <option value="Hajj">Hajj</option>
                          <option value="Other">Other</option>
                        </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="client_type">Client Type</label>                 
                        <select class="form-control" id="client_type" name="client_type">
                          <option value="">Select Client Type</option>
                          <option value="Individual">Individual</option>
                          <option value="Corporate">Corporate</option>
                        </select>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        {!! html_entity_decode( Form::label('name', 'Full Name: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                          {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required'])}}
                      </div>
                      <div class="form-group">
                        {{Form::label('address', 'Address:', ['class' => 'control-label'])}}
                        {!! Form::textarea('address',null,['class'=>'form-control', 'rows' => 2]) !!}
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
                                <label class="control-label" for="gender">Gender</label><br>
                              <label>
                                  <input class="" type="radio" name="gender" value="Male"> Male
                              </label>&nbsp;
                              <label>
                                  <input class="" type="radio" name="gender" value="Female"> Female
                              </label>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label" for="walking_customer"> Walking Customer?</label><br>
                                <label>
                                  <input class="" type="radio" name="walking_customer" value="Yes"> Yes
                              </label>&nbsp;
                              <label>
                                  <input class="" type="radio" name="walking_customer" value="No"> No
                              </label>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label" for="amount">Opening Balance</label>
                                <input class="form-control" id="amount" type="number" name="amount" placeholder="Amount" set="0.01" onkeyup="checkBal(document.getElementById('balance'))">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label" for="balance">Balance Type</label>
                                <select class="form-control" id="balance" name="balance_type" onchange="checkBal(this)">
                                  <option value="">Select Balance Type</option>
                                  <option value="Advance">Advance</option>
                                  <option value="Due">Due</option>
                                </select>
                              </div>
                          </div>
                        <div class="clearfix"></div>
                        <div class="box-header with-border">
                            <h3 style="color: #800" class="box-title">Pax & Passport Details:</h3>
                        </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="pax_name">Pax Name</label>
                                  <input class="form-control" id="pax_name" type="text" name="pax_name" placeholder="Pax Name">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="pax_type">Pax Type</label>
                                  <select class="form-control" id="pax_type" name="pax_type">
                                    <option value="">Select PAX Type</option>
                                    <option value="Adult">Adult</option>
                                    <option value="Child">Child</option>
                                    <option value="Infant">Infant</option>
                                    <option value="Others">Others</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="pax_mobile">Mobile Number</label>
                                  <input class="form-control" id="pax_mobile" type="phone" name="pax_mobile" placeholder="Mobile Number">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="pax_email">Email</label>
                                  <input class="form-control" id="pax_email" type="email" name="pax_email" placeholder="Email">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="passport">Passport No.</label>
                                  <input class="form-control" id="passport" type="text" name="passport_no" placeholder="Passport No.">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="nid">NID No.</label>
                                  <input class="form-control" id="nid" type="text" name="nid" placeholder="NID No.">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="birth_date">Date of Birth</label>
                                  <input class="form-control" id="birth_date" type="date" name="birth_date" placeholder="Date of Birth">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="pax_issue_date">Passport Issue Date</label>
                                  <input class="form-control" id="pax_issue_date" type="date" name="pax_issue_date" placeholder="Passport Issue Date">
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label" for="pax_expire_date">Passport Expire Date</label>
                              <input class="form-control" id="pax_expire_date" type="date" name="pax_expire_date" placeholder="Passport Expire Date">
                              </div>
                          </div>
                          <div class="col-md-12">
                          <div class="form-group">
                              {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                              {!! Form::textarea('details',null,['class'=>'form-control', 'rows' => 4, 'cols' => 45]) !!}
                          </div>
                          <div class="form-group">
                              <b>Status:</b>
                              {!! Form::checkbox('status', '1','checked'); !!}
                          </div>
                          <div class="form-group">
                              {{ Form::label('image', 'Image:', ['class' => 'control-label']) }}
                              {{ Form::file('image') }}
                          </div>
                          <div class="clearfix"></div>
                          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                        </div>
                </div>
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