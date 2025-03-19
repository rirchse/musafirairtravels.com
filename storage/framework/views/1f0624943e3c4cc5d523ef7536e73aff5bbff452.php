<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View All Expenses'); ?>
<?php $__env->startSection('content'); ?>
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Expenses</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Expenses</a></li>
        <li class="active">Expenses</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="col-md-12">
              <h4><i class="fa fa-sliders"></i> Filter</h4>
              <form action="<?php echo e(route('expense.filter')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="col-md-4">
                  <label for="">Expense Type</label>
                  <div class="form-group">
                    <select class="form-control select2" name="type">
                      <option value="">Select One</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">Paid To</label>
                  <div class="form-group">
                    <select class="form-control select2" name="paid_to">
                      <option value="">Select One</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">Paid From Account</label>
                  <div class="form-group">
                    <select class="form-control select2" name="paid_from">
                      <option value="">Select One</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">Start Date</label>
                  <div class="form-group">
                    <input type="date" class="form-control" name="start_date">
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="">End Date</label>
                  <div class="form-group">
                    <input type="date" class="form-control" name="end_date">
                  </div>
                </div>
                <div class="col-md-4">
                  <br>
                  <div class="form-group">
                    <button class="btn btn-info"><i class="fa fa-search"></i> Search</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Expense</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Type</th>
                  <th>Amount BDT</th>
                  <th>Paid To</th>
                  <th>Paid Account</th>
                  <th>Balance</th>
                  <th>Expense Date</th>
                  <th>Status</th>
                  <th width="110">Action</th>
                </tr>

                <?php
                $total = 0;
                ?>

                <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $total += $expense->amount;
                ?>

                <tr>
                  <td><?php echo e($expense->id); ?></td>
                  <td><?php echo e($expense->title); ?></td>
                  <td><?php echo e($expense->type); ?></td>
                  <td><?php echo e($expense->amount); ?></td>
                  <td><?php echo e($expense->paid_to); ?></td>
                  <td><?php echo e($expense->name); ?></td>
                  <td><?php echo e($expense->account_bal); ?></td>
                  <td><?php echo e($source->dformat($expense->expense_date)); ?></td>
                  <td>
                    <?php if($expense->status == 1): ?>
                    <span class="label label-success">Paid</span>
                    <?php elseif($expense->status == 0): ?>
                    <span class="label label-warning">Unpaid</span>
                    <?php elseif($expense->status == 3): ?>
                    <span class="label label-danger">Returned</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="<?php echo e(route('expense.show',$expense->id)); ?>" class="label label-info" title="vendor Details"><i class="fa fa-file-text"></i></a>
                    <a href="<?php echo e(route('expense.edit', $expense->id)); ?>" class="label label-warning" title="Edit this vendor"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <th colspan="3" style="text-align: right">Total = </th>
                  <th><?php echo e($total); ?></th>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
  $(function(){$('.select2').select2();});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/expenses/index.blade.php ENDPATH**/ ?>