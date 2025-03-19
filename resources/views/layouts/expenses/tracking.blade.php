@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
function check($data)
{
  if(isset($data))
  {
    return $data;
  }

  return '';
}

$start_date = $end_date = '';
if(isset($data['start_date']) && isset($data['end_date']))
{
  $start_date = $data['start_date'];
  $end_date = $data['end_date'];
}
@endphp

@extends('dashboard')
@section('title', 'Loss/Profit History')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Gross Profit/Loss History</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Profit/Loss</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <style>
      .rtd{width:100px; text-align: right}
    </style>

    <!-- Main content -->
    <div class="row"><br>
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="box box-info"style="padding:6px">
          <form action="{{route('earning.post')}}" method="POST">
            @csrf
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" class="form-control" name="start_date" value="{{$start_date}}" required id="startDate" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" class="form-control" name="end_date" value="{{$end_date}}" required id="endDate" />
              </div>
            </div>
            <div class="col-md-2"><br>
              <input type="submit" class="btn btn-primary" value="Submit">
            </div>
          </form><br>
            <a class="btn btn-info pull-right" onclick="printDiv()" ><i class="fa fa-print"></i></a>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
  <section class="content" id="table" style="padding-top:0;margin-top:0">
    <div class="row">
      <table style="display:none" id="heading">
        <tr>
          <td style="width: 100%;">
            @include('layouts.print_header')
          </td>
        </tr>
        <tr><td colspan="2" id="printDate" style="text-align: center;padding-top:15px;padding-bottom:0"></td></tr>
      </table>
    </div>
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title" style="">Expense Details</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            {{-- <a href="{{route('expense.index')}}" title="View {{Session::get('_types')}} expenses" class="label label-success"><i class="fa fa-list"></i></a> --}}
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th>Office Expenses:</th>
                    <td style="width:100px;text-align:right">{{check($data['office']+$data['other'])}}</td>
                  </tr>
                  <tr>
                    <th>Staff Salaries:</th>
                    <td style="width:100px;text-align:right">{{$data['salary']}}</td>
                  </tr>
                  <tr>
                    <th>Agent Payment:</th>
                    <td style="width:100px;text-align:right">{{$data['agent']}}</td>
                  </tr>
                  <tr>
                    <th>Client & Money Receipt Discount:</th>
                    <td style="width:100px;text-align:right">{{$data['discount']}}</td>
                  </tr>
                  <tr>
                    <th>Bank Charge:</th>
                    <td style="width:100px;text-align:right">{{$data['bank_charge']}}</td>
                  </tr>
                  <tr>
                    <th>Vendor AIT:</th>
                    <td style="width:100px;text-align:right">{{$data['ait']}}</td>
                  </tr>
                  {{-- <tr>
                    <th>Others:</th>
                    <td style="width:100px;text-align:right">{{$data['other']}}</td>
                  </tr> --}}
                  <tr>
                    <th>Total Expense:</th>
                    <th style="width:100px;text-align:right">{{$data['total']}} </th>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>
      </div><!-- /.col -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Sales & Profit Details</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            {{-- <a href="{{route('expense.index')}}" title="View {{Session::get('_types')}} expenses" class="label label-success"><i class="fa fa-list"></i></a> --}}
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th>Sales Amount:</th>
                    <td style="width:100px;text-align:right">{{check($data['sales'])}}</td>
                  </tr>
                  <tr>
                    <th>Purchase Price:</th>
                    <td style="width:100px;text-align:right">{{$data['purchase']}}</td>
                  </tr>
                  <tr>
                    <th>Sales Profit:</th>
                    <td style="width:100px;text-align:right">{{$data['profit']}}</td>
                  </tr>
                  <tr>
                    <th>Refund Profit:</th>
                    <td style="width:100px;text-align:right">{{$data['refund']}}</td>
                  </tr>
                  <tr>
                    <th>Tour Package Profit:</th>
                    <td style="width:100px;text-align:right">{{$data['tour_profit']}}</td>
                  </tr>
                  <tr>
                    <th>Service Charge:</th>
                    <td style="width:100px;text-align:right">{{$data['service_charge']}}</td>
                  </tr>
                  <tr>
                    <th>Gross Profit/Loss:</th>
                    <th style="width:100px;text-align:right">{{$data['profit']+$data['refund']}}</th>
                  </tr>
                  <tr>
                    <th>Void Charge:</th>
                    <td style="width:100px;text-align:right">{{$data['void']}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>
      </div><!-- /.box -->
    </div><!--/.row -->
    <div class="row"><br>
      <div class="col-md-12">
        <div class="box box-info">
          <table class="table">
            <tr>
              <td style="text-align: right">Total Gross Profit/Loss = <b>{{$data['gross_profit']}}</b></td>
              
              <td style="text-align: right">Total Expenses = <b>{{$data['total']}}</b></td>
              
              <td style="text-align: right">Net Profit/Loss = <b>{{$data['gross_profit'] - $data['total']}}</b></td>
              
            </tr>
          </table>
        </div>
      </div>
    </div>
  </section><!-- /.content -->
  <script>
    function printdate()
    {
      let startDate = document.getElementById('startDate');
      let endDate = document.getElementById('endDate');
      let printDate = document.getElementById('printDate');

      if(startDate.value != '' && endDate.value != '')
      {
        let sdt = new Date(startDate.value);
        let edt = new Date(endDate.value);
        printDate.innerHTML = 'Report Date: '+sdt.getDate()+ '/' +(sdt.getMonth()+1)+'/'+sdt.getFullYear() +' to '+edt.getDate()+ '/' +(edt.getMonth()+1)+'/'+edt.getFullYear();
      }
      
    }
    //js print a div
  function printDiv()
  {
    printdate();

    document.getElementById('heading').style.display = 'block';
    var divToPrint = document.getElementById('table');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        '.heading{display:block}'+
        '.pageheader{font-size:15px}'+
        'table { border-collapse:collapse; font-size:15px;width:100%}' +
        '.table tr th, .table tr td { padding: 9px; border:1px solid #ddd; text-align:left}' +
        'table tr{background: #ddd}'+
        '.receipt{display:none}'+
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open(htmlToPrint);
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
    document.getElementById('heading').style.display = 'none';
  }
  </script>
@endsection
