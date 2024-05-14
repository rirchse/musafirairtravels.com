
<?php $__env->startSection('title', 'Edit Customer Account'); ?>
<?php $__env->startSection('content'); ?>

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
          <a href="<?php echo e(route('customer.show',$customer->id)); ?>" class="label label-info" title="customer Details"><i class="fa fa-file-text"></i></a>
          <a href="<?php echo e(route('customer.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> customers" class="label label-success"><i class="fa fa-list"></i></a>
          
        </div>
        <!-- /.box-header -->
        <?php
        $client = $customer;
        ?>
        <!-- form start -->
        <?php echo Form::model($customer, ['route' => ['customer.update', $customer->id], 'method' => 'PUT', 'files' => true]); ?>

        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="category">Category</label>                  
                  <select class="form-control" id="category" name="category">
                    <option value="">Select Client Category</option>
                    <option value="All Service" <?php echo e($client->category == 'All Service'? 'selected':''); ?>>All Service</option>
                    <option value="Air Ticket" <?php echo e($client->category == 'Air Ticket'? 'selected':''); ?>>Air Ticket</option>
                    <option value="Hajj" <?php echo e($client->category == 'Hajj'? 'selected':''); ?>>Hajj</option>
                    <option value="Other" <?php echo e($client->category == 'Other'? 'selected':''); ?>>Other</option>
                  </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="client_type">Client Type</label>                 
                  <select class="form-control" id="client_type" name="client_type">
                    <option value="">Select Client Type</option>
                    <option value="Individual" <?php echo e($client->client_type == 'Individual'? 'selected':''); ?>>Individual</option>
                    <option value="Corporate" <?php echo e($client->client_type == 'Corporate'? 'selected':''); ?>>Corporate</option>
                  </select>
                </div>
            </div>
          </div>
          <div class="form-group">
            <?php echo html_entity_decode( Form::label('name', 'Full Name: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

            <?php echo e(Form::text('name', $customer->name, ['class' => 'form-control'])); ?>

        </div>
          <div class="form-group">
              <?php echo e(Form::label('address', 'Address:', ['class' => 'control-label'])); ?>

              <?php echo Form::textarea('address', $customer->address,['class'=>'form-control', 'rows' => 2]); ?>

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo html_entity_decode( Form::label('contact', 'Contact No: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                  <?php echo e(Form::text('contact', $customer->contact, ['class' => 'form-control'])); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('contact_2', 'Alternate Contact (Optional):', ['class' => 'control-label'])); ?>

                  <?php echo e(Form::text('contact_2', $customer->contact_2, ['class' => 'form-control'])); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('whatsapp', 'WhatsApp Contact (Optional):', ['class' => 'control-label'])); ?>

                  <?php echo e(Form::text('whatsapp', $customer->whatsapp, ['class' => 'form-control'])); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('email', 'Email Address: (Optional)', ['class' => 'control-label'])); ?>

                  <?php echo e(Form::email('email', $customer->email, ['class' => 'form-control'])); ?>

              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="gender">Gender</label><br>
                <label>
                    <input class="" type="radio" name="gender" value="Male" <?php echo e($client->gender == 'Male'?'checked':''); ?>> Male
                </label>&nbsp;
                <label>
                    <input class="" type="radio" name="gender" value="Female" <?php echo e($client->gender == 'Female'?'checked':''); ?>> Female
                </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="walking_customer"> Walking Customer?</label><br>
                  <label>
                    <input class="" type="radio" name="walking_customer" value="Yes" <?php echo e($client->walking_customer == 'Yes'?'checked':''); ?>> Yes
                </label>&nbsp;
                <label>
                    <input class="" type="radio" name="walking_customer" value="No" <?php echo e($client->walking_customer == 'No'?'checked':''); ?>> No
                </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="amount">Opening Balance</label>
                  <input class="form-control" id="amount" type="number" name="amount" placeholder="00.00 BDT" set="0.01" value="<?php echo e($client->amount); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="balance">Balance Type</label>
                  <select class="form-control" id="balance" name="balance_type" onchange="checkBal(this)">
                    <option value="">Select Balance Type</option>
                    <option value="Advance" <?php echo e($client->balance_type == 'Advance'?'selected':''); ?>>Advance</option>
                    <option value="Due" <?php echo e($client->balance_type == 'Due'?'selected':''); ?>>Due</option>
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
                    <input class="form-control" id="pax_name" type="text" name="pax_name" placeholder="Pax Name" value="<?php echo e($customer->pax_name); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_type">Pax Type</label>
                    <select class="form-control" id="pax_type" name="pax_type">
                      <option value="">Select PAX Type</option>
                      <option value="Adult" <?php echo e($client->pax_type == 'Adult'?'selected':''); ?>>Adult</option>
                      <option value="Child" <?php echo e($client->pax_type == 'Child'?'selected':''); ?>>Child</option>
                      <option value="Infant" <?php echo e($client->pax_type == 'Infant'?'selected':''); ?>>Infant</option>
                      <option value="Others" <?php echo e($client->pax_type == 'Others'?'selected':''); ?>>Others</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_mobile">Mobile Number</label>
                    <input class="form-control" id="pax_mobile" type="phone" name="pax_mobile" placeholder="Mobile Number" value="<?php echo e($customer->pax_mobile); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_email">Email</label>
                    <input class="form-control" id="pax_email" type="email" name="pax_email" placeholder="Email" value="<?php echo e($customer->pax_email); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="passport">Passport No.</label>
                    <input class="form-control" id="passport" type="text" name="passport_no" placeholder="Passport No." value="<?php echo e($customer->passport_no); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="nid">NID No.</label>
                    <input class="form-control" id="nid" type="text" name="nid" placeholder="NID No." value="<?php echo e($customer->nid); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_issue_date">Passport Issue Date</label>
                    <input class="form-control" id="pax_issue_date" type="date" name="pax_issue_date" placeholder="Passport Issue Date" value="<?php echo e($customer->pax_issue_date); ?>">
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label" for="pax_expire_date">Passport Expire Date</label>
                <input class="form-control" id="pax_expire_date" type="date" name="pax_expire_date" placeholder="Passport Expire Date" value="<?php echo e($customer->pax_expire_date); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="birth_date">Date of Birth</label>
                    <input class="form-control" id="birth_date" type="date" name="birth_date" placeholder="Date of Birth" value="<?php echo e($customer->birth_date); ?>">
                </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <?php echo e(Form::label('details', 'Details:', ['class' => 'control-label'])); ?>

                  <?php echo Form::textarea('details', $customer->details,['class'=>'form-control', 'rows' => 4, 'cols' => 45]); ?>

              </div>
            </div>
          <div class="col-md-6">
            <div class="form-group">
                <b>Status:</b> <br>
                <?php echo e(Form::label('status', 'Active:', ['class' => 'control-label'])); ?>

                <input type="checkbox" name="status" value="Active"<?php echo e($customer->status == "Active" ?'checked':''); ?>>
            </div>
            <div class="form-group">
                <?php echo e(Form::label('image', 'Image:', ['class' => 'control-label'])); ?>

                <?php echo e(Form::file('image')); ?>

            </div>
          </div>
          <div class="col-md-6">
            <a target="_blank" href="<?php echo e($customer->image); ?>">
              <img src="<?php echo e($customer->image); ?>" width="100" alt="">
            </a>
          </div>
        <div class="clearfix"></div>
      </div>

      <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
      </div></div>
      <?php echo Form::close(); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/customers/edit_customer.blade.php ENDPATH**/ ?>