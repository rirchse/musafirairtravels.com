
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<section class="content-header">
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  </ol>
</section>
<style type="text/css">
.home_items{padding: 30px;border: 1px solid #ddd}
    </style>

    <!-- Main content -->
    <section class="content">
      

      <div class="row">
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Account Details</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <table class="table">
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <th style="border-top:1px solid #aaa"><?php echo e($val->name); ?></th>
                  <td style="border-top:1px solid #aaa">Account No. <b><?php echo e($val->account_no); ?></b></td>
                </tr>
                <tr>
                  <td>Balance: <b><?php echo e($val->balance); ?></b></td>
                  <td>Routing No. <b><?php echo e($val->routing_no); ?></b></td>
                </tr>
                <tr>
                  <td>Bank Name: <b><?php echo e($val->bank_name); ?></b></td>
                  <td>Branch <b><?php echo e($val->branch); ?></b></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div> <!-- /.box-body -->
          </div> <!-- /.box -->

        </div> <!-- /.col (LEFT) -->
      </div> <!-- /.row -->

      <div class="row">
        <div class="col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Daily Report</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <table class="table">
                <tr>
                  <th>Sales Amount</th>
                  <td><?php echo e($daily['sale']); ?></td>
                </tr>
                <tr>
                  <th>Received Amount</th>
                  <td><?php echo e($daily['receive']); ?></td>
                </tr>
                <tr>
                  <th>Office Expense</th>
                  <td><?php echo e($daily['expense']); ?></td>
                </tr>
              </table>
            </div> <!-- /.box-body -->
          </div> <!-- /.box -->

        </div> <!-- /.col (LEFT) -->
      </div> <!-- /.row -->

    </section>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/index.blade.php ENDPATH**/ ?>