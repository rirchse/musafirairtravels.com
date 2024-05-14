<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View All Vendors'); ?>
<?php $__env->startSection('content'); ?>    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vendor Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vendors</a></li>
        <li class="active">Vendor Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Vendor Accounts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Busines Name</th>
                  <th>Balance</th>
                  
                  
                  <th width="110">Action</th>
                </tr>

                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                  <td><?php echo e($vendor->id); ?></td>
                  <td><?php echo e($vendor->name); ?></td>
                  <td><?php echo e($vendor->contact); ?></td>
                  <td><?php echo e($vendor->business_name); ?></td>
                  <td><?php echo $source->balance($vendor->amount); ?></td>
                  

                  
                  <td>
                    <a href="<?php echo e(route('vendor.show',$vendor->id)); ?>" class="label label-info" title="vendor Details"><i class="fa fa-file-text"></i></a>
                    <a href="<?php echo e(route('vendor.edit', $vendor->id)); ?>" class="label label-warning" title="Edit this vendor"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                <?php echo e($vendors->links()); ?>

              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/vendors/view_vendor.blade.php ENDPATH**/ ?>