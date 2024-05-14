<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Refund Details'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Refund Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Refunds</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- row -->
    <div class="col-md-7"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border"> <h3 style="color: #800" class="box-title">Refunds Information</h3></div>
        <div class="col-md-12 text-right toolbar-icon">

          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('sale.refund.create')); ?>" title="Add Refund" class="label label-info"><i class="fa fa-plus"></i></a>
          <?php endif; ?>

          <a href="<?php echo e(route('sale.refund.index')); ?>" title="View" class="label label-success"><i class="fa fa-list"></i></a>
          
          
          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('sale.refund.delete',$refund->id)); ?>" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a>
          <?php endif; ?>
        </div>
        <div class="col-md-12">
          <table class="table">
            <tbody>
              <tr>
                <th colspan="2" style="text-align:center"><h4>Summary of Client Refund Charge:</h4></th>
              </tr>
              <tr>
                <th>Selling Price:</th>
                <td><?php echo e($refund->selling_price); ?></td>
              </tr>
              <tr>
                <th>Refund Charge from Client:</th>
                <td><?php echo e($refund->client_charge); ?></td>
              </tr>
              <tr>
                <th colspan="2" style="text-align:center"><h4>Summary of Vendor Refund Charge:</h4></th>
              </tr>
              <tr>
                <th>Vendor Name:</th>
                <td><?php echo e($refund->purchase); ?></td>
              </tr>
              <tr>
                <th>Purchase:</th>
                <td><?php echo e($refund->purchase); ?></td>
              </tr>
              <tr>
                <th>Re-Fund Charge By Vendor:</th>
                <td><?php echo e($refund->vendor_charge); ?></td>
              </tr>
              <tr>
                <th colspan="2" style="text-align:center"><h4>Refund Details:</h4></th>
              </tr>
              <tr>
                <th>Invoice Number:</th>
                <td><b># <?php echo e($refund->invoice_id); ?></b></td>
              </tr>
              <tr>
                <th>Discount:</th>
                <td><?php echo e($refund->discount); ?></td>
              </tr>
              <tr>
                <th>Profit:</th>
                <td><?php echo e($refund->profit); ?></td>
              </tr>
              <tr>
                <th>PAX Name:</th>
                <td><?php echo e($refund->pax_name); ?></td>
              </tr>
              <tr>
                <th>Ticket Number:</th>
                <td><?php echo e($refund->ticket_no); ?></td>
              </tr>
              <tr>
                <th>Client Name:</th>
                <td><?php echo e($refund->client_name); ?></td>
              </tr>
              <tr>
                <th>Vendor:</th>
                <td><?php echo e($refund->vendor_name); ?></td>
              </tr>
              <tr>
                <th>Airline:</th>
                <td><?php echo e($refund->airline); ?></td>
              </tr>
              <tr>
                <th>Discount:</th>
                <td><?php echo e($refund->discount); ?></td>
              </tr>
              <tr>
                <th>PNR:</th>
                <td><?php echo e($refund->pnr); ?></td>
              </tr>
              <tr>
                <th>Return Date:</th>
                <td><?php echo e($source->dformat($refund->return_date)); ?></td>
              </tr>
              <tr>
                <th>Details:</th>
                <td><?php echo e($refund->details); ?></td>
              </tr>
              <tr>
                <th>Record Created On:</th>
                <td><?php echo e($source->dtformat($refund->created_at)); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="clearfix"></div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </div><!-- /.row -->
</section><!-- /.content -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/sales/refund_read.blade.php ENDPATH**/ ?>