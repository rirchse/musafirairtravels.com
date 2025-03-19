@extends('print')
@section('title', 'Money Receipt print')
@section('content')

@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

<style>
  .table-border tr td, .table-border tr th{border:1px solid #888!important; padding: 5px 10px}
  .hide{display: none}
</style>

<div style="font-size:22px;text-align:center; margin-bottom:10px">
  <input type="hidden" value="{{$invoice->id}}" id="order_id">
  <a href="{{route('payment.type.index', $invoice->user_type)}}" title="View" class="btn btn-success"><i class="fa fa-list"></i> View</a>
  <button href="#" title="Print" class="btn btn-info" onclick="document.title = '{{$invoice->name.'_'.$invoice->id}}'; printDiv();"><i class="fa fa-print"> Print</i></button>
  <div class="clearfix"></div>
  <div style="font-size:14px;margin-top:15px">
    <button class="btn btn-danger" onclick="document.getElementById('office').remove()">x Remove Office Copy</button>
  </div>
</div>

<div style="padding:25px; width:220mm; margin:0 auto">
<table id="table" style="background: #fff; max-width:216mm; margin:0 auto; font-size:12px; padding:0">
    <tr>
      <td style="padding:5px 10px">
        {{-- client Copy --}}
        @include('layouts.print_header')

        <table class="table">
          <tr>
            <td colspan="2" style="text-align: center">
              <div class="text-align:center; ">
                <span style="font-size:20px;">MONEY RECEIPT
                </span><br>
                <span>({{$invoice->user_type}} Copy)</span>
            </div>
            </td>
          </tr>
          <tr>
            <td style="padding:5px 15px">
              <table class="table" style="margin-bottom:0">
                <tr>
                  <td>Receipt No. <span style="border-bottom:1px dotted">MR-00000{{$invoice->id}}</span></td>
                  <td style="text-align:right">Date: <span style="border-bottom:1px dotted">{{ $source->dformat($invoice->date)}}</span></td>
                </tr>
                <tr>
                  <td colspan="2"> <span>Received with thanks from: </span><span style="border-bottom:1px dotted; display:inline-block; width:470px"> {{$invoice->user_name}}</span> </td>
                </tr>
                <tr>
                  <td colspan="2"> Amount in word: <span style="border-bottom:1px dotted; display:inline-block; width:535px"><span id="words"></span> BDT </span> </td>
                </tr>
                <tr>
                  <td colspan="2">Payment For: <span style="border-bottom:1px dotted; display:inline-block; width:250px">Overall</span> Balance: <span style="border-bottom:1px dotted; display:inline-block; width:245px" id="balance">{{$invoice->balance}}</span></td>
                </tr>
                <tr>
                  <td colspan="2">Paid Via: <span style="border-bottom:1px dotted; display:inline-block; width:190px">{{$invoice->payment_by}}</span> Account Name: <span style="border-bottom:1px dotted; display:inline-block; width:290px">{{$invoice->bank_name}}</span></td>
                </tr>
                <tr>
                  <td colspan="2"> For the purpose of: <span style="border-bottom:1px dotted; display:inline-block; width:518px">{{$invoice->details}}</span> </td>
                </tr>
                <tr>
                  <td><br>
                    <span style="border:1px dotted; font-size:16px; padding:5px 10px">Amount of Taka: <span id="number">{{$invoice->amount}}</span> BDT</span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

        <table class="table" style="width: 100%">
          <tr>
            <td style="padding:25px 15px">
              <table class="table" style="border:none; width:100%;margin-bottom:0">
                <tr>
                  <td style="text-align:left"><b style="border-top:1px dotted ">Customer Signature</b></td>
                  {{-- <td style="text-align:center">{{$source->dtformat($invoice->created_at)}}</td> --}}
                  <td style="text-align:right"><b style="border-top:1px dotted ">Authority Signature</b></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr id="office">
      <td>
        {{-- office copy --}}
        @include('layouts.print_header')

        <table class="table">
          <tr>
            <td colspan="2" style="text-align: center">
              <div class="text-align:center; ">
                <span style="font-size:20px;">MONEY RECEIPT
                </span><br>
                <span>(Office Copy)</span>
            </div>
            </td>
          </tr>
          <tr>
            <td style="padding:5px 15px">
              <table class="table" style="margin-bottom:0">
                <tr>
                  <td>Receipt No. <span style="border-bottom:1px dotted">MR-00000{{$invoice->id}}</span></td>
                  <td style="text-align:right">Date: <span style="border-bottom:1px dotted">{{ $source->dformat($invoice->date)}}</span></td>
                </tr>
                <tr>
                  <td colspan="2"> <span>Received with thanks from: </span><span style="border-bottom:1px dotted; display:inline-block; width:470px"> {{$invoice->user_name}}</span> </td>
                </tr>
                <tr>
                  <td colspan="2"> Amount in word: <span style="border-bottom:1px dotted; display:inline-block; width:535px"><span id="words2"></span> BDT </span> </td>
                </tr>
                <tr>
                  <td colspan="2">Payment For: <span style="border-bottom:1px dotted; display:inline-block; width:250px">Overall</span> Balance: <span style="border-bottom:1px dotted; display:inline-block; width:245px" id="balance2">{{$invoice->balance}}</span></td>
                </tr>
                <tr>
                  <td colspan="2">Paid Via: <span style="border-bottom:1px dotted; display:inline-block; width:190px">{{$invoice->payment_by}}</span> Account Name: <span style="border-bottom:1px dotted; display:inline-block; width:290px">{{$invoice->bank_name}}</span></td>
                </tr>
                <tr>
                  <td colspan="2"> For the purpose of: <span style="border-bottom:1px dotted; display:inline-block; width:518px">{{$invoice->details}}</span> </td>
                </tr>
                <tr>
                  <td><br>
                    <span style="border:1px dotted; font-size:16px; padding:5px 10px">Amount of Taka: <span id="number">{{$invoice->amount}}</span> BDT</span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

        <table class="table" style="width: 100%">
          <tr>
            <td style="padding:35px 15px">
              <table class="table" style="border:none; width:100%;margin-bottom:0">
                <tr>
                  <td style="text-align:left"><b style="border-top:1px dotted ">Customer Signature</b></td>
                  <td style="text-align:right"><b style="border-top:1px dotted ">Authority Signature</b></td>
                </tr>
              </table>
            </td>
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
        '.pageheader{font-size:13px}'+
        'table { border-collapse:collapse; font-size:14px}' +
        '.table tr th, .table tr td {padding:5px 0}' +
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
    document.getElementById('words2').innerHTML = in_words;
  };
  getWords();

  //check balance
  function balance()
  {
    var balance = document.getElementById('balance');
    var balance2 = document.getElementById('balance2');
    if(Number(balance.innerHTML) < 0)
    {
      balance.innerHTML = '<span style="color:red">Due '+balance.innerHTML.substring(1)+' BDT<span>';
      balance2.innerHTML = '<span style="color:red">Due '+balance2.innerHTML.substring(1)+' BDT<span>';
    }
    else if(Number(balance.innerHTML) > 0)
    {
      balance.innerHTML = '<span style="color:green">Adv '+balance.innerHTML+' BDT<span>';
      balance2.innerHTML = '<span style="color:green">Adv '+balance2.innerHTML+' BDT<span>';
    }
    
  }

  balance();
</script>
@endsection