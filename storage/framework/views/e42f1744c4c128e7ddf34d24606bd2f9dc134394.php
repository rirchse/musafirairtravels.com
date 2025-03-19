<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Vendor Details'); ?>
<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vendor Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vendors</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Vendor Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="<?php echo e(route('vendor.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> vendors" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="<?php echo e(route('vendor.edit', $vendor->id)); ?>" class="label label-warning" title="Edit this vendor"><i class="fa fa-edit"></i></a>
            

            <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
            <form action="<?php echo e(route('vendor.destroy', $vendor->id)); ?>" method="POST" style="display:inline">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button type="submit" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-trash"></i></button>
            </form>
            <?php endif; ?>            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Name:</th>
                    <td><?php echo e($vendor->name); ?></td>
                  </tr>
                  
                  <tr>
                    <th>Email:</th>
                    <td><?php echo e($vendor->email); ?></td>
                  </tr>
                  <tr>
                    <th>Contact:</th>
                    <td><?php echo e($vendor->contact); ?></td>
                  </tr>
                  <tr>
                    <th>Address:</th>
                    <td><?php echo e($vendor->address); ?></td>
                  </tr>
                  <tr>
                    <th>Business Name:</th>
                    <td><?php echo e($vendor->business_name); ?></td>
                  </tr>
                  <tr>
                    <th><?php echo e($vendor->balance_type); ?> Balance:</th>
                    <td><?php echo $source->balance($vendor->amount); ?></td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td><?php echo e($vendor->details); ?></td>
                  </tr>
                  <tr>
                    <th>Photo:</th>
                    <td>
                      <a target="_blank" href="<?php echo e($vendor->image); ?>">
                        <img src="<?php echo e($vendor->image); ?>" width="100" alt="">
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td><?php echo e($source->dtformat($vendor->created_at)); ?> </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td><?php echo e($source->dtformat($vendor->updated_at)); ?> </td>
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

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/vendors/read_vendor.blade.php ENDPATH**/ ?>