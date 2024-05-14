<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View Refunded Invoice'); ?>
<?php $__env->startSection('content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Refunded Invoices</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Refunded Invoices</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Refunded Invoices</h3>
              <div class="box-tools">
                <a href="<?php echo e(route('sale.refund.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> Create Re-Fund</a><br>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Ticket No.</th>
                  <th>Pax Name</th>
                  <th>Selling Price</th>
                  <th>Purchase Price</th>
                  <th>Client Price</th>
                  <th>Vendor Price</th>
                  <th>Refund Date</th>
                  <th width="110">Action</th>
                </tr>

                <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                  <td><?php echo e($return->ticket_no); ?></td>
                  <td><?php echo e($return->pax_name); ?></td>
                  <td><?php echo e($return->client_price); ?></td>
                  <td><?php echo e($return->purchase); ?></td>
                  <td><?php echo e($return->client_charge); ?></td>
                  <td><?php echo e($return->vendor_charge); ?></td>
                  <td><?php echo e($source->dformat($return->date)); ?></td>
                  
                  <td>
                    <a href="<?php echo e(route('sale.refund.show', $return->id)); ?>" class="label label-info" title="sale Details"><i class="fa fa-file-text"></i></a>
                    
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/refunds/view_refund.blade.php ENDPATH**/ ?>