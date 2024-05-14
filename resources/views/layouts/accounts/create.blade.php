@extends('dashboard')
@section('title', 'Add Account')
@section('content')

{{-- {{dd($sale)}} --}}
<section class="content-header">
  <h1>Add Account</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Accounts</a></li>
    <li class="active">Add Account</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-7"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Account Information</h3>
        </div>
        {!! Form::open(['route' => 'account.store', 'method' => 'POST', 'files' => true]) !!}
        <div class="box-body">
          <div class="col-md-4">
            <div class="form-group">
              <label for="name">Account Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="TBL, DBBL, Cash, bKash" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Account Type:</label>
              <select class="form-control" name="type" required>
                <option value="">Select One</option>
                <option value="Cash">Cash</option>
                <option value="Bank">Bank</option>
                <option value="Mobile Bank">Mobile Bank</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="balance">Current Balance</label>
              <input type="number" name="balance" id="balance" class="form-control" step="0.01" placeholder="0.00">
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="bank_name">Bank Name</label>
              <input type="text" name="bank_name" id="bank_name" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="account_no">Account No.:</label>
              <input type="text" id="account_no" name="account_no" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="branch">Branch:</label>
              <input type="text" id="branch" name="branch" class="form-control">
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="card_no">Card No.:</label>
              <input type="text" id="card_no" name="card_no" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="routing_no">Routing No.:</label>
              <input type="text" id="routing_no" name="routing_no" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
              {!! Form::textarea('details', null,['class'=>'form-control', 'rows' => 5]) !!}
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right">Save</button>
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
    var balance_type = document.getElementById('balance_type');
    var pre_balance = document.getElementById('pre_balance');
    var balance = document.getElementById('balance');
    var amount = document.getElementById('amount');
    var db_bal_type = '';

    function Balance(e)
    {
      var type = '0';
        $.ajax({
            type: 'GET',
            url: '/payment_balance/'+type+'/'+e.options[e.selectedIndex].value,
            success: function (data){
              db_bal_type = data.success.balance_type;
              pre_balance.value = data.success.amount;
              // console.log(data.success.amount);
              if(data.success.amount == null)
              {
                pre_balance.value = 0;
              }
              setBalnceType();
            },
            error: function (data){
                //
            }
        });
    }

    // amount.addEventListener('keyup', balCalc);
    function balCalc()
    {
      balance.value = Number(pre_balance.value) + Number(amount.value);
    }

    function setBalnceType()
    {
      for(var x = 0; balance_type.options.length > x; x++)
      {
        if(balance_type.options[x].value == db_bal_type)
        {
          balance_type.options[x].setAttribute('selected', '');
          break;
        }
      }
    }
  </script>
  @endsection