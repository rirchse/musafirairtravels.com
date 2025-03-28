<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Refund Details'); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Refund Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Refunds</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row" id="table"><!-- row -->
    <div class="col-md-12"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border"> <h3 style="color: #800" class="box-title">Refunds Information</h3></div>
        <div class="col-md-12 text-right toolbar-icon">

          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('sale.refund.create')); ?>" title="Add Refund" class="label label-info"><i class="fa fa-plus"></i></a>
          <?php endif; ?>
          <a href="#" title="Print" class="label label-info" onclick="printDiv()"><i class="fa fa-print"></i></a>

          <a href="<?php echo e(route('sale.refund.index')); ?>" title="View" class="label label-success"><i class="fa fa-list"></i></a>
          
          
          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('sale.refund.delete',$refund->id)); ?>" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a>
          <?php endif; ?>
        </div>
        <div class="clearfix"></div>
      </div>
  </div>
  <div class="col-md-12">
    <div class="box">
      <table class="table">
        <tr>
          <?php if($client): ?>
            <th colspan="4">
              <h4>Client Information</h4>
              Name: <?php echo e($client->name); ?> <br>
              Contact: <?php echo e($client->contact); ?> <br>
              Email: <?php echo e($client->email); ?> <br>
            </th>
          <?php endif; ?>
          <?php if($vendor): ?>
            <th colspan="4">
              <h4>Vendor Information</h4>
              Name: <?php echo e($vendor->name); ?> <br>
              Contact: <?php echo e($vendor->contact); ?> <br>
              Email: <?php echo e($vendor->email); ?> <br>
            </th>
          <?php endif; ?>
        </tr>
      </table>
    </div>
    <br>
  </div>
    <div class="col-md-6">
      <div class="box box-info">
        <table class="table">
          <tr>
            <th colspan="4" style="text-align:center"><h4>Summary of Client Refund Charge:</h4>
            </th>
          </tr>
          <tr>
            <th>SL</th>
            <th>Ticket No.</th>
            <th>Selling Price</th>
            <th>Client Refund Charge</th>
          </tr>
          <?php
          $total_price = $total_charge = 0;
          ?>
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($key+1); ?></td>
            <td><?php echo e($item->ticket_no); ?></td>
            <td><?php echo e($item->client_price); ?></td>
            <td><?php echo e($item->client_charge); ?></td>
          </tr>
          <?php
          $total_price += $item->client_price;
          $total_charge += $item->client_charge;
          ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <th colspan="2" style="text-align: right">Total = </th>
            <th><?php echo e($total_price); ?></th>
            <th><?php echo e($total_charge); ?></th>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-warning">
        <table class="table">
          <tr>
            <th colspan="4" style="text-align:center"><h4>Summary of Vendor Refund Charge:</h4></th>
          </tr>
          <tr>
            <th>SL</th>
            <th>Ticket No.</th>
            <th>Purchase Price</th>
            <th>Vendor Refund Charge</th>
          </tr>
          <?php
          $total_price = $total_charge = 0;
          ?>
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($key+1); ?></td>
            <td><?php echo e($item->ticket_no); ?></td>
            <td><?php echo e($item->purchase); ?></td>
            <td><?php echo e($item->vendor_charge); ?></td>
          </tr>
          <?php
          $total_price += $item->purchase;
          $total_charge += $item->vendor_charge;
          ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <th colspan="2" style="text-align: right">Total = </th>
            <th><?php echo e($total_price); ?></th>
            <th><?php echo e($total_charge); ?></th>
          </tr>
        </table>
      </div>
      <div class="clearfix"></div>
    </div><!--/.col (left) -->
</section><!-- /.content -->
<script>
  //js print a div
function printDiv()
{
  // document.getElementById('heading').style.display = 'block';
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
  // document.getElementById('heading').style.display = 'none';
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/refunds/refund_read.blade.php ENDPATH**/ ?>