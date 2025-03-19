@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'View Refunded Invoice')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Refunded Invoices</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Refunded Invoices</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Refunded Invoices</h3>
              <div class="box-tools">
                <a href="{{route('sale.refund.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Create Re-Fund</a><br>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Ticket No.</th>
                  <th>Pax Name</th>
                  <th>Selling Price</th>
                  <th>Purchase Price</th>
                  <th>Client Price</th>
                  <th>Vendor Price</th>
                  <th>Refund Date</th>
                  <th width="110">Action</th>
                </tr>

                @foreach($sales as $return)

                <tr>
                  <td>{{$return->ticket_no}}</td>
                  <td>{{$return->pax_name}}</td>
                  <td>{{$return->client_price}}</td>
                  <td>{{$return->purchase}}</td>
                  <td>{{$return->client_charge}}</td>
                  <td>{{$return->vendor_charge}}</td>
                  <td>{{ $source->dformat($return->date)}}</td>
                  
                  <td>
                    <a href="{{route('sale.refund.show', $return->id)}}" class="label label-info" title="sale Details"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="/return/{{$return->id}}/delete" class="label label-danger" onClick="return confirm('Are you sure you want to delete this!')" title="Delete This Item"><i class="fa fa-trash"></i></a> --}}
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$sales->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
@endsection
