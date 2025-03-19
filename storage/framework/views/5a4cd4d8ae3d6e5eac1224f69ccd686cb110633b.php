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
                <a href="#" data-toggle="modal" data-target="#search-form" class="btn btn-default"><i class="fa fa-search"></i></a>
                <a href="<?php echo e(route('sale.create.type', $type)); ?>" class="btn btn-info"><i class="fa fa-plus"></i> Create Invoice</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered table-hover">
                <tr>
                  <th>Invoice No.</th>
                  <th>Ticket No.</th>
                  <th>Client Name</th>
                  <th>PAX Name</th>
                  <th>Mobile</th>
                  <th>Airline</th>
                  <th>Client Price</th>
                  <th>Purchase</th>
                  <th width="120">Action</th>
                </tr>

                <tbody id="ordersTable">

                <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td>#<?php echo e($sale->invoice_id); ?></td>
                  <td><?php echo e($sale->ticket_no); ?></td>
                  <td><?php echo e($sale->name); ?></td>
                  <td><?php echo e($sale->pax_name); ?></td>
                  <td><?php echo e($sale->contact); ?></td>
                  <td><?php echo e($sale->airline); ?></td>
                  <td><?php echo e($sale->client_price); ?></td>
                  <td><?php echo e($sale->purchase); ?></td>
                  <td>
                    <a href="<?php echo e(route('sale.show', $sale->invoice_id)); ?>" class="label label-info" title="Invoice details"><i class="fa fa-file-text"></i></a>
                    <a href="<?php echo e(route('sale.edit',$sale->id)); ?>" class="label label-warning" title="Edit"><i class="fa fa-edit"></i></a>
                    
                  </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
              </table>
            </div> <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                <?php echo e($sales->links()); ?>

              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <div class="modal fade" id="search-form" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
          
          <div class="modal-body">
            <form action="<?php echo e(route('invoice.search')); ?>" method="post">
              <input type="hidden" name="type" value="<?php echo e($type); ?>">
              <?php echo csrf_field(); ?>
              <div class="form-group">
                <label for="">Search by Pax Name, Ticket No</label>
                <div class="input-group input-group-sm">
                  <input type="text" id="search" name="search" class="form-control pull-right" placeholder="Search">
                  <div class="input-group-btn">
                    <button stype="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
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
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/sales/view_sale.blade.php ENDPATH**/ ?>