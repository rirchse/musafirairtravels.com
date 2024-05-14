<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Invoice Details'); ?>
<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Invoice <?php echo e($invoice->type); ?> Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Invoices</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- row -->
    <div class="col-md-7"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border"> <h3 style="color: #800" class="box-title">Invoices Information</h3></div>
        <div class="col-md-12 text-right toolbar-icon">

          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('sale.create.type', $invoice->type)); ?>" title="Add Invoice" class="label label-info"><i class="fa fa-plus"></i></a>
          <?php endif; ?>

          <a href="<?php echo e(route('sale.view.type', $invoice->type)); ?>" title="View sales" class="label label-success"><i class="fa fa-list"></i></a>
          
          <a href="<?php echo e(route('sale.invoice.print', $invoice->id)); ?>" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
          
          <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
          <a href="<?php echo e(route('sale.delete', $invoice->id)); ?>" class="label label-danger" onclick="return confirm('Are you sure you want to delete this item!');" title="Delete this item"><i class="fa fa-trash"></i></a>
          <?php endif; ?>
        </div>
        <div class="col-md-12">
          <table class="table">
              <tr>
                <th colspan="2" style="text-align:center"><h4>Invoice Details:</h4></th>
              </tr>
              <tr>
                <th>Invoice Number:</th>
                <td><b># <?php echo e($invoice->id); ?></b></td>
              </tr>
              <tr>
                <th>Sale:</th>
                <td><?php echo e($invoice->sale); ?></td>
              </tr>
              <tr>
                <th>Purchase:</th>
                <td><?php echo e($invoice->purchase); ?></td>
              </tr>
              <tr>
                <th>Profit:</th>
                <td><?php echo e($invoice->profit); ?></td>
              </tr>
          </table>
          <table class="table">
            <tr>
              <th colspan="7" style="text-align:center"><h4>Ticket Details:</h4></th>
            </tr>
              <tr>
                <th>SL</th>
                <th>Ticket No.</th>
                <th>Pax Name</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($sale->ticket_no); ?></td>
                <td><?php echo e($sale->pax_name); ?></td>
                <td><?php echo e($sale->gross_fare); ?></td>
                <td><?php echo e($sale->discount); ?></td>
                <td><?php echo e($sale->gross_fare - $sale->discount); ?></td>
                <td>
                  <a class="label label-info" onclick="showHide(this)"><i class="fa fa-angle-down"></i> View</a>
                  <a href="<?php echo e(route('sale.edit', $sale->id)); ?>" class="label label-warning" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
              </tr>

              <tr class="hide">
                <td colspan="7">
                  <table class="table">
                    <tr>
                      <th>Ticket Number:</th>
                      <td><?php echo e($sale->ticket_no); ?></td>
                    </tr>
                    <tr>
                      <th>Customer Name:</th>
                      <td><?php echo e($sale->name); ?></td>
                    </tr>
                    <tr>
                      <th>Mobile Number:</th>
                      <td><?php echo e($sale->contact); ?></td>
                    </tr>
                    <tr>
                      <th>Email Address:</th>
                      <td><?php echo e($sale->email); ?></td>
                    </tr>
                    <tr>
                      <th>Passport No.:</th>
                      <td><?php echo e($sale->passport_no); ?></td>
                    </tr>
                    <tr>
                      <th>Vendor:</th>
                      <td><?php echo e($sale->vendor_name); ?></td>
                    </tr>
                    <tr>
                      <th>Airline:</th>
                      <td><?php echo e($sale->airline); ?></td>
                    </tr>
                    <?php if($sale->type == 'Air-Ticket'): ?>
                    <tr>
                      <th>Gross Fare(Sale):</th>
                      <td><?php echo e($sale->gross_fare); ?></td>
                    </tr>
                    <tr>
                      <th>Base Fare(Buy):</th>
                      <td><?php echo e($sale->base_fare); ?> </td>
                    </tr>
                    <tr>
                      <th>Commission %:</th>
                      <td><?php echo e($sale->commission); ?></td>
                    </tr>
                    <tr>
                      <th>Commission Amount:</th>
                      <td><?php echo e($sale->commission_amount); ?></td>
                    </tr>
                    <tr>
                      <th>Net Commission:</th>
                      <td><?php echo e($sale->net_commission); ?></td>
                    </tr>
                    <tr>
                      <th>AIT:</th>
                      <td><?php echo e($sale->ait); ?></td>
                    </tr>
                    <tr>
                      <th>Discount:</th>
                      <td><?php echo e($sale->discount); ?></td>
                    </tr>
                    <tr>
                      <th>Other Bonus:</th>
                      <td><?php echo e($sale->other_bonus); ?></td>
                    </tr>
                    <tr>
                      <th>Extra Fee:</th>
                      <td><?php echo e($sale->extra_fee); ?></td>
                    </tr>
                    <tr>
                      <th>Other Expense:</th>
                      <td><?php echo e($sale->other_expense); ?></td>
                    </tr>
                    <tr>
                      <th>VAT:</th>
                      <td><?php echo e($sale->vat); ?></td>
                    </tr>
                    <tr>
                      <th>Tax:</th>
                      <td><?php echo e($sale->tax); ?></td>
                    </tr>
                    <tr>
                      <th>GDS:</th>
                      <td><?php echo e($sale->gds); ?></td>
                    </tr>
                    <tr>
                      <th>Segment:</th>
                      <td><?php echo e($sale->segment); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                      <th>Route/Sector:</th>
                      <td><?php echo e($sale->route); ?></td>
                    </tr>
                    <tr>
                      <th>PNR:</th>
                      <td><?php echo e($sale->pnr); ?></td>
                    </tr>
                    <tr>
                      <th>Issue Date:</th>
                      <td><?php echo e($source->dformat($sale->issue_date)); ?></td>
                    </tr>
                    <tr>
                      <th>Journey Date:</th>
                      <td><?php echo e($source->dformat($sale->journey_date)); ?></td>
                    </tr>
                    <tr>
                      <th>Return Date:</th>
                      <td><?php echo e($source->dformat($sale->return_date)); ?></td>
                    </tr>
                    <tr>
                      <th>Note:</th>
                      <td><?php echo e($sale->details); ?></td>
                    </tr>
                    <tr>
                      <th>Status:</th>
                      <td>
                        <?php if($sale->status == 'Active'): ?>
                        <span class="label label-success"><?php echo e($sale->status); ?></span>
                        <?php elseif($sale->status == 'Cancelled'): ?>
                        <span class="label label-danger"><?php echo e($sale->status); ?></span>
                        <?php else: ?>
                        <span class="label label-warning"><?php echo e($sale->status); ?></span>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Record Created On:</th>
                      <td><?php echo e($source->dtformat($sale->created_at)); ?></td>
                    </tr>
                    <tr>
                      <th colspan="2" style="text-align:center"><h4>PAX Details:</h4></th>
                    </tr>
                    <tr>
                      <th>PAX Name:</th>
                      <td><?php echo e($sale->pax_name); ?></td>
                    </tr>
                    <tr>
                      <th>Mobile Number:</th>
                      <td><?php echo e($sale->pax_mobile); ?></td>
                    </tr>
                    <tr>
                      <th>Email:</th>
                      <td><?php echo e($sale->pax_email); ?></td>
                    </tr>
                    <tr>
                      <th>Passport No.:</th>
                      <td><?php echo e($sale->passport_no); ?></td>
                    </tr>
                    <tr>
                      <th>NID No.:</th>
                      <td><?php echo e($sale->nid); ?></td>
                    </tr>
                    <tr>
                      <th>Date of Birth:</th>
                      <td><?php echo e($sale->birth_date); ?></td>
                    </tr>
                    <tr>
                      <th>Passport Issue Date:</th>
                      <td><?php echo e($sale->pax_issue_date); ?></td>
                    </tr>
                    <tr>
                      <th>Passport Expire Date:</th>
                      <td><?php echo e($sale->pax_expire_date); ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </table>
        </div>
        <div class="clearfix"></div>
      </div> <!-- /.box -->
    </div> <!--/.col (left) -->

  </div> <!-- /.row -->
</section> <!-- /.content -->

<script>
  function showHide(e)
  {
    e.parentNode.parentNode.nextElementSibling.classList.toggle('hide');
  }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/sales/read_sale.blade.php ENDPATH**/ ?>