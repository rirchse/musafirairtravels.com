@extends('print')
@section('title', 'sale print')
@section('content')

@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

<style>
  .table-border tr td, .table-border tr th{border:1px solid #888!important; padding: 5px 10px}
</style>

<div style="font-size:22px;text-align:center; margin-bottom:10px">
  <input type="hidden" value="{{$invoice->id}}" id="order_id">
  <a href="{{route('invoice.type.index', $invoice->type)}}" title="View" class="btn btn-success"><i class="fa fa-list"></i> View Invoices</a>
  <button href="#" title="Print" class="btn btn-info" onclick="document.title = '{{$invoice->name.'_'.$invoice->id}}'; printDiv();"><i class="fa fa-print"> Print</i></button>
</div>

<table id="table" style="background: #fff; max-width:216mm; height:279mm; margin:0 auto;font-size:15px;">
  <thead style="vertical-align:top">
    <tr>
      <td style="padding:15px">
        <table id="print" style="width:100%; border:0;">
          <tr>
            <td style="width:40%">
              <img src="{{ asset('img/logo_print.png') }}" alt="" style="width: 220px;vertical-align:top; margin-top:-20px">
            </td>
            <td>
              <table>
                <tr>
                  <td>
                    <img style="vertical-align:top" src="{{ asset('img/qrcode.png') }}" alt=""></td>
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
        <div style="padding:15px 0">
          <table class="table" style="width:100%">
            <tr>
              <td colspan="2">
                <div style="font-size:20px; text-align:center; border:1px solid; max-width:100px; margin: 10px auto">INVOICE</div>
              </td>
            </tr>
            <tr>
              <td>
                <b style="font-size:18px">Invoice To-</b><br>
                <b>Name: </b> {{$invoice->name}}<br>
              </td>
              <td style="width:200px;text-align:left">
                <b>Invoice Date: </b> {{$source->dformat($invoice->created_at)}}<br>
                <b>Invoice No.: </b># {{$invoice->id}}<br>
                <b>Sales Date:</b> {{$source->dformat($invoice->created_at)}}<br>
                <b>Sales By:</b> {!! $invoice->user_name!!}<br>
              </td>
            </tr>
          </table>
            <table class="table-border" style="width:100%;border:1px solid; padding:5px">
              <h4 style="text-align:left;font-size:16px"><b>BILLING INFO:</b></h4>
              <tr>
                <th>SL</th>
                @if($invoice->type == 'VISA')
                <th>Visa Type</th>
                @elseif($invoice->type == 'Hotel')
                <th>Hotel Name</th>
                <th>Room No.</th>
                @elseif($invoice->type == 'Other')
                <th>Pax Name</th>
                @endif
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
              </tr>
              @php
              $total = $discount = $net_total = $paid = $due = 0;
              @endphp
              <tr>
                <td>1</td>
                @if($invoice->type == 'VISA')
                <td>{{$invoice->visa_type}}</td>
                @elseif($invoice->type == 'Hotel')
                <td>{{$invoice->hotel_name}}</td>
                <td>{{$invoice->room_no}}</td>
                @elseif($invoice->type == 'Other')
                <td>{{$invoice->pax_name}}</td>
                @endif
                <td>{{$invoice->quantity}}</td>
                <td>{{$invoice->unit_price}}</td>
                <td>{{$invoice->quantity * $invoice->unit_price}}</td>
              </tr>
              @php
              $total += $invoice->quantity * $invoice->unit_price;
              @endphp
            </table><br>
            <div class="clearfix"></div>
            <table class="table-border" style="float: right; max-width:250px;width:100%">
              <tr>
                <td style="padding:5px;text-align:right"  class="text-right">Sub-Total:</td>
                <td> {{$total}} Tk.</td>
              </tr>
              <tr>
                <td style="padding:5px;text-align:right" class="text-right">Discount:</td>
                <td>0 Tk.</td>
              </tr>
              <tr>
                <td style="padding:5px;text-align:right"  class="text-right">Net Total:
                </td>
                <td><span id="net_total">{{number_format($total - $discount, 0, '.', '')}}</span> Tk.</td>
              </tr>
            </table>
            <div class="clearfix"></div><br>
            <p style="text-align: right"> <b>In Word:</b> <span id="words"></span> BDT</p>
          </div>
        </td>
      </tr>
  </tbody>
  <tfoot style="vertical-align: bottom">
    <tr>
      <td style="padding:15px">
        <table class="table" style="border:none; width:100%;">
          <tr>
            <td style="text-align:left"><b style="border-top:1px dashed ">Customer Signature</b></td>
            <td style="text-align:center">{{$source->dtformat($invoice->created_at)}}</td>
            <td style="text-align:right"><b style="border-top:1px dashed ">Authority Signature</b></td>
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
@endsection