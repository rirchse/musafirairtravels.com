@extends('dashboard')
@section('title', 'Add Client Payment')
@section('content')

{{-- {{dd($sale)}} --}}
<section class="content-header">
  <h1>Add {{$type? $type:''}} Payment</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{$type? $type:''}} Payments</a></li>
    <li class="active">Add {{$type? $type:''}} Payment</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-7"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Payment Information</h3>
        </div>
        {!! Form::open(['route' => 'payment.store', 'method' => 'POST', 'files' => true]) !!}
        <input type="hidden" name="user_type" value="{{$type}}">
        <div class="box-body">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Payment Method:</label>
              <select name="account_id" id="method" class="form-control" onchange="getBalance(this); balCalc()">
                <option value="">Select One</option>
                @foreach($accounts as $val)
                <option value="{{$val->id}}">{{$val->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="account_balance">Account Balance</label>
              <input type="number" name="account_balance" id="account_balance" class="form-control" step="0.01" onkeyup="balCalc()" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="type">Payment Type:</label>
              <select name="type" id="type" class="form-control" required onchange="balCalc()">
                <option value="Pay" {{$type == 'Vendor'? 'selected':''}}>Pay</option>
                <option value="Receive" {{$type == 'Client'? 'selected':''}}>Receive</option>
              </select>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label class="form-label">{{$type}} Information:</label>
              <select class="form-control" name="user_id" onchange="Balance(this);" required>
                <option value="">Select {{$type}}</option>
                @if($type == 'Client')
                @foreach($clients as $client)
                <option value="{{$client->id}}">{{$client->name}}</option>
                @endforeach
                @endif
  
                @if($type == 'Vendor')
                @foreach($vendors as $vendor)
                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {{ Form::label('date', 'Payment Date:', ['class' => 'control-label']) }}
              {!! Form::date('date', null, ['class'=>'form-control']) !!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="pre_balance">Previous Balance</label>
              <input type="number" name="pre_balance" id="pre_balance" class="form-control" step="0.01" onkeyup="balCalc()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="amount"> Paid Amount:</label>
              <input type="number" id="amount" name="amount" class="form-control" step="0.01" onkeyup="balCalc()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="balance">Current Balance</label>
              <input type="number" name="balance" id="balance" class="form-control" step="0.01">
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-12">
            <div class="form-group">
              {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
              {!! Form::textarea('details', null,['class'=>'form-control', 'rows' => 5]) !!}
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right" id="submit">Save</button>
          </div>
          <div class="clearfix"></div>
          {!! Form::close() !!}

        </div> <!-- /.box -->
      </div> <!--/.col (left) -->
    </div> <!-- /.row -->
  </section> <!-- /.content -->
  @endsection
  @section('scripts')
  <script>    
    var type = document.getElementById('type');
    var balance_type = document.getElementById('balance_type');
    var pre_balance = document.getElementById('pre_balance');
    var balance = document.getElementById('balance');
    var amount = document.getElementById('amount');
    var account_balance = document.getElementById('account_balance');
    var submit = document.getElementById('submit');
    var db_bal_type = '';

    function Balance(e)
    {
      var user_type = '{{$type}}';
      $.ajax({
        type: 'GET',
        url: '/payment_balance/'+user_type+'/'+e.options[e.selectedIndex].value,
        success: function (data)
        {
          db_bal_type = data.success.balance_type;
          pre_balance.value = data.success.amount;
          if(data.success.amount == null)
          {
            pre_balance.value = 0;
          }
        },
        error: function (data)
        {
          //
        }
      });
    }

    function getBalance(e)
    {
      $.ajax({
        type: 'GET',
        url: '/get_balance/'+e.options[e.selectedIndex].value,
        success: function (data)
        {
          account_balance.value = data.account;
        },
        error: function (data)
        {
          //
        }
      });
    }
    
    function balCalc()
    {
      var user_type = '{{$type}}';
      if(type.options[type.selectedIndex].value == 'Pay')
      {
        if(user_type == 'Client')
        {
          balance.value = Number(pre_balance.value) - Number(amount.value);
        }
        else if(user_type == 'Vendor')
        {
          balance.value = Number(pre_balance.value) + Number(amount.value);
        }

        if(Number(amount.value) > Number(account_balance.value))
        {
          alert('Insufficient account balance');
          submit.setAttribute('disabled', '');
        }
        else
        {
          submit.removeAttribute('disabled'); 
        }
      }
      else
      {
        if(user_type == 'Client')
        {
          balance.value = Number(pre_balance.value) + Number(amount.value);
        }
        else if(user_type == 'Vendor')
        {
          balance.value = Number(pre_balance.value) - Number(amount.value);
        }       
      }
      
    }

  </script>
  @endsection