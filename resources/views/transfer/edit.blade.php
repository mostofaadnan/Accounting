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
                            <form action="{{ route('transfer.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="transfer_id" value="{{ $transfer->id }}">
                                <h6>Payment Description</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="email">From Account</label>
                                            <div class="mb-3 select2-sm">
                                                <select name="from_account_id" class="form-control">
                                                    @foreach($accountinfosfroms as $account)
                                                    <option value="{{ $account->id }}"
                                                        {{ $transfer->from_account_id==$account->id ? 'selected' :'' }}>
                                                        {{ $account->account_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="email">To Account</label>
                                            <div class="mb-3 select2-sm">
                                                <select name="to_acccount_id" class="form-control">
                                                    @foreach($accountinfostos as $account)
                                                    <option value="{{ $account->id }}"
                                                        {{ $transfer->to_acccount_id==$account->id ? 'selected' :'' }}>
                                                        {{ $account->account_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="name">Date<span style="color:red;">*</span></label>
                                            <input type="text" name="date" placeholder="Date"
                                                value="{{ $transfer->PaymentInfo->date }}"
                                                class="form-control datepicker" require>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="description">Amount</label>
                                            <input type="text" name="amount" placeholder="Amount"
                                                value="{{ $transfer->PaymentInfo->amount }}" class="form-control"
                                                require>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="name">Payment Method <span style="color:red;">*</span></label>
                                            <select name="payment_method" class="form-control">
                                                <option value="1"
                                                    {{  $transfer->PaymentInfo->payment_method==1 ? 'selected':'' }}>
                                                    Cash</option>
                                                <option value="2"
                                                    {{  $transfer->PaymentInfo->payment_method==2 ? 'selected':'' }}>
                                                    Bank Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group mb-2">
                                                <label for="description">Payment Description</label>
                                                <textarea name="payment_descripiton" id="" cols="30" rows="2"
                                                    class="form-control">{{ $transfer->PaymentInfo->payment_descripiton }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h6>Transfer</h6>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <label for="description">Transfer Description</label>
                                            <textarea name="description" id="" cols="30" rows="2"
                                                class="form-control">{{  $transfer->description }}</textarea>
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
