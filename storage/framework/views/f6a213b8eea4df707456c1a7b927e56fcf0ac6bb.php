<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Payment Details'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><?php echo e($payment->user_type); ?> Payment Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- left column -->
    <div class="col-md-6"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Payment Information</h3>
        </div>
        <div class="col-md-12 text-right toolbar-icon">
          <a href="<?php echo e(route('payment.type.index', $payment->user_type)); ?>" title="View payments" class="label label-success"><i class="fa fa-list"></i></a>
          
          <a href="<?php echo e(route('payment.print', $payment->id)); ?>" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
          
          <form action="<?php echo e(route('payment.destroy', $payment->id)); ?>"  method="POST" style="width:32px;display:inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>
            <button type="submit" class="label label-danger" onclick="return confirm('Are you sure want to delete this?');" title="Delete this account"><i class="fa fa-trash"></i></button>
          </form>
        </div>
        <div class="col-md-12">
          <table class="table">
            <tbody>
              
              <tr>
                <th><?php echo e($payment->user_type); ?> Name:</th>
                <td><?php echo e($payment->name); ?></td>
              </tr>
              
              <tr>
                <th>Previous Balance:</th>
                <td><?php echo $source->balance($payment->pre_balance); ?></td>
              </tr>
              <tr>
                <th>Paid Amount:</th>
                <td><?php echo e($payment->amount); ?></td>
              </tr>
              <tr>
                <th>Current Balance:</th>
                <td><?php echo $source->balance($payment->balance); ?></td>
              </tr>
              <tr>
                <th>Payment Method:</th>
                <td><?php echo e($payment->account_name); ?></td>
              </tr>
              <tr>
                <th>Payment Date:</th>
                <td><?php echo e($source->dformat($payment->date)); ?></td>
              </tr>
              
                               
              <tr>
                <th>Deteils:</th>
                <td><?php echo e($payment->details); ?></td>
              </tr>
              
              <tr>
                <th>Record Created On:</th>
                <td><?php echo e($source->dtformat($payment->created_at)); ?> </td>
              </tr>                 
            </tbody>
          </table>
        </div>
        <div class="clearfix"></div>
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</section><!-- /.content -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/payments/read_payment.blade.php ENDPATH**/ ?>