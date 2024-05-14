@extends('dashboard')
@section('title', 'Invoice')
@section('content')

@php
$customer_id = $ticket_no = $air_ticket_class = $airline = $vendor_id = $gross_fare = $base_fare = $client_price = $purchase = $profit = $commission = $commission_amount = $net_commission = $ait = $discount = $other_bonus = $extra_fee = $other_expense = $vat = $tax = $route = $pnr = $gds = $segment = $issue_date = $journey_date = $return_date = $pax_name = $pax_type = $pax_mobile = $pax_email = $passport_no = $nid = $birth_date = $pax_issue_date = $pax_expire_date = '';
if(isset($invoice))
{
    $customer_id = $invoice['customer_id'];
    $ticket_no = $invoice['ticket_no'];
    $air_ticket_class = $invoice['air_ticket_class'];
    $airline = $invoice['airline'];
    $vendor_id = $invoice['vendor_id'];

    if($type == 'Air-Ticket')
    {
        $gross_fare = $invoice['gross_fare'];
        $base_fare = $invoice['base_fare'];$commission = $invoice['commission'];
        $commission_amount = $invoice['commission_amount'];
        $net_commission = $invoice['net_commission'];
        $ait = $invoice['ait'];
        $discount = $invoice['discount'];
        $other_bonus = $invoice['other_bonus'];
        $extra_fee = $invoice['extra_fee'];
        $other_expense = $invoice['other_expense'] = '';
        $vat = $invoice['vat'];
        $tax = $invoice['tax'];
        $gds = $invoice['gds'];
        $segment = $invoice['segment'];
    }

    $client_price = $invoice['client_price'];
    $purchase = $invoice['purchase'];
    $profit = $invoice['profit'];
    $route = $invoice['route'];
    $pnr = $invoice['pnr'];
    $issue_date = $invoice['issue_date'];
    $journey_date = $invoice['journey_date'];
    $return_date = $invoice['return_date'];
    $pax_name = $invoice['pax_name'];
    $pax_type = $invoice['pax_type'];
    $pax_mobile = $invoice['pax_mobile'];
    $pax_email = $invoice['pax_email'];
    $passport_no = $invoice['passport_no'];
    $nid = $invoice['nid'];
    $birth_date = $invoice['birth_date'];
    $pax_issue_date = $invoice['pax_issue_date'];
    $pax_expire_date = $invoice['pax_expire_date'];
}
@endphp
<section class="content-header">
  <h1>Invoice {{$type}}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Invoices</a></li>
    <li class="active">Invoice</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-7"> <!-- general form elements -->
      <div class="box box-primary">
        {!! Form::open(['route' => 'sale.store.session', 'method' => 'POST', 'files' => true]) !!}
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Customer/Client Information</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="search">Search Client</label>
                    <input class="form-control" id="search" type="text" placeholder="Search By Name, Email, Mobile, Ticket Number" onkeyup="searchClient(this)">
                </div>
            </div>
            <div id="clientInfo">
                @if(isset($client))
                <table class="table"><tr><th>Client Name</th><th>Contact</th><th>Email</th><th>Ticket No.</th></tr><tr><td>{{$client->name}}</td><td>{{$client->contact}}</td><td>{{$client->email}}</td><td>{{$client->ticket_no}}</td></tr></table>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
          <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Invoice Information of [{{$type}}]</h3>
          </div>
          <div class="box-body">
            <input type="hidden" id="customer_id" name="customer_id" value="{{$customer_id}}">
            <input type="hidden" id="type" name="type" value="{{$type}}">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('ticket_no', 'Ticket Number (*):', ['class' => 'control-label']) }}
                    {{ Form::text('ticket_no',  $ticket_no, ['class' => 'form-control', 'placeholder' => 'Ticket Number', 'required' => '', 'step' => '0.01', 'onkeyup' => 'checkTicketNo(this)'])}}
                    <div style="position: absolute; color:red"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="air_ticket_class">Air Ticket Class</label>
                    <select class="form-control" id="air_ticket_class" name="air_ticket_class">
                        <option value="">Select Class</option>
                        <option value="Economy" {{$air_ticket_class == 'Economy'? 'selected':''}}>Economy Class</option>
                        <option value="Business" {{$air_ticket_class == 'Business'? 'selected':''}}>Business Class</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('vendor_id', 'Vendor (*):', ['class' => 'control-label']) }}
                    <select name="vendor_id" class="form-control">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                        <option value="{{$vendor->id}}" {{$vendor_id == $vendor->id? 'selected': ''}}>{{$vendor->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="airline">Airline</label>
                    <input class="form-control" id="airline" type="text" name="airline" placeholder="Airline" value="{{$airline}}" list="airlines" onkeyup="getAirlines(this)">
                    <datalist id="airlines"></datalist>
                </div>
            </div>
            @if($type == 'Air-Ticket')
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('gross_fare', 'Gross Fare(Sale) (*):', ['class' => 'control-label']) }}
                    {{ Form::number('gross_fare', $gross_fare, ['class' => 'form-control', 'placeholder' => 'Gross Fare(Sale)', 'step' => '0.01'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('base_fare', 'Base Fare(Buy) (*):', ['class' => 'control-label']) }}
                    {{ Form::number('base_fare', $base_fare, ['class' => 'form-control', 'placeholder' => 'Base Fare(Buy)', 'step' => '0.01'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="commission">Commission %</label>
                    <input class="form-control" id="commission" type="number" name="commission" placeholder="Commission %" value="{{$commission}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="commission_amount">Commission Amount</label>
                    <input class="form-control" id="commission_amount" type="number" name="commission_amount" placeholder="Commission amount" value="{{$commission_amount}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="net_commission">Net Commission</label>
                    <input class="form-control" id="net_commission" type="number" name="net_commission" placeholder="Net Commission" value="{{$net_commission}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="ait">AIT</label>
                    <input class="form-control" id="ait" type="number" name="ait" placeholder="AIT" value="{{$ait}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="discount">Discount Amount</label>
                    <input class="form-control" id="discount" type="number" name="discount" placeholder="Discount in Amount" value="{{$discount}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="other_bonus">Other Bonus</label>
                    <input class="form-control" id="other_bonus" type="number" name="other_bonus" placeholder="Other Bonus" value="{{$other_bonus}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="extra_fee">Extra Fee</label>
                    <input class="form-control" id="extra_fee" type="number" name="extra_fee" placeholder="Extra Fee" value="{{$extra_fee}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="other_expense">Other Expense</label>
                    <input class="form-control" id="other_expense" type="number" name="other_expense" placeholder="Other Expense" value="{{$other_expense}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="vat">VAT</label>
                    <input class="form-control" id="vat" type="number" name="vat" placeholder="VAT" value="{{$vat}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="tax">Tax</label>
                    <input class="form-control" id="tax" type="number" name="tax" placeholder="Tax" value="{{$tax}}" step="0.01">
                </div>
            </div>
            @endif
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="route">Route/Sector</label>
                    <input class="form-control" id="route" type="text" name="route" placeholder="Route/Sector" value="{{$route}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="pnr">PNR</label>
                    <input class="form-control" id="pnr" type="text" name="pnr" placeholder="PNR" value="{{$pnr}}">
                </div>
            </div>
            @if($type == 'Air-Ticket')
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="gds">GDS</label>
                    <input class="form-control" id="gds" type="text" name="gds" placeholder="GDS" value="{{$gds}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="segment">Segment</label>
                    <input class="form-control" id="segment" type="text" name="segment" placeholder="Segment" value="{{$segment}}">
                </div>
            </div>
            @endif
            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="client_price">Client Price</label>
                    <input class="form-control" id="client_price" type="number" name="client_price" placeholder="Client Price" value="{{$client_price}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="purchase">Purchase</label>
                    <input class="form-control" id="purchase" type="number" name="purchase" placeholder="Purchase" value="{{$purchase}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="profit">Profit</label>
                    <input class="form-control" id="profit" type="number" name="profit" placeholder="Profit" value="{{$profit}}" step="0.01">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="issue_date">Issue Date</label>
                    <input class="form-control" id="issue_date" type="date" name="issue_date" placeholder="Issue Date" value="{{$issue_date}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="journey_date">Journey Date</label>
                    <input class="form-control" id="journey_date" type="date" name="journey_date" placeholder="Journey Date" value="{{$journey_date}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="return_date">Return Date</label>
                    <input class="form-control" id="return_date" type="date" name="return_date" placeholder="Return Date" value="{{$return_date}}">
                </div>
            </div><div class="clearfix"></div>
            <div class="box-header with-border">
                <h3 style="color: #800" class="box-title">Pax & Passport Details:</h3>
            </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_name">Pax Name</label>
                      <input class="form-control" id="pax_name" type="text" name="pax_name" placeholder="Type Passenger Name" value="{{$pax_name}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_type">Pax Type</label>
                      <select class="form-control" id="pax_type" name="pax_type">
                        <option value="">Select PAX Type</option>
                        <option value="Adult" {{$pax_type == 'Adult'?'selected':''}}>Adult</option>
                        <option value="Child" {{$pax_type == 'Child'?'selected':''}}>Child</option>
                        <option value="Infant" {{$pax_type == 'Infant'?'selected':''}}>Infant</option>
                        <option value="Others" {{$pax_type == 'Others'?'selected':''}}>Others</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_mobile">Mobile Number</label>
                      <input class="form-control" id="pax_mobile" type="phone" name="pax_mobile" placeholder="Mobile Number" value="{{$pax_mobile}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_email">Email</label>
                      <input class="form-control" id="pax_email" type="email" name="pax_email" placeholder="Email Address" value="{{$pax_email}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="passport">Passport No.</label>
                      <input class="form-control" id="passport" type="text" name="passport_no" placeholder="Passport No." value="{{$passport_no}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="nid">NID No.</label>
                      <input class="form-control" id="nid" type="text" name="nid" placeholder="NID No." value="{{$nid}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="birth_date">Date of Birth</label>
                      <input class="form-control" id="birth_date" type="date" name="birth_date" placeholder="Date of Birth" value="{{$birth_date}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_issue_date">Passport Issue Date</label>
                      <input class="form-control" id="pax_issue_date" type="date" name="pax_issue_date" placeholder="Passport Issue Date" value="{{$pax_issue_date}}">
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="pax_expire_date">Passport Expire Date</label>
                  <input class="form-control" id="pax_expire_date" type="date" name="pax_expire_date" placeholder="Passport Expire Date" value="{{$pax_expire_date}}">
                  </div>
              </div>
            <div class="clearfix"></div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" id="save"><i class="fa fa-save"> </i> Save</button>
            </div>
            </div> <!-- /.box body -->
        </div> <!-- /.box -->
          {!! Form::close() !!}
      </div> <!--/.col-12 -->
      @if(Session::get('_sales'))
      <div class="col-md-5">
        <div class="box box-info box-body">
            {{-- {{dd(Session::get('_sales'))}} --}}
            <table class="table table-stripped">
                <tr>
                    <th>Ticket No.</th>
                    <th>Sale</th>
                    <th>Purchase</th>
                    <th>Profit</th>
                    <th>Action</th>
                </tr>
                @php
                $total_client_price = $total_purchase = $total_profit = 0;
                $count = 0;
                $sales = Session::get('_sales');
                @endphp
                @foreach($sales as $key => $sale)
                <tr>
                    <td class="ticket_no">{{$sale['ticket_no']}}</td>
                    <td>{{$sale['client_price']}}</td>
                    <td>{{$sale['purchase']}}</td>
                    <td>{{$sale['profit']}}</td>
                    <td>
                        <a href="{{route('sale.copy', $sale['ticket_no'])}}" class="text-primary" title="Copy"><i class="fa fa-copy"></i></a>&nbsp;
                        <a href="{{route('sale.session.edit', $count)}}" class="text-warning" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;
                        <a href="{{route('sale.session.delete', [$key, $type])}}" class="text-danger" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @php
                $total_client_price += $sale['client_price'];
                $total_purchase += $sale['purchase'];
                $total_profit += $sale['profit'];
                $count++;
                @endphp
                @endforeach
                <tr>
                    <th>Total = </th>
                    <th>{{$total_client_price}}</th>
                    <th>{{$total_purchase}}</th>
                    <th>{{$total_profit}}</th>
                    <th></th>
                </tr>
            </table>
            <div class="box-footer"> 
                <a class="btn btn-warning pull-" href="{{route('sale.session.close', $type)}}" onclick="return confirm('Are you sure you want to close these invoices?')">Close</a> &nbsp; 
                <a class="btn btn-info pull-" href="{{route('sale.store.multi')}}"><i class="fa fa-save"> </i> Confirm</a>
            </div>
        </div>
      </div>
      @endif
   </div> <!-- /.row -->

   <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{route('sale.add.client')}}" method="POST">
            @csrf
      <div class="modal-header">
        {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
        <b>Add New Client</b>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" name="type" value="{{$type}}">
                <div class="form-group">
                  <label class="control-label" for="category">Category</label>                  
                  <select class="form-control" id="category" name="category">
                    <option value="">Select Client Category</option>
                    <option value="All Service">All Service</option>
                    <option value="Air Ticket">Air Ticket</option>
                    <option value="Hajj">Hajj</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="client_type">Client Type</label>                 
                  <select class="form-control" id="client_type" name="client_type">
                    <option value="">Select Client Type</option>
                    <option value="Individual">Individual</option>
                    <option value="Corporate">Corporate</option>
                  </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label" for="name">Client Name</label>
                  <input class="form-control" id="name" type="text" name="name" placeholder="Client Name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="contact">Mobile</label>
                  <input class="form-control" id="contact" type="text" name="contact" placeholder="Client Mobile">
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('contact_2', 'Alternate Contact (Optional):', ['class' => 'control-label']) }}
                  {{ Form::text('contact_2', null, ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('whatsapp', 'WhatsApp Contact (Optional):', ['class' => 'control-label']) }}
                  {{ Form::text('whatsapp', null, ['class' => 'form-control']) }}
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="email">Email</label>
                  <input class="form-control" id="email" type="email" name="email" placeholder="Client Email Address">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label" for="address">Address</label>
                  <input class="form-control" id="address" type="text" name="address" placeholder="Client address">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="gender">Gender</label><br>
                <label>
                    <input class="" type="radio" name="gender" value="Male"> Male
                </label>&nbsp;
                <label>
                    <input class="" type="radio" name="gender" value="Female"> Female
                </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="walking_customer"> Walking Customer?</label><br>
                  <label>
                    <input class="" type="radio" name="walking_customer"> Yes
                </label>&nbsp;
                <label>
                    <input class="" type="radio" name="walking_customer"> No
                </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="balance">Opening Balance</label>
                  <select class="form-control" id="balance" name="balance_type">
                    <option value="">Select Balance Type</option>
                    <option value="Advance">Advance</option>
                    <option value="Due">Due</option>
                  </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="amount">Amount</label>
                  <input class="form-control" id="amount" type="number" name="amount" placeholder="Amount" set="0.01">
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

</section> <!-- /.content -->

<script type="text/javascript">
    var total_price = 0;

    var base_fare   = document.getElementById('base_fare');
    var gross_fare  = document.getElementById('gross_fare');
    var purchase = document.getElementById('purchase');
    var commission = document.getElementById('commission');
    var commission_amount = document.getElementById('commission_amount');
    var net_commission = document.getElementById('net_commission');
    var tax = document.getElementById('tax');
    var other_expense = document.getElementById('other_expense');
    var client_price = document.getElementById('client_price');
    var profit = document.getElementById('profit');
    var other_bonus = document.getElementById('other_bonus');
    var extra_fee = document.getElementById('extra_fee');
    var discount = document.getElementById('discount');
    
    @if($type == 'Air-Ticket')
    base_fare.addEventListener('keyup', totalCalc);
    gross_fare.addEventListener('keyup', totalCalc);
    commission.addEventListener('keyup', totalCalc);
    other_expense.addEventListener('keyup', totalCalc);
    other_bonus.addEventListener('keyup', totalCalc);
    extra_fee.addEventListener('keyup', totalCalc);
    discount.addEventListener('keyup', totalCalc);
    @else
    client_price.addEventListener('keyup', clientProfitCalc);
    purchase.addEventListener('keyup', clientProfitCalc);
    function clientProfitCalc(){
        profit.value = client_price.value - purchase.value;
    }
    @endif

    function totalCalc()
    {
        taxCalc();
        aitCalc();
        CommCalc();
        netCommCalc();
        purchaseCalc();
        clientPriceCalc();
        profitCalc();
    }
    
    function taxCalc()
    {
        tax.value = (gross_fare.value - base_fare.value).toFixed(2);
    }

    function aitCalc()
    {
        ait.value = (Number(gross_fare.value) * 0.3 / 100).toFixed(2);
    }

    function CommCalc()
    {
        /* commission calculation */
        commission_amount.value = (Number(base_fare.value) * Number(commission.value) / 100).toFixed(2);
    }

    function netCommCalc()
    {
        net_commission.value = (Number(commission_amount.value) - Number(ait.value) - Number(other_expense.value) - Number(discount.value)).toFixed(2);
    }

    function purchaseCalc()
    {
        purchase.value = (Number(gross_fare.value) - Number(net_commission.value)).toFixed(2);
    }

    function clientPriceCalc()
    {
        client_price.value = (Number(gross_fare.value) - Number(discount.value) + Number(extra_fee.value)).toFixed(2);
    }

    function profitCalc()
    {
        profit.value = (Number(net_commission.value) + Number(other_bonus.value)).toFixed(2);
    }

    function checkTicketNo(e)
    {
        let tickets_no = document.getElementsByClassName('ticket_no');
        let save = document.getElementById('save');
        for(let x = 0; tickets_no.length > x; x++)
        {
            if(e.value == tickets_no[x].innerHTML)
            {
                e.nextElementSibling.innerHTML = 'The ticket no alread exist';
                save.setAttribute('disabled', 'disabled');
                break;
            }
            e.nextElementSibling.innerHTML = '';
            save.removeAttribute('disabled');
        }
    }

    checkTicketNo(document.getElementById('ticket_no'));

    /** ----------------------------- Search Customer by ajax --------------- **/
    var search = document.getElementById('search');
    // var search_customer = document.getElementById('search_customer');
    // search.addEventListener('keyup', searchClient);

    function searchClient(e)
    {
        var search = document.getElementById('search');
        var clientInfo = document.getElementById('clientInfo');
        var customer_id = document.getElementById('customer_id');
        if(e.value.length >= 3)
        {
            setTimeout(() => {
                $.ajax({
                    type: 'GET', //THIS NEEDS TO BE GET
                    url: '/search/customer/'+e.value,
                    success: function (data) {
                        var obj = JSON.parse(JSON.stringify(data));

                        var client = obj['data'];
                        if(client)
                        {
                        clientInfo.innerHTML = '<table class="table"><tr><th>Client Name</th><th>Contact</th><th>Email</th><th>Ticket No.</th></tr><tr><td>'+client.name+'</td><td>'+client.contact+'</td><td>'+client.email+'</td><td>'+client.ticket_no+'</td></tr></table>';
                        customer_id.value = client.id;
                        }
                        else
                        {
                            customer_id.value = '';
                            clientInfo.innerHTML = 'Customer could not found  <a href="#" data-toggle="modal" data-target="#exampleModal" >Add New Customer</a>';
                        }
                    },
                    error: function(data) { 
                        //  alert('Could not retrive data from database!');
                    }
                });
            }, 1000);
        }
        else 
        {
            clientInfo.innerHTML = '';
        }
    }

    //** ------------- customer serch end ----------------------- **//
    //** ------- search airlines by ajax and make datalist ------- **//
    function getAirlines(e)
    {
        $.ajax({
            type: 'GET',
            url: '/get_airlines/'+e.value,
            success: function (data){
                var names = '';
                var airlines = document.getElementById('airlines');

                var obj = JSON.parse(JSON.stringify(data));
                $.each(obj['success'], function (key, val){
                    names += '<option value="'+val.name+'">';
                });

                airlines.innerHTML = names;

                airlines.setAttribute('list', 'airlines')
            },
            error: function (data){
                //
            }
        });
    }
    
</script>
@endsection