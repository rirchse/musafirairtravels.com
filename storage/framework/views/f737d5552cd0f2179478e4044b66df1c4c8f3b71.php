
<?php $__env->startSection('title', 'Invoice'); ?>
<?php $__env->startSection('content'); ?>
<section class="content-header">
  <h1>Re-Issue Invoice <?php echo e($type); ?></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Invoices</a></li>
    <li class="active">Invoice</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-12"> <!-- general form elements -->
      <div class="box box-primary">
        <?php echo Form::model($sale, ['route' => ['sale.reissue.update', $sale->id], 'method' => 'PUT', 'files' => true]); ?>

        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Customer/Client Information</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                
                <div id="clientInfo">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Ticket No.</th>
                            <th>Passport No.</th>
                        </tr>
                        <tr>
                            <td><?php echo e($client->name); ?></td>
                            <td><?php echo e($client->contact); ?></td>
                            <td><?php echo e($client->email); ?></td>
                            <td><?php echo e($client->ticket_no); ?></td>
                            <td><?php echo e($client->passport_no); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
          <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Invoice Information of [<?php echo e($type); ?>]</h3>
          </div>
          <div class="box-body">
            <input type="hidden" id="customer_id" name="customer_id" value="">
            <input type="hidden" id="type" name="type" value="<?php echo e($type); ?>">
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo e(Form::label('ticket_no', 'Ticket Number (*):', ['class' => 'control-label'])); ?>

                    <?php echo e(Form::text('ticket_no', $sale->ticket_no, ['class' => 'form-control', 'placeholder' => 'Ticket Number', 'required' => ''])); ?>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo e(Form::label('vendor_id', 'Vendor (*):', ['class' => 'control-label'])); ?>

                    <select name="vendor_id" class="form-control">
                        <option value="">Select Vendor</option>
                        <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($vendor->id); ?>" <?php echo e($vendor->id == $sale->vendor_id? 'selected':''); ?>><?php echo e($vendor->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="airline">Airline</label>
                    <input class="form-control" id="airline" type="text" name="airline" placeholder="Airline" value="<?php echo e($sale->airline); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="air_ticket_class">Air Ticket Class</label>
                    <select class="form-control" id="air_ticket_class" name="air_ticket_class">
                        <option value="">Select Class</option>
                        <option value="Economy" <?php echo e($sale->air_ticket_class == 'Economy'? 'selected':''); ?>>Economy Class</option>
                        <option value="Business" <?php echo e($sale->air_ticket_class == 'Business'? 'selected':''); ?>>Business Class</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo e(Form::label('gross_fare', 'Gross Fare(Sale) (*):', ['class' => 'control-label'])); ?>

                    <?php echo e(Form::text('gross_fare', $sale->gross_fare, ['class' => 'form-control', 'placeholder' => 'Gross Fare(Sale)'])); ?>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <?php echo e(Form::label('base_fare', 'Base Fare(Buy) (*):', ['class' => 'control-label'])); ?>

                    <?php echo e(Form::text('base_fare', $sale->base_fare, ['class' => 'form-control', 'placeholder' => 'Base Fare(Buy)'])); ?>

                </div>
            </div>
            <?php if($type != 'Non-Commission'): ?>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="commission">Commission %</label>
                    <input class="form-control" id="commission" type="number" name="commission" placeholder="Commission %" value="<?php echo e($sale->commission); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="commission_amount">Commission Amount</label>
                    <input class="form-control" id="commission_amount" type="number" name="commission_amount" placeholder="Commission amount" value="<?php echo e($sale->commission_amount); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="net_commission">Net Commission</label>
                    <input class="form-control" id="net_commission" type="number" name="net_commission" placeholder="net_commission" value="<?php echo e($sale->net_commission); ?>">
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="ait">AIT</label>
                    <input class="form-control" id="ait" type="number" name="ait" placeholder="AIT" value="<?php echo e($sale->ait); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="discount">Discount</label>
                    <input class="form-control" id="discount" type="number" name="discount" placeholder="Discount" value="<?php echo e($sale->discount); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="other_bonus">Other Bonus</label>
                    <input class="form-control" id="other_bonus" type="number" name="other_bonus" placeholder="Other Bonus" value="<?php echo e($sale->other_bonus); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="extra_fee">Extra Fee</label>
                    <input class="form-control" id="extra_fee" type="number" name="extra_fee" placeholder="Extra Fee" value="<?php echo e($sale->extra_fee); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="other_expense">Other Expense</label>
                    <input class="form-control" id="other_expense" type="number" name="Other Expense" placeholder="Other Expense" value="<?php echo e($sale->other_expense); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="vat">VAT</label>
                    <input class="form-control" id="vat" type="number" name="vat" placeholder="VAT" value="<?php echo e($sale->vat); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="tax">Tax</label>
                    <input class="form-control" id="tax" type="number" name="tax" placeholder="Tax" value="<?php echo e($sale->tax); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="route">Route/Sector</label>
                    <input class="form-control" id="route" type="text" name="route" placeholder="Route/Sector" value="<?php echo e($sale->route); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="pnr">PNR</label>
                    <input class="form-control" id="pnr" type="text" name="pnr" placeholder="PNR" value="<?php echo e($sale->pnr); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="gds">GDS</label>
                    <input class="form-control" id="gds" type="text" name="gds" placeholder="GDS" value="<?php echo e($sale->gds); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="segment">Segment</label>
                    <input class="form-control" id="segment" type="text" name="segment" placeholder="Segment" value="<?php echo e($sale->segment); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="issue_date">Issue Date</label>
                    <input class="form-control" id="issue_date" type="date" name="issue_date" placeholder="Issue Date" value="<?php echo e($sale->issue_date); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="journey_date">Journey Date</label>
                    <input class="form-control" id="journey_date" type="date" name="journey_date" placeholder="Journey Date" value="<?php echo e($sale->journey_date); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label" for="return_date">Return Date</label>
                    <input class="form-control" id="return_date" type="date" name="return_date" placeholder="Return Date" value="<?php echo e($sale->return_date); ?>">
                </div>
            </div>
        
            <div class="clearfix"></div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"> </i> Re-Issue Submit</button>
            </div>
            </div> <!-- /.box body -->
          </div> <!-- /.box -->
          <?php echo Form::close(); ?>

      </div> <!--/.col-12 -->
   </div> <!-- /.row -->
