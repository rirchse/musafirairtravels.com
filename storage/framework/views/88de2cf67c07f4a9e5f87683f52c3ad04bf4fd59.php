<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$sale = $invoice;
?>


<?php $__env->startSection('title', 'Invoice Details'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Invoice <?php echo e($sale->type); ?> Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Invoices</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- row -->
    <div class="col-md-7"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border"> <h3 style="color: #800" class="box-title">Invoice Information</h3></div>
        <div class="col-md-12 text-right toolbar-icon">

          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('invoice.type.create', $sale->type)); ?>" title="Add Invoice" class="label label-info"><i class="fa fa-plus"></i></a>
          <?php endif; ?>

          <a href="<?php echo e(route('invoice.type.index', $sale->type)); ?>" title="View sales" class="label label-success"><i class="fa fa-list"></i></a>
          <a href="<?php echo e(route('invoice.type.edit', [$sale->type, $sale->id])); ?>" class="label label-warning" title="Edit"><i class="fa fa-edit"></i></a>
          <a href="<?php echo e(route('invoice.other.print', $sale->id)); ?>" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
          
          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('invoice.type.delete',$sale->id)); ?>" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a>
          <?php endif; ?>
        </div>
        <div class="col-md-12">
          <table class="table">
            <tbody>
              <tr>
                <th>Invoice Number:</th>
                <td><b># <?php echo e($sale->id); ?></b></td>
              </tr>
              <tr>
                <th>Product:</th>
                <td><b><?php echo e($sale->type); ?></b></td>
              </tr>
              <tr>
                <th>Client Name:</th>
                <td><?php echo e($sale->client_name); ?></td>
              </tr>
              <?php if($sale->type == 'Hotel'): ?>
              <tr>
                <th>Hotel Name:</th>
                <td><?php echo e($sale->hotel_name); ?></td>
              </tr>
              <tr>
                <th>Room No.:</th>
                <td><?php echo e($sale->room_no); ?></td>
              </tr>
              <?php endif; ?>
              <?php if($sale->type == 'VISA'): ?>
              <tr>
                <th>Country:</th>
                <td><?php echo e($sale->country); ?></td>
              </tr>
              <tr>
                <th>Visa Type:</th>
                <td><?php echo e($sale->visa_type); ?></td>
              </tr>
              <tr>
                <th>Token:</th>
                <td><?php echo e($sale->token); ?></td>
              </tr>
              <tr>
                <th>Delivery:</th>
                <td><?php echo e($sale->delivery); ?></td>
              </tr>
              <tr>
                <th>Visa No.:</th>
                <td><?php echo e($sale->visa_no); ?></td>
              </tr>
              <tr>
                <th>Mofa No.:</th>
                <td><?php echo e($sale->mofa_no); ?></td>
              </tr>
              <tr>
                <th>Okala No.:</th>
                <td><?php echo e($sale->okala_no); ?></td>
              </tr>
              <?php endif; ?>
              <tr>
                <th>Quantity:</th>
                <td><?php echo e($sale->quantity); ?></td>
              </tr>
              <tr>
                <th>Unit Price:</th>
                <td><?php echo e($sale->unit_price); ?></td>
              </tr>
              <tr>
                <th>Total Sale:</th>
                <td><?php echo e($sale->total_sale); ?></td>
              </tr>
              <tr>
                <th>Purchase Price:</th>
                <td><?php echo e($sale->cost_price); ?></td>
              </tr>
              <tr>
                <th>Profit:</th>
                <td><?php echo e($sale->profit); ?></td>
              </tr>
              <tr>
                <th>Vendor:</th>
                <td><?php echo e($sale->vendor_name); ?> </td>
              </tr>
              <tr>
                <th>Details:</th>
                <td><?php echo e($sale->details); ?></td>
              </tr>
              <tr>
                <th>Created At:</th>
                <td><?php echo e($source->dformat($sale->created_at)); ?></td>
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

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/invoice_others/read.blade.php ENDPATH**/ ?>