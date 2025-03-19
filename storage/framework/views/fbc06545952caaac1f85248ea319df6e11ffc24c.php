<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View All Customers'); ?>
<?php $__env->startSection('content'); ?>
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Customers Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Customers</a></li>
        <li class="active">Customers Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Customer Accounts</h3>
              <div class="box-tools">
                <form action="<?php echo e(route('search.customer')); ?>" method="post" class="form-inline">
                  <?php echo csrf_field(); ?>
                  <a href="<?php echo e(route('customer.create')); ?>" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                  <div class="input-group">
                    <input type="text" name="search" placeholder="Name, Contact, Email, Passport">
                    <span class="input-addon"><button><i class="fa fa-search"></i></button></span>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Passport No.</th>
                  <th>Balance</th>
                  
                  
                  <th width="110">Action</th>
                </tr>

                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                  <td><?php echo e($customer->id); ?></td>
                  <td><?php echo e($customer->name); ?></td>
                  <td><?php echo e($customer->contact); ?></td>
                  <td><?php echo e($customer->email); ?></td>
                  <td><?php echo e($customer->passport_no); ?></td>
                  <td><?php echo $source->balance($customer->amount); ?></td>
                  

                  
                  <td>
                    <a href="<?php echo e(route('customer.show',$customer->id)); ?>" class="label label-info" title="Customer details"><i class="fa fa-file-text"></i> Details</a>
                    <a href="<?php echo e(route('customer.edit',$customer->id)); ?>" class="label label-warning" title="Edit this customer"><i class="fa fa-edit"></i></a>
                    
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                <?php echo e($customers->links()); ?>

              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/customers/view_customer.blade.php ENDPATH**/ ?>