</section> <!-- /.content -->

<script type="text/javascript">

    /** ----------------------------- Search Customer by ajax --------------- **/
    var mobile = document.getElementById('mobile');
    var search_customer = document.getElementById('search_customer');
    mobile.addEventListener('keyup', getCustomer);

    function searchClient(e)
    {
        var search = document.getElementById('search');
        var clientInfo = document.getElementById('clientInfo');
        var customer_id = document.getElementById('customer_id');
        if(e.value.length >= 3)
        {
            setTimeout(() => {
                $.ajax({
                    type: 'GET', //THIS NEEDS TO BE GET
                    url: '/search/customer/'+e.value,
                    success: function (data) {
                        var obj = JSON.parse(JSON.stringify(data));

                        var client = obj['data'];
                        if(client)
                        {
                        clientInfo.innerHTML = '<table class="table"><tr><th>Client Name</th><th>Contact</th><th>Email</th><th>Ticket No.</th></tr><tr><td>'+client.name+'</td><td>'+client.contact+'</td><td>'+client.email+'</td><td>'+client.ticket_no+'</td></tr></table>';
                        customer_id.value = client.id;
                        }
                        else
                        {
                            customer_id.value = '';
                            clientInfo.innerHTML = 'Customer could not found  <a href="/customer/create">Add New Customer</a>';
                        }
                    },
                    error: function(data) { 
                        //  alert('Could not retrive data from database!');
                    }
                });
            }, 1000);
        }
        else 
        {
            clientInfo.innerHTML = '';
        }
    }
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/sales/re_issue.blade.php ENDPATH**/ ?>