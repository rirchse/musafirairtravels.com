@extends('dashboard')
@section('title', 'Invoice')
@section('content')
<style>
    .req{color:#f00}
</style>
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
    <div class="col-md-8"> <!-- general form elements -->
      <div class="box box-primary">
        {!! Form::open(['route' => 'invoice.type.store', 'method' => 'POST', 'files' => true]) !!}
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

            <input type="hidden" id="customer_id" name="client_id">
            <input type="hidden" id="type" name="type" value="{{$type}}">

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="product">Product <span class="req">*</span></label>
                    <select class="form-control" id="product" name="product" required>
                        <option value="">Select Product</option>
                        <option value="VISA" {{$type == 'VISA'?'selected':''}}>VISA</option>
                        <option value="Hotel" {{$type == 'Hotel'?'selected':''}}>Hotel</option>
                        <option value="Other" {{$type == 'Other'?'selected':''}}>Other</option>
                    </select>
                </div>
            </div>
            @if($type != 'VISA')
            <div class="col-md-4">
                <div class="form-group">
                    <label for="pax_name">Pax Name</label>
                    <input type="text" name="pax_name" class="form-control">
                </div>
            </div>
            @endif
            @if($type == 'Hotel')
            <div class="col-md-4">
                <div class="form-group">
                    <label for="hotel_name">Hotel Name</label>
                    <input type="text" name="hotel_name" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="room_no">Room Number</label>
                    <input type="text" name="room_no" class="form-control">
                </div>
            </div>
            @endif
            @if($type == 'VISA')
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="country">Country <span class="req">*</span></label>
                    <select class="form-control" id="country" name="country" required></select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="visa_type">VISA Type <span class="req">*</span></label>
                    <select class="form-control" id="visa_type" name="visa_type" required>
                        <option value="">Select Type</option>
                        <option value="Employment visa">Employment visa</option>
                        <option value="Student visa">Student visa</option>
                        <option value="Diplomatic and official visas">Diplomatic and official visas</option>
                        <option value="J visas">J visas</option>
                        <option value="Tourist visa">Tourist visa</option>
                        <option value="NGO visa">NGO visa</option>
                        <option value="Investor visa">Investor visa</option>
                        <option value="Refugee and humanitarian visas">Refugee and humanitarian visas</option>
                        <option value="Business">Business</option>
                        <option value="Transit visa">Transit visa</option>
                        <option value="Intern">Intern</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="token">Token</label>
                    <input type="text" name="token" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="delivery">Delivery Date</label>
                    <input type="date" name="delivery" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="visa_no">VISA No.</label>
                    <input class="form-control" id="visa_no" type="text" name="visa_no">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="mofa_no">Mofa No.</label>
                    <input class="form-control" id="mofa_no" type="text" name="mofa_no">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="okala_no">Okala No.</label>
                    <input class="form-control" id="okala_no" type="text" name="okala_no">
                </div>
            </div>
            @endif
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="quantity">Quantity <span class="req">*</span></label>
                    <input class="form-control" id="quantity" type="number" name="quantity" set="0.01" required onkeyup="Calc()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="unit_price">Unit Price <span class="req">*</span></label>
                    <input class="form-control" id="unit_price" type="number" name="unit_price" step="0.01" required onkeyup="Calc()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="total_sale">Total Sale</label>
                    <input class="form-control" id="total_sale" type="number" name="total_sale" step="0.01">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="cost_price">Purchase Price</label>
                    <input class="form-control" id="cost_price" type="number" name="cost_price" step="0.01" onkeyup="Calc()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="profit">Profit</label>
                    <input class="form-control" id="profit" type="number" name="profit" step="0.01" onkeyup="Calc()">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="vendor_id">Vendor</label>
                    <select name="vendor_id" class="form-control">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="details">Details</label>
                    <textarea class="form-control" id="details" name="details" rows="5"></textarea>
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
    var totalSale = totalCost = netTotal = 0;

    var quantity   = document.getElementById('quantity');
    var unit_price  = document.getElementById('unit_price');
    var total_sale = document.getElementById('total_sale');
    var cost_price = document.getElementById('cost_price');
    var profit = document.getElementById('profit');

    /* number fix */
    function fix(n)
    {
        var number = Number(n);
        return number;
    }

    function Calc()
    {
        total_sale.value = fix(quantity.value) * fix(unit_price.value);
        profit.value = fix(total_sale.value) - fix(cost_price.value);
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
                        present_balance.value = client.amount;
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
<script src="/js/countries.js"></script>
<script>
    function getCountries(e)
    {
        var countries = '<option value="">Select Country</option>';
        for(var x = 0; x < countryList.length; x++)
        {
            countries += '<option value="'+countryList[x]+'">'+countryList[x]+'</option>';
        }
        e.innerHTML = countries;
    }
    getCountries(document.getElementById('country'));
</script>
@endsection