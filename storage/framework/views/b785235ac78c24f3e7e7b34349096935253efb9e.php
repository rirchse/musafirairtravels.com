
<?php $__env->startSection('title', 'Edit Employee Account'); ?>
<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Employee Account</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Employee Account</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row"><!-- left column -->
    <div class="col-md-8"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Employee Account</h3>
        </div>
        <div class="col-md-12 text-right toolbar-icon">
          <a href="<?php echo e(route('employee.show',$employee->id)); ?>" class="label label-info" title="employee Details"><i class="fa fa-file-text"></i></a>
          <a href="<?php echo e(route('employee.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> employees" class="label label-success"><i class="fa fa-list"></i></a>
          
        </div>
        <!-- /.box-header -->
        <?php
        $client = $employee;
        ?>
        <!-- form start -->
        <?php echo Form::model($employee, ['route' => ['employee.update', $employee->id], 'method' => 'PUT', 'files' => true]); ?>

        <div class="box-body">
          
          <div class="form-group">
            <?php echo html_entity_decode( Form::label('name', 'Full Name: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

              <?php echo e(Form::text('name', $employee->name, ['class' => 'form-control', 'required' => 'required'])); ?>

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
                  <?php echo html_entity_decode( Form::label('contact', 'Contact No: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                  <?php echo e(Form::text('contact', $employee->contact, ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('contact_2', 'Alternate Contact (Optional):', ['class' => 'control-label'])); ?>

                  <?php echo e(Form::text('contact_2', $employee->contact_2, ['class' => 'form-control'])); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('whatsapp', 'WhatsApp Contact (Optional):', ['class' => 'control-label'])); ?>

                  <?php echo e(Form::text('whatsapp', $employee->whatsapp, ['class' => 'form-control'])); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('email', 'Email Address: (Optional)', ['class' => 'control-label'])); ?>

                  <?php echo e(Form::email('email', $employee->email, ['class' => 'form-control'])); ?>

              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="gender">Gender</label><br>
                <label>
                    <input class="" type="radio" name="gender" value="Male" <?php echo e($employee->gender == 'Male'? 'checked':''); ?>> Male
                </label>&nbsp;
                <label>
                    <input class="" type="radio" name="gender" value="Female" <?php echo e($employee->gender == 'Female'? 'checked':''); ?>> Female
                </label>
                </div><br>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="birth_date">Date of Birth</label>
                    <input class="form-control" id="birth_date" type="date" name="birth_date" placeholder="Date of Birth" value="<?php echo e($employee->birth_date); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pax_issue_date">Join Date</label>
                    <input class="form-control" id="join_date" type="date" name="join_date" placeholder="Join Date" value="<?php echo e($employee->join_date); ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="nid">NID No.</label>
                    <input class="form-control" id="nid" type="text" name="nid" placeholder="NID No." value="<?php echo e($employee->nid); ?>">
                </div>
            </div>
          
            <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('details', 'Details:', ['class' => 'control-label'])); ?>

                <?php echo Form::textarea('details',$employee->details,['class'=>'form-control', 'rows' => 4, 'cols' => 45]); ?>

            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <b>Status:</b>
                <?php echo Form::checkbox('status', 'Active','checked');; ?>

            </div>
            <div class="form-group">
                <?php echo e(Form::label('image', 'Image:', ['class' => 'control-label'])); ?>

                <?php echo e(Form::file('image')); ?>

            </div>
          </div>
            <div class="col-md-6">
            <a target="_blank" href="<?php echo e($employee->image); ?>">
              <img src="<?php echo e($employee->image); ?>" width="200" alt="">
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
  function check()
  {
    var db_designation = '<?php echo e($employee->designation); ?>';
    var designation = document.getElementById('designation');
    for(var x = 0; designation.options.length > 0; x++)
    {
      if(designation.options[x].value == db_designation)
      {
        designation.options[x].setAttribute('selected', '');
        break;
      }
    }
  }
  check();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/employees/edit.blade.php ENDPATH**/ ?>