@extends('dashboard')
@section('title', 'Fund Transfer')
@section('content')

{{-- {{dd($sale)}} --}}
<section class="content-header">
  <h1>Fund Transfer</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Accounts</a></li>
    <li class="active">Fund Transfer</li>
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
        {!! Form::open(['route' => 'fund.transfer.store', 'method' => 'POST', 'files' => true]) !!}
        <div class="box-body">
          <div class="col-md-12">
            <table class="table">
              <tr>
                <th>Account Name:</th>
                <td>{{$account->bank_name}} ({{$account->name}})</td>
              </tr>
              <tr>
                <th>Account Balance:</th>
                <td>{{$account->balance}} BDT</td>
              </tr>
            </table>
          </div>
          <div class="col-md-8">
            <input type="hidden" name="account_from" value="{{$account->id}}">
            <div class="form-group">
              <label class="form-label">Transfer To:</label>
              <select class="form-control" name="account_to" required>
                <option value="">Select One</option>
                @foreach($accounts as $val)
                @if($val->id != $account->id)
                <option value="{{$val->id}}">{{$val->bank_name}}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          {{-- <div class="col-md-4">
            <div class="form-group">
              <label for="balance">Current Balance</label>
              <input type="number" name="balance" id="balance" class="form-control" step="0.01" placeholder="0.00" readonly>
            </div>
          </div> --}}
          <div class="col-md-4">
            <div class="form-group">
              <label for="amount">Transfer Amount</label>
              <input type="number" name="amount" id="amount" class="form-control" step="0.01" placeholder="0.00">
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="amount">Date</label>
              <input type="date" name="date" id="date" class="form-control">
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