<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'Customer Details'); ?>
<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Customer Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Customer Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="<?php echo e(route('customer.index')); ?>" title="View <?php echo e(Session::get('_types')); ?> customers" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="<?php echo e(route('customer.edit',$customer->id)); ?>" class="label label-warning" title="Edit this customer"><i class="fa fa-edit"></i></a>
            

            <?php if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])): ?>
            <a href="<?php echo e(route('customer.delete',$customer->id)); ?>" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-trash"></i></a>
            <?php endif; ?>
            
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th width=250>Category:</th>
                  <td><?php echo e($customer->category); ?></td>
                </tr>
                <tr>
                  <th>Client:</th>
                  <td><?php echo e($customer->client_type); ?></td>
                </tr>
                <tr>
                  <th>Full Name:</th>
                  <td><?php echo e($customer->name); ?></td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td><?php echo e($customer->email); ?></td>
                </tr>
                <tr>
                  <th>Contact:</th>
                  <td><?php echo e($customer->contact); ?></td>
                </tr>
                <tr>
                  <th>Alternate Contact:</th>
                  <td><?php echo e($customer->contact_2); ?></td>
                </tr>
                <tr>
                  <th>WhatsApp:</th>
                  <td><?php echo e($customer->whatsapp); ?></td>
                </tr>
                <tr>
                  <th>Gender:</th>
                  <td><?php echo e($customer->gender); ?></td>
                </tr>
                <tr>
                  <th>Walking Customer:</th>
                  <td><?php echo e($customer->walking_customer); ?></td>
                </tr>
                <tr>
                  <th>Opening Balance Type:</th>
                  <td><?php echo e($customer->balance_type); ?></td>
                </tr>
                <tr>
                  <th>Current Balance:</th>
                  <td><?php echo e($customer->amount); ?></td>
                </tr>
                <tr>
                  <th>Address:</th>
                  <td><?php echo e($customer->address); ?></td>
                </tr>
                <tr>
                  <th>Created On:</th>
                  <td><?php echo e($source->dtformat($customer->created_at)); ?> </td>
                </tr>
                <tr>
                  <th>Updated On:</th>
                  <td><?php echo e($source->dtformat($customer->updated_at)); ?> </td>
                </tr>
                
                
                <tr>
                  <th>Photo: </th>
                  <td><a href="<?php echo e($customer->image); ?>" target="_blank"><img src="<?php echo e($customer->image); ?>" width=60></a></td>
                </tr>
                <tr>
                  <th>Pax Name:</th>
                  <td><?php echo e($customer->pax_name); ?></td>
                </tr>
                <tr>
                  <th>Pax Type:</th>
                  <td><?php echo e($customer->pax_type); ?></td>
                </tr>
                <tr>
                  <th>Pax Mobile Number:</th>
                  <td><?php echo e($customer->pax_mobile); ?></td>
                </tr>
                <tr>
                  <th>Pax Email:</th>
                  <td><?php echo e($customer->pax_email); ?></td>
                </tr>
                <tr>
                  <th>Passport No.:</th>
                  <td><?php echo e($customer->passport_no); ?></td>
                </tr>
                <tr>
                  <th>NID No.:</th>
                  <td><?php echo e($customer->nid); ?></td>
                </tr>
                <tr>
                  <th>Date of Birth:</th>
                  <td><?php echo e($source->dformat($customer->birth_date)); ?></td>
                </tr>
                <tr>
                  <th>Passport Issue Date:</th>
                  <td><?php echo e($customer->pax_issue_date); ?></td>
                </tr>
                <tr>
                  <th>Passport Expire Date:</th>
                  <td><?php echo e($customer->pax_expire_date); ?></td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td><?php echo e($customer->details); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          
        </div>
      </div><!-- /.box -->

      
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/customers/read_customer.blade.php ENDPATH**/ ?>