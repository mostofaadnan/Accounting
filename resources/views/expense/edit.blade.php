@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 text-uppercase">New Expense</h4>
                        </div>
                        <div class="card-body">
                            @include('layouts.ErrorMessage')
                            <form action="{{ route('expense.update') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="{{ $expense->PaymentInfo->id }}" name="payment_id">
                                <input type="hidden" value="{{ $expense->id }}" name="expense_id">
                                @csrf
                                <h6>Payment Description</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="name">Date<span style="color:red;">*</span></label>
                                            <input type="text" name="date" placeholder="Date" value="{{ $expense->date }}"
                                                class="form-control datepicker" require>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="email">Transection Number</label>
                                            <input type="text" name="transection_no" placeholder="Transection Number"
                                                value="{{$expense->PaymentInfo->transection_no  }}" class="form-control" require>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="name">Payment Method <span style="color:red;">*</span></label>
                                            <select name="payment_method" class="form-control">
                                                <option value="1" {{$expense->PaymentInfo->payment_method==1?'Selected':''  }}>Cash</option>
                                                <option value="2" {{$expense->PaymentInfo->payment_method==2?'Selected':''  }}>Bank Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="email">Account</label>
                                            <div class="mb-3 select2-sm">
                                                <select name="account_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($accountinfos as $account)
                                                    <option value="{{ $account->id }}" {{$expense->PaymentInfo->account_id== $account->id ?'Selected':''  }}>{{ $account->account_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="description">Payment Descrition</label>
                                            <textarea name="payment_descripiton" id="" cols="30" rows="2"
                                                class="form-control">{{ $expense->PaymentInfo->payment_descripiton }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h6>Expense Description</h6>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="" cols="30" rows="2"
                                                class="form-control">{{ $expense->description  }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="description">Amount</label>
                                            <input type="text" name="amount" placeholder="Amount"
                                                value="{{ $expense->PaymentInfo->amount }}" class="form-control" require>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h6>Bill To</h6>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="bill_to_name">Name</label>
                                            <input type="text" name="bill_to_name" placeholder="Name"
                                                value="{{ $expense->name }}" class="form-control" require>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="address">Address</label>
                                            <textarea name="bill_to_address" id="" cols="30" rows="2"
                                                class="form-control">{{ $expense->address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="email">Phone</label>
                                            <input type="text" name="bill_to_phone" placeholder="Email"
                                                value="{{ $expense->phone }}" class="form-control" require>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="email">Email</label>
                                            <input type="email" name="bill_to_email" placeholder="Email"
                                                value="{{ $expense->email }}" class="form-control" require>
                                        </div>
                                    </div>
                                </div>
                                <div class="float-end mt-20">
                                    <button class="btn btn-sm btn-default">Cancel</button>
                                    <button type="submit" class="btn  btn  btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.datepicker').pickadate({
    selectMonths: true,
    selectYears: true
});
/* $('#dateinput').bootstrapMaterialDatePicker({
    time: false
}); */
$(function() {
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;
    $(".datepicker").val(output);
});
</script>
@endsection