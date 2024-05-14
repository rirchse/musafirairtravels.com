<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View Airlines'); ?>
<?php $__env->startSection('content'); ?>
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Airlines</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Airlines</a></li>
        <li class="active">Airlines</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-5">
          <div class="box box-primary box-body">
            <div class="box-header">
              <h3 class="box-title">Add Airlines</h3>
            </div>
            <div class="col-md-12">
              <form action="<?php echo e(route('airlines.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                  <label for="">Airlines Name</label>
                  <input type="text" name="name" class="form-control" required>
                  
                </div>
                <div class="form-group">
                  <label for="">Airlines Code</label>
                  <input type="text" name="code" class="form-control">
                </div>
                <div class="form-group">
                  <input type="submit" value="Submit" class="btn btn-primary">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List of Airlines</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>SL</th>
                  <th>Airlines Name</th>
                  <th>Code</th>
                  <th width="110">Action</th>
                </tr>

                <?php $__currentLoopData = $airlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $air): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                  <td><?php echo e($air->id); ?></td>
                  <td><?php echo e($air->name); ?></td>
                  <td><?php echo e($air->code); ?></td>
                  <td>
                    <a href="<?php echo e(route('airline.delete', $air->id)); ?>" class="label label-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                <?php echo e($airlines->links()); ?>

              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/settings/airlines.blade.php ENDPATH**/ ?>