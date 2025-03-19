
<?php $__env->startSection('title', 'Add Client Payment'); ?>
<?php $__env->startSection('content'); ?>


<section class="content-header">
  <h1>Add <?php echo e($type? $type:''); ?> Payment</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo e($type? $type:''); ?> Payments</a></li>
    <li class="active">Add <?php echo e($type? $type:''); ?> Payment</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-7"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Payment Information</h3>
        </div>
        <?php echo Form::open(['route' => 'payment.store', 'method' => 'POST', 'files' => true]); ?>

        <input type="hidden" name="user_type" value="<?php echo e($type); ?>">
        <div class="box-body">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Payment Method:</label>
              <select name="account_id" id="method" class="form-control" onchange="getBalance(this); balCalc()">
                <option value="">Select One</option>
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="account_balance">Account Balance</label>
              <input type="number" name="account_balance" id="account_balance" class="form-control" step="0.01" onkeyup="balCalc()" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="type">Payment Type:</label>
              <select name="type" id="type" class="form-control" required onchange="balCalc()">
                <option value="Pay" <?php echo e($type == 'Vendor'? 'selected':''); ?>>Pay</option>
                <option value="Receive" <?php echo e($type == 'Client'? 'selected':''); ?>>Receive</option>
              </select>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label class="form-label"><?php echo e($type); ?> Information:</label>
              <select class="form-control select2" name="user_id" onchange="Balance(this);" required>
                <option value="">Select <?php echo e($type); ?></option>
                <?php if($type == 'Client'): ?>
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
  
                <?php if($type == 'Vendor'): ?>
                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($vendor->id); ?>"><?php echo e($vendor->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <?php echo e(Form::label('date', 'Payment Date:', ['class' => 'control-label'])); ?>

              <?php echo Form::date('date', null, ['class'=>'form-control']); ?>

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="pre_balance">Previous Balance</label>
              <input type="number" name="pre_balance" id="pre_balance" class="form-control" step="0.01" onkeyup="balCalc()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="amount"> Paid Amount:</label>
              <input type="number" id="amount" name="amount" class="form-control" step="0.01" onkeyup="balCalc()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="balance">Current Balance</label>
              <input type="number" name="balance" id="balance" class="form-control" step="0.01">
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-12">
            <div class="form-group">
              <?php echo e(Form::label('details', 'Details:', ['class' => 'control-label'])); ?>

              <?php echo Form::textarea('details', null,['class'=>'form-control', 'rows' => 5]); ?>

            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right" id="submit">Save</button>
          </div>
          <div class="clearfix"></div>
          <?php echo Form::close(); ?>


        </div> <!-- /.box -->
      </div> <!--/.col (left) -->
    </div> <!-- /.row -->
  </section> <!-- /.content -->
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('scripts'); ?>
  <script>    
    var type = document.getElementById('type');
    var balance_type = document.getElementById('balance_type');
    var pre_balance = document.getElementById('pre_balance');
    var balance = document.getElementById('balance');
    var amount = document.getElementById('amount');
    var account_balance = document.getElementById('account_balance');
    var submit = document.getElementById('submit');
    var db_bal_type = '';

    function Balance(e)
    {
      var user_type = '<?php echo e($type); ?>';
      $.ajax({
        type: 'GET',
        url: '/payment_balance/'+user_type+'/'+e.options[e.selectedIndex].value,
        success: function (data)
        {
          db_bal_type = data.success.balance_type;
          pre_balance.value = data.success.amount;
          if(data.success.amount == null)
          {
            pre_balance.value = 0;
          }
        },
        error: function (data)
        {
          //
        }
      });
    }

    function getBalance(e)
    {
      $.ajax({
        type: 'GET',
        url: '/get_balance/'+e.options[e.selectedIndex].value,
        success: function (data)
        {
          account_balance.value = data.account;
        },
        error: function (data)
        {
          //
        }
      });
    }
    
    function balCalc()
    {
      var user_type = '<?php echo e($type); ?>';
      if(type.options[type.selectedIndex].value == 'Pay')
      {
        if(user_type == 'Client')
        {
          balance.value = Number(pre_balance.value) - Number(amount.value);
        }
        else if(user_type == 'Vendor')
        {
          balance.value = Number(pre_balance.value) + Number(amount.value);
        }

        if(Number(amount.value) > Number(account_balance.value))
        {
          alert('Insufficient account balance');
          submit.setAttribute('disabled', '');
        }
        else
        {
          submit.removeAttribute('disabled'); 
        }
      }
      else
      {
        if(user_type == 'Client')
        {
          balance.value = Number(pre_balance.value) + Number(amount.value);
        }
        else if(user_type == 'Vendor')
        {
          balance.value = Number(pre_balance.value) - Number(amount.value);
        }       
      }
      
    }

  </script>

  <script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    });
  </script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/payments/create_payment.blade.php ENDPATH**/ ?>