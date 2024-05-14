<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>


<?php $__env->startSection('title', 'View All Invoices'); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">
      <h1>View <?php echo e($type != '' ?$type:'All'); ?> Invoices</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Invoices</a></li>
        <li class="active">All Invoices</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Invoice</h3>
              <div class="box-tools">
                <a href="<?php echo e(route('invoice.type.create', $type)); ?>" class="btn btn-info"><i class="fa fa-plus"></i> Create Invoice</a><br>

                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered table-hover">
                <tr>
                  <th>Invoice No.</th>
                  <th>Client</th>
                  <?php if($type == 'Hotel'): ?>
                  <th>Hotel Name</th>
                  <th>Room No.</th>
                  <?php endif; ?>
                  <?php if($type == 'VISA'): ?>
                  <th>VISA Type</th>
                  <th>Country</th>
                  <th>VISA No</th>
                  <?php endif; ?>
                  <th>Qty.</th>
                  <th>Unit Price</th>
                  <th>Total Price</th>
                  <th>Vendor</th>
                  <th>Status</th>
                  <th width="120">Action</th>
                </tr>

                <tbody id="ordersTable">

                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td>#<?php echo e($sale->id); ?></td>
                  <td><?php echo e($sale->client_name); ?></td>
                  <?php if($type == 'Hotel'): ?>
                  <td><?php echo e($sale->hotel_name); ?></td>
                  <td><?php echo e($sale->room_no); ?></td>
                  <?php endif; ?>
                  <?php if($type == 'VISA'): ?>
                  <td><?php echo e($sale->visa_type); ?></td>
                  <td><?php echo e($sale->country); ?></td>
                  <td><?php echo e($sale->visa_no); ?></td>
                  <?php endif; ?>
                  <td><?php echo e($sale->quantity); ?></td>
                  <td><?php echo e($sale->unit_price); ?></td>
                  <td><?php echo e($sale->total_sale); ?></td>
                  <td><?php echo e($sale->vendor_name); ?></td>
                  
                  <td>
                    <span class="label label-<?php echo e($sale->status == 'Cancelled'? 'danger':'info'); ?>"><?php echo e($sale->status); ?></span>
                  </td>
                  <td>
                    <a href="<?php echo e(route('invoice.show', $sale->id)); ?>" class="label label-info" title="Invoice details"><i class="fa fa-file-text"></i></a>
                    <a href="<?php echo e(route('invoice.type.edit',[$type, $sale->id])); ?>" class="label label-warning" title="Edit this"><i class="fa fa-edit"></i></a>
                    
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                <?php echo e($invoices->links()); ?>

              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
    <script type="text/javascript">
    var search_sales = document.getElementById('search_sales');
    // var search_value = search_sales.value;
    
      search_sales.addEventListener('keyup', searchSale);
    
    function searchSale () {
      if(search_sales.value.length > 0){
      $.ajax({
        type: 'GET',
        url:'/search/orders/'+search_sales.value,
        success: function (data){
          
          var obj = JSON.parse(JSON.stringify(data));
          if(obj['success'] == null){
            alert('Orders not found.');
            return false;
          }

          var orders = "";
          var status = "";

          function dateFormat(element){
            var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var date = new Date(element);
            return date.getDate()+' '+month[date.getMonth()]+' '+date.getFullYear();
          }

          $.each(obj['success'], function (key, val){
            if(val.status == 0){
              status = '<span class="label label-info">New Order</span>';
            } else if(val.status == 1){
              status = '<span class="label label-warning">Confirmed</span>';
            }else if(val.status == 2){
              status = '<span class="label label-success">Completed</span>';
            }else if(val.status == 3){
              status = '<span class="label label-danger">Cancelled</span>';
            }else{
              //
            }

            var order_no = '';
            if(val.order_no){
              order_no = val.order_no;
            }

            var address = val.address;
            if(val.shipping_address){
              address = val.shipping_address;
            }


            orders += '<tr>'+
            '<td>'+order_no+'</td>'+
              '<td>'+val.full_name+'</td>'+
              '<td>'+val.contact+'</td>'+
              '<td>'+address+'</td>'+
              '<td>'+val.gtotal+' tk</td>'+
              '<td>'+val.paid+' tk</td>'+
              '<td>'+val.due+' tk</td>'+
              '<td>'+dateFormat(val.sales_date)+'</td>'+
              '<td>'+val.name+'</td>'+
              '<td>'+status+'</span></td>'+
              '<td>'+
                '<a href="/sale/'+val.id+'" class="label label-info" title="sale Details" marked="1"><i class="fa fa-file-text"></i></a>'+
                '<a href="/sale/'+val.id+'/edit" class="label label-warning" title="Edit this sale" marked="1"><i class="fa fa-edit"></i></a>'+
                '<a href="/return/'+val.id+'/order" class="label label-default" title="Add to return"><i class="fa fa-undo"></i></a>'+
              '</td>'+
            '</tr>';
          });

          $("#ordersTable").html(orders);
        },
        error: function (data){
          alert('Could not retrive data from database!');
        }
      });
}
    }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/invoice_others/index.blade.php ENDPATH**/ ?>