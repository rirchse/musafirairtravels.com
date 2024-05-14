<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View All Employees'); ?>
<?php $__env->startSection('content'); ?>
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Employees Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Employees</a></li>
        <li class="active">Employees Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Employee Accounts</h3>
              <div class="box-tools">
                <a href="<?php echo e(route('employee.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add New Employee</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Designation</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  <th width="110">Action</th>
                </tr>

                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>
                  <td><?php echo e($employee->id); ?></td>
                  <td><?php echo e($employee->name); ?></td>
                  <td><?php echo e($employee->designation); ?></td>
                  <td><?php echo e($employee->contact); ?></td>
                  <td><?php echo e($employee->email); ?></td>
                  <td><?php echo e($employee->gender); ?></td>
                  <td>
                    <span class="label label-<?php echo e($employee->status == 'Active'?'success':'primary'); ?>"><?php echo e($employee->status); ?></span>
                  </td>

                  <td><?php echo e($source->dformat($employee->join_date)); ?></td>
                  <td>
                    <a href="<?php echo e(route('employee.show',$employee->id)); ?>" class="label label-info" title="employee details"><i class="fa fa-file-text"></i></a>
                    <a href="<?php echo e(route('employee.edit',$employee->id)); ?>" class="label label-warning" title="Edit this employee"><i class="fa fa-edit"></i></a>
                    
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/employees/view.blade.php ENDPATH**/ ?>