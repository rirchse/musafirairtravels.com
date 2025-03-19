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
  {{-- <a href="{{route('sale.show', $invoice->id)}}" class="label label-info" title="Sale details"><i class="fa fa-file-text"></i></a> --}}
  <a href="{{route('sale.view.type', $invoice->type)}}" title="View" class="btn btn-success"><i class="fa fa-list"></i> View Invoices</a>
  <button href="#" title="Print" class="btn btn-info" onclick="document.title = '{{$invoice->name.'_'.$invoice->id}}'; printDiv();"><i class="fa fa-print"> Print</i></button>
</div>
<div style="width:216mm; margin:0 auto; background:#fff; padding:25px">
<table id="table" style="background: #fff; width:100%; max-width:216mm; margin:0 auto;font-size:14px;">
    <tr>
      <td style="height:100px">
        @include('layouts.print_header')
      </td>
    </tr>
    <tr>
      <td style="vertical-align:top">
        <div style="padding:5px 0">
          <table class="table" style="width:100%; margin-bottom:0">
            <tr>
              <td colspan="2">
                <div style="font-size:20px; text-align:center; border:1px solid; max-width:100px; margin: 0 auto">INVOICE</div></td>
            </tr>
            <tr>
              <td>
                <b style="font-size:18px">Invoice To-</b><br>
                <b>Name: </b> {{$invoice->name}}<br>
              </td>
              <td style="width:200px;text-align:left">
                <b>Invoice Date: </b> {{$source->dformat($invoice->issue_date)}}<br>
                <b>Invoice No.: </b># {{$invoice->id}}<br>
                <b>Sales Date:</b> {{$source->dformat($invoice->issue_date)}}<br>
                <b>Sales By:</b> {!! $invoice->user_name!!}<br>
              </td>
            </tr>
          </table>
            {{-- <table class="table-border" style="width:100%;border:1px solid; padding:5px">
              <b>PAX Details:</b>
              <tr>
                <th style="border: 1px solid #eee; width:100px">SL</th>
                <th style="border: 1px solid #eee; padding:5px">PAX Name</th>
                <th style="border: 1px solid #eee; padding:5px;">Pax Type</th>
              </tr>
              @foreach($sales as $key => $sale)
              <tr>
                <td style="border: 1px solid #eee; padding:5px">{{$key+1}}</td>
                <td style="border: 1px solid #eee; padding:5px">{{$sale->pax_name}}</td>
                <td style="border: 1px solid #eee; padding:5px;">{{$sale->pax_type}}</td>
              </tr>
              @endforeach
            </table><br> --}}
            <table class="table-border" style="width:100%;border:1px solid; padding:5px">
              <b>BILLING INFO:</b>
              <tr>
                <th style="">SL</th><th style="border: 1px solid #eee; padding:5px">PAX Name</th>
                <th style="border: 1px solid #eee; padding:5px;">Pax Type</th>
                <th style="">Ticket No.</th>
                <th style="">PNR</th>
                {{-- <th style="">Unit Price</th>
                <th style="">Discount</th> --}}
                <th style="">Price BDT</th>
              </tr>
              @php
              $total = $discount = $net_total = $paid = $due = 0;
              @endphp
              @foreach($sales as $key => $sale)
              <tr>
                <td>{{$key+1}}</td>
                <td style="border: 1px solid #eee; padding:5px">{{$sale->pax_name}}</td>
                <td style="border: 1px solid #eee; padding:5px;">{{$sale->pax_type}}</td>
                <td>{{$sale->ticket_no}}</td>
                <td>{{$sale->pnr}}</td>
                <td>{{$sale->client_price}}</td>
                {{-- <td>{{$sale->discount}}</td>
                <td>{{$sale->client_price - $sale->discount}}</td> --}}
              </tr>
              @php
              $total += $sale->client_price;
              $discount += $sale->discount;
              @endphp
              @endforeach
            </table>
            <table class="table-border" style="float: right; max-width:250px;width:100%;margin-top:5px">
              {{-- <tr>
                <td style="padding:5px;text-align:right"  class="text-right">Sub-Total:</td>
                <td> {{$total}} Tk.</td>
              </tr> --}}
              {{-- <tr>
                <td style="padding:5px;text-align:right" class="text-right">Discount:</td>
                <td>{{$invoice->discount}} Tk.</td>
              </tr> --}}
              <tr>
                <td style="padding:5px;text-align:right"  class="text-right">Total:
                </td>
                <td><span id="net_total">{{number_format($total, 0, '.', '')}}</span> Tk.</td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: right">
          <b>In Word:</b> <span id="words"></span> BDT
        </td>
      </tr>
    <tr>
      <td style="vertical-align:top">
        <table class="table" style="border:none; width:100%;margin-top:35px">
          <tr>
            <td style="text-align:left"><b style="border-top:1px dashed ">Customer Signature</b></td>
            <td style="text-align:center">{{$source->dtformat($invoice->created_at)}}</td>
            <td style="text-align:right"><b style="border-top:1px dashed ">Authority Signature</b></td>
          </tr>
        </table>
      </td>
    </tr>
</table>
</div>

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