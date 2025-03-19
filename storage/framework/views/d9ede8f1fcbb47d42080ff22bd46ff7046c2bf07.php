<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View All Payment'); ?>
<?php $__env->startSection('content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo e($type != ''?$type:'All'); ?> Payments</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        
        <li class="active">All Payments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Payment</h3>
              <div class="box-tools">
                <a href="<?php echo e(route('payment.create.type', $type)); ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Payment</a>
                <style type="text/css">
                .payment_item{padding: 5px 10px;border:1px solid #ddd;display: inline-block;}
                </style>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Id</th>
                  
                  <th>Name</th>
                  <th>Contact Number</th>
                  <th>Previous Balance</th>
                  <th>Paid (Tk.)</th>
                  <th>Balance (Tk.)</th>
                  <th>Payment By</th>
                  <th>Date</th>
                  <th width="70">Action</th>
                </tr>

                <?php $balance = 0; ?>

                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $balance += $payment->paid_amount;?>

                <tr>
                  <td><?php echo e($payment->id); ?></td>
                  <td><?php echo e($payment->name); ?></td>
                  <td><?php echo e($payment->contact); ?></td>
                  <td><?php echo $source->balance($payment->pre_balance); ?></td>
                  <td><?php echo e($payment->amount); ?></td>
                  <td><?php echo $source->balance($payment->balance); ?></td>
                  <td><?php echo e($payment->account_name); ?></td>
                  <td><?php echo e($source->dformat($payment->date)); ?></td>
                  <td>
                    <a href="<?php echo e(route('payment.type.show', [$payment->user_type, $payment->id])); ?>" class="label label-info" title="Payment Details"><i class="fa fa-file-text"></i></a>
                    

                    <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
                    
                    <?php endif; ?>

                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                <?php echo e($payments->links()); ?>

              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/payments/view_payment.blade.php ENDPATH**/ ?>