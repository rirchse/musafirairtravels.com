
<?php $__env->startSection('title', 'Invoice Add to return'); ?>
<?php $__env->startSection('content'); ?>

<section class="content-header">
  <h1>Refund Invoice </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Invoice</a></li>
    <li class="active">Re-Fund Invoice</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-12"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Air Ticket Information</h3>
        </div>
        <?php echo Form::open(['route' => 'sale.refund.store', 'method' => 'POST', 'files' => true, 'name' => 'refund']); ?>

        <div class="box-body">
          <div class="col-md-3">
            <div class="form-group">
              <label for="client">Select Client</label>
              <select name="client_id" id="client" class="form-control select2" onchange="searchInvoices(this)" required>
                <option value="">Select Client</option>
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
            <label for="invoice">Select Invoice No.</label>
            <select name="invoice_id" id="invoice" class="form-control select2" onchange="searchTickets(this)" required>
            </select>
          </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label for="ticket_no">Select Ticket No.</label>
            <select name="ticket_no[]" id="ticket_no" class="form-control select2" multiple="multiple" onchange="getTicket(this)" required>
            </select>
          </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="date">Refund Date</label>
              <input type="date" class="form-control" name="date" id="date">
            </div>
          </div>
          <div class="col-md-1"><br>
            <button type="submit" class="btn btn-info pull-right"> Submit</button>
          </div>
          <div class="clearfix"></div>
          <?php echo Form::close(); ?>


        </div> <!-- /.box-body -->
      </div> <!-- /.box -->
      </div> <!--/.col (left) -->
    </div> <!-- /.row -->
    <?php if(isset($tickets)): ?>
    <div class="row"> <!-- left column -->
      <div class="col-md-12"> <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Information Details</h3>
          </div>
          <?php echo Form::open(['route' => 'sale.refund.store', 'method' => 'POST', 'files' => true, 'name' => 'refund']); ?>

          <div class="box-body">
            <table class="table table-bordered">
              <tr>
                <th>SL</th>
                <th>Pax Name</th>
                <th>PNR</th>
                <th>Profit</th>
                <th>Selling Price</th>
                <th>Discount</th>
                <th>Refund Charge From Client</th>
                <th>Vendor</th>
                <th>Airline</th>
                <th>Purchase Price</th>
                <th>Refund Charge Taken by Vendor</th>
              </tr>
              <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td>
                  <?php echo e($key+1); ?>

                  <input type="hidden" name="sale_ids[]" value="<?php echo e($val->id); ?>">
                  <input type="hidden" name="invoice_id[]" value="<?php echo e($val->invoice_id); ?>">
                  <input type="hidden" name="ticket_no[]" value="<?php echo e($val->ticket_no); ?>">
                </td>
                <td><?php echo e($val->pax_name); ?></td>
                <td><?php echo e($val->pnr); ?></td>
                <td><?php echo e($val->profit); ?></td>
                <td><?php echo e($val->client_price); ?></td>
                <td><?php echo e($val->discount); ?></td>
                <td><input type="number" class="form-control" name="client_charges[]" id="client_charge" step="0.01" onkeyup="calc()" required></td>
                <td><?php echo e($val->name); ?></td>
                <td><?php echo e($val->airline); ?></td>
                <td><?php echo e($val->purchase); ?></td>
                <td><input type="number" class="form-control" name="vendor_charges[]" id="vendor_charge" step="0.01" onkeyup="calc()"></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
            <div class="col-md-12">
              <button type="submit" class="btn btn-warning pull-right"> Submit</button>
            </div>
            <div class="clearfix"></div>
            <?php echo Form::close(); ?>

  
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
      <?php endif; ?>
  </section> <!-- /.content -->
  <script>
    function searchClients(e)
    {
      $.ajax({
        type: 'GET',
        url: '/search_clients/'+e.value,
        success: function (data){
          var names = '';
          var clients = document.getElementById('clients');

          var obj = JSON.parse(JSON.stringify(data));
          $.each(obj['data'], function (key, val){
              names += '<option value="'+val.name+'">';
          });

          clients.innerHTML = names;
          clients.setAttribute('list', 'clients');
        },
        error: function (data){
            //
        }
        });
    }

    function searchInvoices(e)
    {
      $.ajax({
        type: 'GET',
        url: '/search_invoices/'+e.options[e.selectedIndex].value,
        success: function (data){
          var names = '<option value="">Select Invoice</option>';
          var tickets = '<option value="">Select Ticket No.</option>';
          var invoice = document.getElementById('invoice');

          var obj = JSON.parse(JSON.stringify(data));
          $.each(obj['invoices'], function (key, val){
              names += '<option value="'+val.invoice_id+'">'+val.invoice_id+'</option>';
          });

          $.each(obj['tickets'], function (key, val){
              tickets += '<option value="'+val.id+'">'+val.ticket_no+'</option>';
          });

          invoice.innerHTML = names;
          ticket_no.innerHTML = tickets;
        },
        error: function (data){
            //
        }
        });
    }

    function getTicket(e)
    {
      var form = document.forms['refund'];
      // console.log(form['pax_name']);
      $.ajax({
        type: 'GET',
        url: '/get_ticket/'+e.options[e.selectedIndex].value,
        success: function (data){
          // var val = JSON.parse(data);
          var val = JSON.parse(JSON.stringify(data));
          val = val['ticket'];
          // console.log(val.pax_name);
          form['pax_name'].value = val.pax_name;
          form['pnr'].value = val.pnr;
          form['selling_price'].value = val.client_price;
          form['purchase'].value = val.purchase;
          // form['profit'].value = val.profit;
          form['vendor_id'].innerHTML = '<option value="'+val.vendor_id+'">'+val.vendor_name+'</option>';
          form['airline'].value = val.airline;
        },
        error: function (data){
            //
        }
        });
    }

    function calc()
    {
      var client_charge = document.getElementById('client_charge');
      var vendor_charge = document.getElementById('vendor_charge');
      var profit = document.getElementById('profit');

      profit.value = client_charge.value - vendor_charge.value;
    }
  </script>
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('scripts'); ?>
  <script>    
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    });
  </script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/refunds/refund_create.blade.php ENDPATH**/ ?>