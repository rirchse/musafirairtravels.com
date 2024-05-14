@extends('dashboard')
@section('title', 'Edit Invoice')
@section('content')
<section class="content-header">
  <h1>Edit Invoice {{$type}}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Invoices</a></li>
    <li class="active">Invoice</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-8"> <!-- general form elements -->
      <div class="box box-primary">
        {!! Form::model($sale, ['route' => ['sale.update', $sale->id], 'method' => 'PUT', 'files' => true]) !!}
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Customer/Client Information</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                {{-- <div class="form-group">
                    <label class="control-label" for="search">Search Client</label>
                    <input class="form-control" id="search" type="text" placeholder="Search By Name, Email, Mobile, Ticket Number" onkeyup="searchClient(this)">
                </div> --}}
                <div id="clientInfo">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Ticket No.</th>
                            <th>Passport No.</th>
                        </tr>
                        <tr>
                            <td>{{$client->name}}</td>
                            <td>{{$client->contact}}</td>
                            <td>{{$client->email}}</td>
                            <td>{{$client->ticket_no}}</td>
                            <td>{{$client->passport_no}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
          <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Invoice Information of [{{$type}}]</h3>
          </div>
          <div class="box-body">
            <input type="hidden" id="customer_id" name="customer_id" value="{{$sale->customer_id}}">
            <input type="hidden" id="type" name="type" value="{{$type}}">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('ticket_no', 'Ticket Number (*):', ['class' => 'control-label']) }}
                    {{ Form::text('ticket_no',  $sale->ticket_no, ['class' => 'form-control', 'placeholder' => 'Ticket Number', 'required' => '', 'step' => '0.01', 'onkeyup' => 'checkTicketNo(this)'])}}
                    <div style="position: absolute; color:red"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="air_ticket_class">Air Ticket Class</label>
                    <select class="form-control" id="air_ticket_class" name="air_ticket_class">
                        <option value="">Select Class</option>
                        <option value="Economy" {{$sale->air_ticket_class == 'Economy'? 'selected':''}}>Economy Class</option>
                        <option value="Business" {{$sale->air_ticket_class == 'Business'? 'selected':''}}>Business Class</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('vendor_id', 'Vendor (*):', ['class' => 'control-label']) }}
                    <select name="vendor_id" class="form-control">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                        <option value="{{$vendor->id}}" {{$sale->vendor_id == $vendor->id? 'selected': ''}}>{{$vendor->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="airline">Airline</label>
                    <input class="form-control" id="airline" type="text" name="airline" placeholder="Airline" value="{{$sale->airline}}">
                </div>
            </div>
            
            @if($type == 'Air-Ticket')
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('gross_fare', 'Gross Fare(Sale) (*):', ['class' => 'control-label']) }}
                    {{ Form::number('gross_fare', $sale->gross_fare, ['class' => 'form-control', 'placeholder' => 'Gross Fare(Sale)', 'step' => '0.01'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('base_fare', 'Base Fare(Buy) (*):', ['class' => 'control-label']) }}
                    {{ Form::number('base_fare', $sale->base_fare, ['class' => 'form-control', 'placeholder' => 'Base Fare(Buy)', 'step' => '0.01'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="commission">Commission %</label>
                    <input class="form-control" id="commission" type="number" name="commission" placeholder="Commission %" value="{{$sale->commission}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="commission_amount">Commission Amount</label>
                    <input class="form-control" id="commission_amount" type="number" name="commission_amount" placeholder="Commission amount" value="{{$sale->commission_amount}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="net_commission">Net Commission</label>
                    <input class="form-control" id="net_commission" type="number" name="net_commission" placeholder="Net Commission" value="{{$sale->net_commission}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="ait">AIT</label>
                    <input class="form-control" id="ait" type="number" name="ait" placeholder="AIT" value="{{$sale->ait}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="discount">Discount Amount</label>
                    <input class="form-control" id="discount" type="number" name="discount" placeholder="Discount in Amount" value="{{$sale->discount}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="other_bonus">Other Bonus</label>
                    <input class="form-control" id="other_bonus" type="number" name="other_bonus" placeholder="Other Bonus" value="{{$sale->other_bonus}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="extra_fee">Extra Fee</label>
                    <input class="form-control" id="extra_fee" type="number" name="extra_fee" placeholder="Extra Fee" value="{{$sale->extra_fee}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="other_expense">Other Expense</label>
                    <input class="form-control" id="other_expense" type="number" name="other_expense" placeholder="Other Expense" value="{{$sale->other_expense}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="vat">VAT</label>
                    <input class="form-control" id="vat" type="number" name="vat" placeholder="VAT" value="{{$sale->vat}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="tax">Tax</label>
                    <input class="form-control" id="tax" type="number" name="tax" placeholder="Tax" value="{{$sale->tax}}" step="0.01">
                </div>
            </div>
            @endif

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="route">Route/Sector</label>
                    <input class="form-control" id="route" type="text" name="route" placeholder="Route/Sector" value="{{$sale->route}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="pnr">PNR</label>
                    <input class="form-control" id="pnr" type="text" name="pnr" placeholder="PNR" value="{{$sale->pnr}}">
                </div>
            </div>

            @if($type == 'Air-Ticket')
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="gds">GDS</label>
                    <input class="form-control" id="gds" type="text" name="gds" placeholder="GDS" value="{{$sale->gds}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="segment">Segment</label>
                    <input class="form-control" id="segment" type="text" name="segment" placeholder="Segment" value="{{$sale->segment}}">
                </div>
            </div>
            @endif
            
            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="client_price">Client Price</label>
                    <input class="form-control" id="client_price" type="number" name="client_price" placeholder="Client Price" value="{{$sale->client_price}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="purchase">Purchase</label>
                    <input class="form-control" id="purchase" type="number" name="purchase" placeholder="Purchase" value="{{$sale->purchase}}" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="profit">Profit</label>
                    <input class="form-control" id="profit" type="number" name="profit" placeholder="Profit" value="{{$sale->profit}}" step="0.01">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="issue_date">Issue Date</label>
                    <input class="form-control" id="issue_date" type="date" name="issue_date" placeholder="Issue Date" value="{{$sale->issue_date}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="journey_date">Journey Date</label>
                    <input class="form-control" id="journey_date" type="date" name="journey_date" placeholder="Journey Date" value="{{$sale->journey_date}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="return_date">Return Date</label>
                    <input class="form-control" id="return_date" type="date" name="return_date" placeholder="Return Date" value="{{$sale->return_date}}">
                </div>
            </div><div class="clearfix"></div>
            <div class="box-header with-border">
                <h3 style="color: #800" class="box-title">Pax & Passport Details:</h3>
            </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_name">Pax Name</label>
                      <input class="form-control" id="pax_name" type="text" name="pax_name" placeholder="Type Passenger Name" value="{{$sale->pax_name}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_type">Pax Type</label>
                      <select class="form-control" id="pax_type" name="pax_type">
                        <option value="">Select PAX Type</option>
                        <option value="Adult" {{$sale->pax_type == 'Adult'?'selected':''}}>Adult</option>
                        <option value="Child" {{$sale->pax_type == 'Child'?'selected':''}}>Child</option>
                        <option value="Infant" {{$sale->pax_type == 'Infant'?'selected':''}}>Infant</option>
                        <option value="Others" {{$sale->pax_type == 'Others'?'selected':''}}>Others</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_mobile">Mobile Number</label>
                      <input class="form-control" id="pax_mobile" type="phone" name="pax_mobile" placeholder="Mobile Number" value="{{$sale->pax_mobile}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_email">Email</label>
                      <input class="form-control" id="pax_email" type="email" name="pax_email" placeholder="Email Address" value="{{$sale->pax_email}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="passport">Passport No.</label>
                      <input class="form-control" id="passport" type="text" name="passport_no" placeholder="Passport No." value="{{$sale->passport_no}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="nid">NID No.</label>
                      <input class="form-control" id="nid" type="text" name="nid" placeholder="NID No." value="{{$sale->nid}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="birth_date">Date of Birth</label>
                      <input class="form-control" id="birth_date" type="date" name="birth_date" placeholder="Date of Birth" value="{{$sale->birth_date}}">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label" for="pax_issue_date">Passport Issue Date</label>
                      <input class="form-control" id="pax_issue_date" type="date" name="pax_issue_date" placeholder="Passport Issue Date" value="{{$sale->pax_issue_date}}">
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="pax_expire_date">Passport Expire Date</label>
                  <input class="form-control" id="pax_expire_date" type="date" name="pax_expire_date" placeholder="Passport Expire Date" value="{{$sale->pax_expire_date}}">
                  </div>
              </div>
        
            <div class="clearfix"></div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-undo"> </i> Update</button>
            </div>
            </div> <!-- /.box body -->
          </div> <!-- /.box -->
          {!! Form::close() !!}
      </div> <!--/.col-12 -->
   </div> <!-- /.row -->
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
    /** ----------------------------- Search Customer by ajax --------------- **/
    // var mobile = document.getElementById('mobile');
    // var search_customer = document.getElementById('search_customer');
    // mobile.addEventListener('keyup', getCustomer);

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
                            clientInfo.innerHTML = 'Customer could not found  <a href="/customer/create">Add New Customer</a>';
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

    //** ---------------------- customer serch end ----------------------- **//
    //** ------------- search product by ajax and make datalist ---------- **//
    function getItemName(elm){
        $.ajax({
            type: 'GET',
            url: '/search_item_names',
            success: function (data){
                var names = '';
                // var itemnames = document.getElementById('itemnames');

                var obj = JSON.parse(JSON.stringify(data));
                $.each(obj['success'], function (key, val){
                    names += '<option value="'+val.name+'">';
                });

                document.getElementById('itemnames').innerHTML = names;

                elm.setAttribute('list', 'itemnames')
            },
            error: function (data){
                //
            }
        });
    }
    
</script>
@endsection