<div class="modal fade" id="paymentmodal" tabindex="-1" aria-labelledby="citymodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Payment</h5>
                <button type="button" class="btn-close model-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{ route('account.payment') }}" method="post">
                        @csrf
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input type="hidden" name="payment_type" id="payment_type" value="">
                        <input type="hidden" name="operation_type" id="operation_type" value="">
                        <div class="form-group mb-1">
                            <label for="date">Date</label>
                            <input type="text" name="date" id="dateinput" class="form-control datepicker"
                                placeholder="date">
                        </div>
                        <div class="form-group mb-1">
                            <label for="Transection Number">Transection Number</label>
                            <input type="text" name="transection_no" class="form-control"
                                placeholder="Transection Number" value="{{ $transectioNo }}">
                        </div>
                        <div class="form-group mb-1">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" id="due_amount" placeholder="Amount"
                                value="">
                        </div>
                        <div class="form-group mb-1">
                            <label for="paymentmethod">Payment Methos</label>
                            <select name="payment_method" id="" class="form-control">
                                <option value="1">Cash</option>
                                <option value="2">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <label for="account">Account</label>
                            <div class="mb-3 select2-sm">
                                <select name="account_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($accountinfos as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-1">
                            <label for="Payment Description">Payment Description</label>
                            <textarea name="" id="" cols="30" rows="5" name="payment_descripiton"
                                class="form-control"></textarea>
                        </div>
                        <div class="float-end">
                            <div class="btn-group mt-2" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary model-close"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">

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
    $("#dateinput").val(output);
});
</script>
