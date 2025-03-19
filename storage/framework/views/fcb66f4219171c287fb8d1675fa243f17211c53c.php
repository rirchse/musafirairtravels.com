<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Expense Details'); ?>
<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Expense Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Expenses</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Expense Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="<?php echo e(route('expense.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> expenses" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="<?php echo e(route('expense.edit',$expense->id)); ?>" class="label label-warning" title="Edit this expense"><i class="fa fa-edit"></i></a>
            <a href="#" title="Print" class="label label-info" onclick="printDiv()"><i class="fa fa-print"></i></a>
            
            <form action="<?php echo e(route('expense.destroy', $expense->id)); ?>" method="POST" style="max-width: 32px; display:inline-block">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button type="submit" class="label label-danger" onclick="return confirm('Are you sure you want to delete this?');" title="Delete"><i class="fa fa-trash"></i></button></form>
            
          </div>
          <div class="col-md-12" id="table">
            <table>
              <tr>
                <td style="width: 100%;display:none" id="heading">
                  <?php echo $__env->make('layouts.print_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <br>
                </td>
              </tr>
              <tr>
                <td><h4>Expense Details</h4></td>
              </tr>
            </table>
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Title:</th>
                    <td><?php echo e($expense->title); ?></td>
                  </tr>
                  <tr>
                    <th>Expense Type:</th>
                    <td><?php echo e($expense->type); ?></td>
                  </tr>
                  <tr>
                    <th>Paid To:</th>
                    <td><?php echo e($expense->name); ?></td>
                  </tr>
                  <tr>
                    <th>Amount:</th>
                    <td><?php echo e($expense->amount); ?></td>
                  </tr>
                  <tr>
                    <th>Paid From:</th>
                    <td><?php echo e($expense->bank_name); ?></td>
                  </tr>
                  <tr>
                    <th>Last Account Balance:</th>
                    <td><?php echo e($expense->account_bal); ?> BDT</td>
                  </tr>
                  <tr>
                    <th>Expense at:</th>
                    <td><?php echo e($source->dformat($expense->expense_date)); ?></td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td><?php echo e($expense->details); ?></td>
                  </tr>              
                
                   <tr>
                    <th>Status:</th>
                    <td>
                      <?php if($expense->status == 0): ?>
                      <span class="label label-warning">Unpaid</span>
                      <?php elseif($expense->status == 1): ?>
                      <span class="label label-success">Paid</span>
                      <?php elseif($expense->status == 2): ?>
                      <span class="label label-danger">Returned</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td><?php echo e($source->dformat($expense->created_at)); ?> </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td><?php echo e($source->dformat($expense->updated_at)); ?> </td>
                  </tr>
                  <tr class="receipt">
                    <th>Receipt:</th>
                    <td>
                      <a target="_blank" href="<?php echo e($expense->image); ?>">
                        <img src="<?php echo e($expense->image); ?>" width="200" alt="">
                      </a>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
  <script>
    //js print a div
  function printDiv()
  {
    document.getElementById('heading').style.display = 'block';
    var divToPrint = document.getElementById('table');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        '.heading{display:block}'+
        '.pageheader{font-size:15px}'+
        'table { border-collapse:collapse; font-size:15px;width:100%}' +
        '.table tr th, .table tr td { padding: 10px; border:1px solid #ddd; text-align:left}' +
        'table tr{background: #ddd}'+
        '.receipt{display:none}'+
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open(htmlToPrint);
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
    document.getElementById('heading').style.display = 'none';
  }
  </script>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/expenses/read.blade.php ENDPATH**/ ?>