
<?php $__env->startSection('title', 'Invoice Add to return'); ?>
<?php $__env->startSection('content'); ?>

<section class="content-header">
  <h1>Invoice Returned</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Customer Payments</a></li>
    <li class="active">Add Customer Payment</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-6"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Invoice Details <b> [ #<?php echo e($sale->ticket_no); ?> ]</b></h3>
        </div>
        <?php echo Form::open(['route' => 'sale.refund.store', 'method' => 'POST', 'files' => true]); ?>

        <div class="box-body">
          <table class="table border" style="border:1px solid #ddd">
            <tr>
              <td>Customer Name: <b><?php echo e($client->name); ?></b></td>
            </tr>
            <tr>
              <td>Contact Number: <b><?php echo e($client->contact); ?></b></td>
            </tr>
            <tr>
              <td>Passport No: <b> #<?php echo e($client->passport_no); ?></b></td>
            </tr>
            <tr>
              <td>Total Amount: <b><?php echo e($sale->gross_fare); ?> tk</b></td>
            </tr>
          </table><br>
          <?php echo e(Form::hidden('sale_id', $sale->id)); ?>

          <div class="form-group">
            <?php echo e(Form::label('amount', 'Refund Amount:', ['class' => 'control-label'])); ?>

            <?php echo Form::text('amount', $sale->gross_fare, ['class'=>'form-control']); ?>

          </div>
          <div class="form-group">
            <?php echo e(Form::label('cost', 'Refund cost:', ['class' => 'control-label'])); ?>

            <?php echo Form::text('cost', NULL, ['class'=>'form-control']); ?>

          </div>
          <div class="form-group">
            <?php echo e(Form::label('date', 'Return Date:', ['class' => 'control-label'])); ?>

            <?php echo Form::date('date', null, ['class'=>'form-control', 'required' => '']); ?>

          </div>
            <div class="form-group">
              <?php echo e(Form::label('comment', 'Comment:', ['class' => 'control-label'])); ?>

              <?php echo e(Form::textarea('comment', null, ['class' => 'form-control', 'required' => '', 'placeholder' => 'Why refunded the invoice?', 'rows'=>3])); ?>

            </div>

          <button type="submit" class="btn btn-warning pull-right"> Refund</button>
          <div class="clearfix"></div>
          <?php echo Form::close(); ?>


        </div> <!-- /.box -->
      </div> <!--/.col (left) -->
    </div> <!-- /.row -->
  </section> <!-- /.content -->
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/sales/refund.blade.php ENDPATH**/ ?>