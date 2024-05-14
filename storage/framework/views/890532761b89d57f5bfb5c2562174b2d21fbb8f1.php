
<?php $__env->startSection('title', 'Add New Expense'); ?>
<?php $__env->startSection('content'); ?>
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
            <?php echo Form::open(['route' => 'expense.store', 'method' => 'POST', 'files' => true]); ?>

                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="">Expense Title:</label>
                          <input type="text" class="form-control" name="title">
                      </div>
                      <div class="form-group">
                          <label for="type">Expense Type</label>
                          <select class="form-control" name="type" id="type">
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
                            <option value="Others">Others</option>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="">Pay To (Optinal):</label>
                        <select class="form-control" name="pay_to" id="">
                          <option value="">Select Employee</option>
                          <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <?php echo html_entity_decode( Form::label('amount', 'Expense Amount: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                            <?php echo e(Form::text('amount', null, ['class' => 'form-control'])); ?>

                        </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <?php echo html_entity_decode( Form::label('date', 'Expense Date: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                              <?php echo e(Form::date('expense_date', null, ['class' => 'form-control'])); ?>

                          </div>
                        </div>
                      </div>
                        <div class="form-group">
                            <?php echo e(Form::label('details', 'Details:', ['class' => 'control-label'])); ?>

                            <?php echo Form::textarea('details',null,['class'=>'form-control', 'rows' => 4, 'cols' => 45]); ?>

                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('image', 'Attach Receipt Paper (Optinal):', ['class' => 'control-label'])); ?>

                            <?php echo e(Form::file('image')); ?>

                        </div>
                        <div class="form-group">
                            <b>Status:</b> <br>
                            <?php echo e(Form::label('status', 'Active:', ['class' => 'control-label'])); ?>

                            <?php echo Form::checkbox('status', '1','checked');; ?>

                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                      </div>
                    <div class="clearfix"></div>
            <?php echo Form::close(); ?>

          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/expenses/create.blade.php ENDPATH**/ ?>