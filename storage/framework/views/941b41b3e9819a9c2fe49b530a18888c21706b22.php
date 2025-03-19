
<?php $__env->startSection('title', 'sale print'); ?>
<?php $__env->startSection('content'); ?>

<?php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
?>

<style>
  .table-border tr td, .table-border tr th{border:1px solid #888!important; padding: 5px 10px}
</style>

<div style="font-size:22px;text-align:center; margin-bottom:10px">
  <input type="hidden" value="<?php echo e($invoice->id); ?>" id="order_id">
  <a href="<?php echo e(route('invoice.type.index', $invoice->type)); ?>" title="View" class="btn btn-success"><i class="fa fa-list"></i> View Invoices</a>
  <button href="#" title="Print" class="btn btn-info" onclick="document.title = '<?php echo e($invoice->name.'_'.$invoice->id); ?>'; printDiv();"><i class="fa fa-print"> Print</i></button>
</div>

<table id="table" style="background: #fff; width:100%; max-width:216mm; margin:0 auto;font-size:14px;">
    <tr>
      <td style="padding:15px;height:100px">
        <?php echo $__env->make('layouts.print_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <div style="font-size:20px; text-align:center; border:1px solid; max-width:100px; margin: 10px auto">INVOICE</div>
      </td>
    </tr>
    <tr>
      <td style="padding:0 15px">
        <div style="padding:0 0 15px 0">
          <table class="table" style="width:100%">
            <tr>
              <td>
                <b style="font-size:18px">Invoice To-</b><br>
                <b>Name: </b> <?php echo e($invoice->name); ?><br>
              </td>
              <td style="width:200px;text-align:left">
                <b>Invoice Date: </b> <?php echo e($source->dformat($invoice->issue_date)); ?><br>
                <b>Invoice No.: </b># <?php echo e($invoice->id); ?><br>
                <b>Sales Date:</b> <?php echo e($source->dformat($invoice->issue_date)); ?><br>
                <b>Sales By:</b> <?php echo $invoice->user_name; ?><br>
              </td>
            </tr>
          </table>
            <table class="table-border" style="width:100%;border:1px solid; padding:5px; margin-bottom:0">
              <b>BILLING INFO:</b>
              <tr>
                <th>SL</th>
                <?php if($invoice->type == 'VISA'): ?>
                <th>Visa Type</th>
                <?php elseif($invoice->type == 'Hotel'): ?>
                <th>Hotel Name</th>
                <th>Room No.</th>
                <?php elseif($invoice->type == 'Other'): ?>
                <th>Pax Name</th>
                <?php endif; ?>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
              </tr>
              <?php
              $total = $discount = $net_total = $paid = $due = 0;
              ?>
              <tr>
                <td>1</td>
                <?php if($invoice->type == 'VISA'): ?>
                <td><?php echo e($invoice->visa_type); ?></td>
                <?php elseif($invoice->type == 'Hotel'): ?>
                <td><?php echo e($invoice->hotel_name); ?></td>
                <td><?php echo e($invoice->room_no); ?></td>
                <?php elseif($invoice->type == 'Other'): ?>
                <td><?php echo e($invoice->pax_name); ?></td>
                <?php endif; ?>
                <td><?php echo e($invoice->quantity); ?></td>
                <td><?php echo e($invoice->unit_price); ?></td>
                <td><?php echo e($invoice->quantity * $invoice->unit_price); ?></td>
              </tr>
              <?php
              $total += $invoice->quantity * $invoice->unit_price;
              ?>
            </table><br>
            <div class="clearfix"></div>
            <table class="table-border" style="float: right; max-width:250px;width:100%">
              <tr>
                <td style="padding:5px;text-align:right"  class="text-right">Sub-Total:</td>
                <td> <?php echo e($total); ?> Tk.</td>
              </tr>
              
              <tr>
                <td style="padding:5px;text-align:right"  class="text-right">Net Total:
                </td>
                <td><span id="net_total"><?php echo e(number_format($total - $discount, 0, '.', '')); ?></span> Tk.</td>
              </tr>
            </table>
            <br>
          </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: right;padding:15px"> <b>In Word:</b> <span id="words"></span> BDT
        </td>
      </tr>
    <tr>
      <td style="padding-top:35px; padding:15px">
        <table class="table" style="border:none; width:100%;">
          <tr>
            <td style="text-align:left"><b style="border-top:1px dashed ">Customer Signature</b></td>
            <td style="text-align:center"><?php echo e($source->dtformat($invoice->created_at)); ?></td>
            <td style="text-align:right"><b style="border-top:1px dashed ">Authority Signature</b></td>
          </tr>
        </table>
      </td>
    </tr>
</table>

<script type="text/javascript">

//js print a div
  function printDiv() {
    var divToPrint = document.getElementById('table');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        '.pageheader{font-size:15px}'+
        'table { border-collapse:collapse; font-size:15px}' +
        '.table-border tr th, .table-border tr td { padding: 10px; border:1px solid #ddd; text-align:left}' +
        'table tr{background: #ddd}'+
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open(htmlToPrint);
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();

    /* change printing status */
    // var order_id = document.getElementById('order_id');
    // $.ajax({
    //   'type': 'GET',
    //   'url': '/sale/print/'+order_id.value+'/change',
    //   success: function (data){
    //     console.log('working!');
    //   },
    //   error: function (data){
    //     console.log('Getting error!');
    //   }
    // });
  }

  /* number to in word */
  var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
  var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

  function inWords (num) {
      if ((num = num.toString()).length > 9) return 'overflow';
      n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
      if (!n) return; var str = '';
      str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
      str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
      str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
      str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
      str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
      return str;
  }

  function getWords() {
    var net_total = document.getElementById('net_total').innerHTML;
    var net_tota_tofixed = Number(net_total).toFixed();
    var in_words = inWords(net_tota_tofixed)
    document.getElementById('words').innerHTML = in_words;
  };
  getWords();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('print', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/invoice_others/print_invoice.blade.php ENDPATH**/ ?>