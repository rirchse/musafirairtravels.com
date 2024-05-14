<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Employee Details'); ?>
<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Employee Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Employees</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Employee Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="<?php echo e(route('employee.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> employees" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="<?php echo e(route('employee.edit', $employee->id)); ?>" class="label label-warning" title="Edit this employee"><i class="fa fa-edit"></i></a>
            

            <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
            <form style="width:32px; display:inline" action="<?php echo e(route('employee.destroy', $employee->id)); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this?');" title="Delete"><i class="fa fa-trash"></i></button></form>
            <?php endif; ?>
            
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th>Full Name:</th>
                  <td><?php echo e($employee->name); ?></td>
                </tr>
                <tr>
                  <th>Designation:</th>
                  <td><?php echo e($employee->designation); ?></td>
                </tr>
                <tr>
                  <th>Contact:</th>
                  <td><?php echo e($employee->contact); ?></td>
                </tr>
                <tr>
                  <th>Alternate Contact:</th>
                  <td><?php echo e($employee->contact_2); ?></td>
                </tr>
                <tr>
                  <th>WhatsApp:</th>
                  <td><?php echo e($employee->whatsapp); ?></td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td><?php echo e($employee->email); ?></td>
                </tr>
                <tr>
                  <th>Gender:</th>
                  <td><?php echo e($employee->gender); ?></td>
                </tr>
                <tr>
                  <th>Join Date:</th>
                  <td><?php echo e($source->dformat($employee->join_date)); ?> </td>
                </tr>
                <tr>
                  <th>Updated On:</th>
                  <td><?php echo e($source->dtformat($employee->updated_at)); ?> </td>
                </tr>
                <tr>
                  <th>Photo: </th>
                  <td><a href="<?php echo e($employee->image); ?>" target="_blank"><img src="<?php echo e($employee->image); ?>" style="width:100%;max-width:200px"></a></td>
                </tr>
                <tr>
                  <th>Date of Birth:</th>
                  <td><?php echo e($source->dformat($employee->birth_date)); ?></td>
                </tr>
                <tr>
                  <th>NID No.:</th>
                  <td><?php echo e($employee->nid); ?></td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td><?php echo e($employee->details); ?></td>
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

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/employees/read.blade.php ENDPATH**/ ?>