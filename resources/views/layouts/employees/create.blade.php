@extends('dashboard')
@section('title', 'Add New Employee')
@section('content')
 <section class="content-header">
      <h1>Add Employee</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Employees</a></li>
        <li class="active">Add Employee</li>
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
              <h3 style="color: #800" class="box-title">Employee Information</h3>
            </div>
            {!! Form::open(['route' => 'employee.store', 'method' => 'POST', 'files' => true]) !!}
                <div class="box-body">
                  <div class="col-md-12">
                    <div class="form-group">
                        {!! html_entity_decode( Form::label('name', 'Full Name: <span class="text-danger">*</span>', ['class' => 'control-label']) )!!}
                          {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required'])}}
                      </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label" for="designation">Designation</label>                  
                                <select class="form-control" id="designation" name="designation">
                                  <option value="">Select One</option>
                                  <option value="Chief Executive Officer">Chief Executive Officer</option>
                                  <option value="Manager">Manager</option>
                                  <option value="Director">Director</option>
                                  <option value="Assistant Manager">Assistant Manager</option>
                                  <option value="Receptionist">Receptionist</option>
                                  <option value="Administrative assistant">Administrative assistant</option>
                                  <option value="Lead">Lead</option>
                                  <option value="Market Development Manager">Market Development Manager</option>
                                  <option value="Office Manager">Office Manager</option>
                                  <option value="Officer">Officer</option>
                                  <option value="President">President</option>
                                  <option value="Sales Manager">Sales Manager</option>
                                  <option value="Sales Representative">Sales Representative</option>
                                  <option value="Supervisor">Supervisor</option>
                                  <option value="Vice president">Vice president</option>
                                  <option value="Account Executive">Account Executive</option>
                                  <option value="Administrator">Administrator</option>
                                  <option value="Bookkeeper">Bookkeeper</option>
                                  <option value="Chief marketing Officer">Chief marketing Officer</option>
                                  <option value="Controller">Controller</option>
                                  <option value="Coordinator">Coordinator</option>
                                  <option value="Customer service">Customer service</option>
                                  <option value="HR Coordinator">HR Coordinator</option>
                                  <option value="Principal">Principal</option>
                                </select>
                              </div>
                          </div>
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
                              </div><br>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="birth_date">Date of Birth</label>
                                  <input class="form-control" id="birth_date" type="date" name="birth_date" placeholder="Date of Birth">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="control-label" for="pax_issue_date">Join Date</label>
                                  <input class="form-control" id="join_date" type="date" name="join_date" placeholder="Join Date">
                              </div>
                          </div>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label class="control-label" for="nid">NID No.</label>
                                  <input class="form-control" id="nid" type="text" name="nid" placeholder="NID No.">
                              </div>
                          </div>
                        
                          <div class="col-md-12">
                          <div class="form-group">
                              {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                              {!! Form::textarea('details',null,['class'=>'form-control', 'rows' => 4, 'cols' => 45]) !!}
                          </div>
                          <div class="form-group">
                              <b>Status:</b>
                              {!! Form::checkbox('status', 'Active','checked'); !!}
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
@endsection