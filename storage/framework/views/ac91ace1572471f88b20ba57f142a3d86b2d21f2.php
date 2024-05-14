
<?php $__env->startSection('title', 'Edit Vendor Account'); ?>
<?php $__env->startSection('content'); ?>

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
              <a href="<?php echo e(route('vendor.show',$vendor->id)); ?>" class="label label-info" title="vendor Details"><i class="fa fa-file-text"></i></a>
              <a href="<?php echo e(route('vendor.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> vendors" class="label label-success"><i class="fa fa-list"></i></a>
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo Form::model($vendor, ['route' => ['vendor.update', $vendor->id], 'method' => 'PUT', 'files' => true]); ?>

              <div class="box-body">
                    <div class="col-md-12">
                      <div class="form-group">
                        <?php echo html_entity_decode( Form::label('business_name', 'Business Name: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                        <?php echo e(Form::text('business_name', $vendor->business_name, ['class' => 'form-control'])); ?>

                    </div>
                    <div class="form-group">
                        <?php echo e(Form::label('address', 'Address:', ['class' => 'control-label'])); ?>

                        <?php echo Form::textarea('address', $vendor->address,['class'=>'form-control', 'rows' => 2]); ?>

                    </div>
                    <div class="form-group">
                        <?php echo html_entity_decode( Form::label('name', 'Contact Name: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                        <?php echo e(Form::text('name', $vendor->name, ['class' => 'form-control'])); ?>

                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <?php echo html_entity_decode( Form::label('contact', 'Contact No: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                            <?php echo e(Form::text('contact', $vendor->contact, ['class' => 'form-control'])); ?>

                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <?php echo e(Form::label('contact_2', 'Alternate Contact (Optional):', ['class' => 'control-label'])); ?>

                            <?php echo e(Form::text('contact_2', $vendor->contact_2, ['class' => 'form-control'])); ?>

                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <?php echo e(Form::label('whatsapp', 'WhatsApp Contact (Optional):', ['class' => 'control-label'])); ?>

                            <?php echo e(Form::text('whatsapp', $vendor->whatsapp, ['class' => 'form-control'])); ?>

                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <?php echo e(Form::label('email', 'Email Address: (Optional)', ['class' => 'control-label'])); ?>

                            <?php echo e(Form::email('email', $vendor->email, ['class' => 'form-control'])); ?>

                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Opening Balance Type</label>
                          <select name="balance_type" class="form-control" onchange="checkBal(this)">
                            <option value="">Select Opening Balance Type</option>
                            <option value="Advance" <?php echo e($vendor->balance_type == 'Advance'?'selected':''); ?>>Advance</option>
                            <option value="Due" <?php echo e($vendor->balance_type == 'Due'?'selected':''); ?>>Due</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Opening Balance</label>
                          <input type="number" id="amount" name="amount" class="form-control" set="0.01" value="<?php echo e($vendor->amount); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <?php echo e(Form::label('details', 'Details:', ['class' => 'control-label'])); ?>

                        <?php echo Form::textarea('details', $vendor->details,['class'=>'form-control', 'rows' => 4, 'cols' => 45]); ?>

                    </div>
                
                    <div class="col-md-6">
                      <div class="form-group">
                          <b>Status:</b> <br>
                          <?php echo e(Form::label('status', 'Active:', ['class' => 'control-label'])); ?>

                          <input type="checkbox" name="status" value="Active"<?php echo e($vendor->status == "Active" ?'checked':''); ?>>
                      </div>
                      <div class="form-group">
                          <?php echo e(Form::label('image', 'Image:', ['class' => 'control-label'])); ?>

                          <?php echo e(Form::file('image')); ?>

                      </div>
                    </div>
                    <div class="col-md-6">
                      <a target="_blank" href="<?php echo e($vendor->image); ?>">
                        <img src="<?php echo e($vendor->image); ?>" width="100" alt="">
                      </a>
                    </div>
                    <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-restart"></i> Update</button>
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
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/vendors/edit_vendor.blade.php ENDPATH**/ ?>