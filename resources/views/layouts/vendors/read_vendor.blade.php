@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
@endphp

@extends('dashboard')
@section('title', 'Vendor Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vendor Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vendors</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Vendor Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('vendor.index')}}" title="View {{Session::get('_types')}} vendors" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('vendor.edit', $vendor->id)}}" class="label label-warning" title="Edit this vendor"><i class="fa fa-edit"></i></a>
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}

            @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
            <form action="{{route('vendor.destroy', $vendor->id)}}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-trash"></i></button>
            </form>
            @endif            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Name:</th>
                    <td>{{$vendor->name}}</td>
                  </tr>
                  
                  <tr>
                    <th>Email:</th>
                    <td>{{$vendor->email}}</td>
                  </tr>
                  <tr>
                    <th>Contact:</th>
                    <td>{{$vendor->contact}}</td>
                  </tr>
                  <tr>
                    <th>Address:</th>
                    <td>{{$vendor->address}}</td>
                  </tr>
                  <tr>
                    <th>Business Name:</th>
                    <td>{{$vendor->business_name}}</td>
                  </tr>
                  <tr>
                    <th>{{$vendor->balance_type}} Balance:</th>
                    <td>{!! $source->balance($vendor->amount) !!}</td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$vendor->details}}</td>
                  </tr>
                  <tr>
                    <th>Photo:</th>
                    <td>
                      <a target="_blank" href="{{$vendor->image}}">
                        <img src="{{$vendor->image}}" width="100" alt="">
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{$source->dtformat($vendor->created_at)}} </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td>{{$source->dtformat($vendor->updated_at)}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
