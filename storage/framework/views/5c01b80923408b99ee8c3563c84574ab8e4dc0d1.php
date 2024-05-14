<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View All account'); ?>
<?php $__env->startSection('content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Accounts</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        
        <li class="active">All Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Account</h3>
              <div class="box-tools">
                <a href="<?php echo e(route('account.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Account</a>
                <style type="text/css">
                .account_item{padding: 5px 10px;border:1px solid #ddd;display: inline-block;}
                </style>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Account Type</th>
                  <th>Balance</th>
                  <th>Bank Name</th>
                  <th>Account No.</th>
                  <th>Branch</th>
                  <th>Card No.</th>
                  <th>Routing No.</th>
                  <th width="70">Action</th>
                </tr>

                <?php $balance = 0; ?>

                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $balance += $account->paid_amount;?>

                <tr>
                  <td><?php echo e($account->id); ?></td>
                  <td><?php echo e($account->name); ?></td>
                  <td><?php echo e($account->type); ?></td>
                  <td><?php echo e($account->balance); ?></td>
                  <td><?php echo e($account->bank_name); ?></td>
                  <td><?php echo e($account->account_no); ?></td>
                  <td><?php echo e($account->branch); ?></td>
                  <td><?php echo e($account->card_no); ?></td>
                  <td><?php echo e($account->routing_no); ?></td>
                  <td>
                    
                    <a href="<?php echo e(route('account.edit',$account->id)); ?>" class="label label-warning" title="Edit this account"><i class="fa fa-edit"></i></a>

                    <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
                    
                    <?php endif; ?>

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
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/accounts/index.blade.php ENDPATH**/ ?>