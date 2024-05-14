
<?php $__env->startSection('title', 'Money Receipt print'); ?>
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
  <a href="<?php echo e(route('payment.type.index', $invoice->user_type)); ?>" title="View" class="btn btn-success"><i class="fa fa-list"></i> View</a>
  <button href="#" title="Print" class="btn btn-info" onclick="document.title = '<?php echo e($invoice->name.'_'.$invoice->id); ?>'; printDiv();"><i class="fa fa-print"> Print</i></button>
</div>

<table id="table" style="background: #fff; max-width:216mm; height:140mm; margin:0 auto;font-size:15px;">
  <thead style="vertical-align:top">
    <tr>
      <td style="padding:15px">
        <table id="print" style="width:100%; border:0;">
          <tr>
            <td style="width:40%">
              <img src="<?php echo e(asset('img/logo_print.png')); ?>" alt="" style="width: 220px;vertical-align:top; margin-top:-20px">
            </td>
            <td>
              <table>
                <tr>
                  <td>
                    <img style="vertical-align:top" src="<?php echo e(asset('img/qrcode.png')); ?>" alt=""></td>
                    <td>
                      <div style="display: inline-block; padding-left:5px">
                      <b style="font-size:20px">MUSAFIR TRAVELS</b><br>
                      House-83/2-A,(2nd Floor), Matikata Main Road, Dhaka Cant, Dhaka-1206<br>
                      <b>Mobile:</b> 01717055201, 01766089566</b><br>
                      <b>Email:</b> musafirairtravels1@gmail.com
                      </div>
                    </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </thead>
  <tbody style="vertical-align: top">
    <tr>
      <td style="padding:15px">
          <table style="width: 100%">
            <tr>
              <td colspan="2" style="text-align: center">
                <div class="text-align:center; max-width:100px; margin: 0 auto">
                  <span style="font-size:20px;">MONEY RECEIPT
                  </span><br>
                  <span>(Client Copy)</span>
              </div>
              </td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>Receipt No. <span style="border-bottom:1px dotted">MR-00000<?php echo e($invoice->id); ?></span></td>
              <td style="text-align:right">Date: <span style="border-bottom:1px dotted"><?php echo e($source->dformat($invoice->date)); ?></span></td>
            </tr>
            <tr>
              <td colspan="2"> <span>Received with thanks from: </span><span style="border-bottom:1px dotted; display:inline-block; width:550px"> <?php echo e($invoice->user_name); ?></span> </td>
            </tr>
            <tr>
              <td colspan="2"> Amount in word: <span style="border-bottom:1px dotted; display:inline-block; width:622px"><span id="words"></span> BDT </span> </td>
            </tr>
            <tr>
              <td colspan="2">Payment For: <span style="border-bottom:1px dotted; display:inline-block; width:278px">Overall</span> Balance: <span style="border-bottom:1px dotted; display:inline-block; width:300px" id="balance"><?php echo e($invoice->balance); ?></span></td>
            </tr>
            <tr>
              <td colspan="2">Paid Via: <span style="border-bottom:1px dotted; display:inline-block; width:250px"><?php echo e($invoice->payment_by); ?></span> Account Name: <span style="border-bottom:1px dotted; display:inline-block; width:313px">MUSAFIR AIR TRAVELS</span></td>
            </tr>
            <tr>
              <td colspan="2"> For the purpose of: <span style="border-bottom:1px dotted; display:inline-block; width:604px"><?php echo e($invoice->details); ?></span> </td>
            </tr>
            <tr>
              <td><br>
                <span style="border:1px dotted; font-size:18px;padding:5px 15px">Amount of Taka: <span id="number"><?php echo e($invoice->amount); ?></span> BDT</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>
  </tbody>
  <tfoot style="vertical-align: bottom">
    <tr>
      <td style="padding:15px">
        <table class="table" style="border:none; width:100%;">
          <tr>
            <td style="text-align:left"><b style="border-top:1px dotted ">Customer Signature</b></td>
            
            <td style="text-align:right"><b style="border-top:1px dotted ">Authority Signature</b></td>
          </tr>
        </table>
      </td>
    </tr>
  </tfoot>

  <thead style="vertical-align:top">
    <tr>
      <td style="padding:15px">
        <table id="print" style="width:100%; border:0;">
          <tr>
            <td style="width:40%">
              <img src="<?php echo e(asset('img/logo_print.png')); ?>" alt="" style="width: 220px;vertical-align:top; margin-top:-20px">
            </td>
            <td>
              <table>
                <tr>
                  <td>
                    <img style="vertical-align:top" src="<?php echo e(asset('img/qrcode.png')); ?>" alt=""></td>
                    <td>
                      <div style="display: inline-block; padding-left:5px">
                      <b style="font-size:20px">MUSAFIR TRAVELS</b><br>
                      House-83/2-A,(2nd Floor), Matikata Main Road, Dhaka Cant, Dhaka-1206<br>
                      <b>Mobile:</b> 01717055201, 01766089566</b><br>
                      <b>Email:</b> musafirairtravels1@gmail.com
                      </div>
                    </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </thead>
  <tbody style="vertical-align: top">
    <tr>
      <td style="padding:15px">
          <table style="width: 100%">
            <tr>
              <td colspan="2" style="text-align: center">
                <div class="text-align:center; max-width:100px; margin: 0 auto">
                  <span style="font-size:20px;">MONEY RECEIPT
                  </span><br>
                  <span>(Client Copy)</span>
              </div>
              </td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>Receipt No. <span style="border-bottom:1px dotted">MR-00000<?php echo e($invoice->id); ?></span></td>
              <td style="text-align:right">Date: <span style="border-bottom:1px dotted"><?php echo e($source->dformat($invoice->date)); ?></span></td>
            </tr>
            <tr>
              <td colspan="2"> <span>Received with thanks from: </span><span style="border-bottom:1px dotted; display:inline-block; width:550px"> <?php echo e($invoice->user_name); ?></span> </td>
            </tr>
            <tr>
              <td colspan="2"> Amount in word: <span style="border-bottom:1px dotted; display:inline-block; width:622px"><span id="words"></span> BDT </span> </td>
            </tr>
            <tr>
              <td colspan="2">Payment For: <span style="border-bottom:1px dotted; display:inline-block; width:278px">Overall</span> Balance: <span style="border-bottom:1px dotted; display:inline-block; width:300px" id="balance"><?php echo e($invoice->balance); ?></span></td>
            </tr>
            <tr>
              <td colspan="2">Paid Via: <span style="border-bottom:1px dotted; display:inline-block; width:250px"><?php echo e($invoice->payment_by); ?></span> Account Name: <span style="border-bottom:1px dotted; display:inline-block; width:313px">MUSAFIR AIR TRAVELS</span></td>
            </tr>
            <tr>
              <td colspan="2"> For the purpose of: <span style="border-bottom:1px dotted; display:inline-block; width:604px"><?php echo e($invoice->details); ?></span> </td>
            </tr>
            <tr>
              <td><br>
                <span style="border:1px dotted; font-size:18px;padding:5px 15px">Amount of Taka: <span id="number"><?php echo e($invoice->amount); ?></span> BDT</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>
  </tbody>
  <tfoot style="vertical-align: bottom">
    <tr>
      <td style="padding:15px">
        <table class="table" style="border:none; width:100%;">
          <tr>
            <td style="text-align:left"><b style="border-top:1px dotted ">Customer Signature</b></td>
            
            <td style="text-align:right"><b style="border-top:1px dotted ">Authority Signature</b></td>
          </tr>
        </table>
      </td>
    </tr>
  </tfoot>
</table>

<script type="text/javascript">

//js print a div
  function printDiv() {
    var divToPrint = document.getElementById('table');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        '.pageheader{font-size:15px}'+
        'table { border-collapse:collapse; font-size:15px}' +
        '.table tr th, .table tr td {padding:10px 0}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open(htmlToPrint);
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
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
    var net_total = document.getElementById('number').innerHTML;
    var net_tota_tofixed = Number(net_total).toFixed();
    var in_words = inWords(net_tota_tofixed)
    document.getElementById('words').innerHTML = in_words;
  };
  getWords();

  //check balance
  function balance()
  {
    var balance = document.getElementById('balance');
    if(Number(balance.innerHTML) < 0)
    {
      balance.innerHTML = '<span style="color:red">Due '+balance.innerHTML.substring(1)+' BDT<span>';
    }
    else
    {
      balance.innerHTML = '<span style="color:green">Adv '+balance.innerHTML+' BDT<span>';
    }
    
  }

  balance();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('print', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /srv/www/musafir/resources/views/layouts/payments/print_money_receipt.blade.php ENDPATH**/ ?>