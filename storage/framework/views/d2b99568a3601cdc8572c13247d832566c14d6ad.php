
<?php $__env->startSection('title', 'Edit Expense'); ?>
<?php $__env->startSection('content'); ?>

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
              <a href="<?php echo e(route('expense.show',$expense->id)); ?>" class="label label-info" title="expense Details"><i class="fa fa-file-text"></i></a>
              <a href="<?php echo e(route('expense.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> expenses" class="label label-success"><i class="fa fa-list"></i></a>
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo Form::model($expense, ['route' => ['expense.update', $expense->id], 'method' => 'PUT', 'files' => true]); ?>

              <div class="box-body">
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="">Expense Title:</label>
                      <input type="text" class="form-control" name="title" value="<?php echo e($expense->title); ?>">
                  </div>
                  <div class="form-group">
                      <label for="type">Expense Type</label>
                      <select class="form-control" name="type" id="type">
                        <option value="">Select Expense Type</option>
                        <option value="Office Rent" <?php echo e($expense->type == "Office Rent"? 'selected':''); ?>>Office Rent</option>
                        <option value="Electricity Bill" <?php echo e($expense->type == "Electricity Bill"? 'selected':''); ?>>Electricity Bill</option>
                        <option value="Gas Bill" <?php echo e($expense->type == "Gas Bill"? 'selected':''); ?>>Gas Bill</option>
                        <option value="Service Charge"<?php echo e($expense->type == "Service Charge"? 'selected':''); ?>>Service Charge</option>
                        <option value="Staff Salary"<?php echo e($expense->type == "Staff Salary"? 'selected':''); ?>>Staff Salary</option>
                        <option value="Staff Bonus"<?php echo e($expense->type == "Staff Bonus"? 'selected':''); ?>>Staff Bonus</option>
                        <option value="Staff Travel Allowance"<?php echo e($expense->type == "Staff Travel Allowance"? 'selected':''); ?>>Staff Travel Allowance</option>
                        <option value="Staff Dining Allowance"<?php echo e($expense->type == "Staff Dining Allowance"? 'selected':''); ?>>Staff Dining Allowance</option>
                        <option value="Office entertainment Expense"<?php echo e($expense->type == "Office entertainment Expense"? 'selected':''); ?>>Office entertainment Expense</option>
                        <option value="Partner's withdrawal"<?php echo e($expense->type == "Partner's withdrawal"? 'selected':''); ?>>Partner's withdrawal</option>
                        <option value="Others"<?php echo e($expense->type == "Others"? 'selected':''); ?>>Others</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="">Pay To (Optinal):</label>
                    <select class="form-control" name="pay_to" id="">
                      <option value="">Select Employee</option>
                      <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($user->name); ?>" <?php echo e($expense->pay_to == $user->name? 'selected':''); ?>><?php echo e($user->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <?php echo html_entity_decode( Form::label('amount', 'Expense Amount: <span class="text-danger">*</span>', ['class' => 'control-label']) ); ?>

                        <?php echo e(Form::text('amount', $expense->amount, ['class' => 'form-control'])); ?>

                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Expense Date</label>
                          <input type="date" class="form-control" name="expense_date" value="<?php echo e($expense->expense_date); ?>">
                      </div>
                    </div>
                  </div>
                    <div class="form-group">
                        <?php echo e(Form::label('details', 'Details:', ['class' => 'control-label'])); ?>

                        <?php echo Form::textarea('details',null,['class'=>'form-control', 'rows' => 4, 'cols' => 45]); ?>

                    </div>
                    <div class="form-group">
                        <?php echo e(Form::label('image', 'Attch Receipt Paper (Optinal):', ['class' => 'control-label'])); ?>

                        <?php echo e(Form::file('image')); ?>

                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <b>Status:</b> <br>
                          <?php echo e(Form::label('status', 'Active:', ['class' => 'control-label'])); ?>

                          <?php echo Form::checkbox('status', '1','checked');; ?>

                      </div>
                    </div>
                    <div class="col-md-6">
                      <a target="_blank" href="<?php echo e($expense->image); ?>">
                        <img src="<?php echo e($expense->image); ?>" width="200" alt="">
                      </a>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Update</button>
                  </div>
            <?php echo Form::close(); ?>

          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/expenses/edit.blade.php ENDPATH**/ ?>