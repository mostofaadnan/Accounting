@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3>Purchase No: INV-{{ $purchase->purchase_no }}</h3>
                        </div>
                        <div class="col-sm-5">
                            <div class="float-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('purchase.create') }}" class="btn btn-sm custom-btn">New
                                        Purchase</a>
                                    <a href="{{ route('purchase.edit', $purchase->id ) }}" class="btn btn-sm">Edit</a>
                                    <div class="dropdown">
                                        <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" id="datashow"
                                                data-id="' . $purchase->id . '">View</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('purchase.pdf',$purchase->id) }}" class="dropdown-item"
                                                target="_blank">PDF</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('purchasereturn.create',$purchase->id) }}" class="dropdown-item">Return</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="col-sm-12">
                                <h5>Create</h5>
                                <p>{{ $purchase->username->name }} created this purchase on {{ $purchase->purchase_date }}</p>
                            </div>
                            <hr>
                            <div class="col-sm-12">
                                <h5>Send</h5>
                                <button class="btn btn-sm custom-btn">Send Email</button>
                            </div>
                            <hr>
                            <div class="col-sm-12">
                                @include('layouts.ErrorMessage')
                                @if($due>0)
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#paymentmodal">Get
                                    Payment</button>
                                <p>Amount due {{ $due }}/-</p>
                                @endif

                                @if($paymentAmount>0)
                                <hr>
                                @foreach($paymentinfos as $paymentinfo)
                                <?php
if ($paymentinfo->payment_method == 1) {
    $paymentMethod = "Cash";
} else {
    $paymentMethod = "Bank Transfer";
}
?>
                                <h6>Payemnt Recieved</h6>
                                <p>{{ $paymentinfo->date }}- A payment for {{ $paymentinfo->amount }} was made using
                                    {{ $paymentMethod }}.</p>
                                <div class="btn-group custom-btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm custom-btn-group">Send Reciepet</button>
                                    <button type="submit" class="btn btn-sm">Edit Payment</button>
                                    <button type="submit" class="btn btn-sm">Delete Payment</button>
                                    <button type="submit" class="btn btn-sm">Pdf</button>
                                </div>
                                <hr>
                                @endforeach
                                @endif
                            </div>
                            <hr>
                        </div>
                        <div class="col-sm-7">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4>purchase</h4>
                                    <div class="row">
                                    @include('layouts.company')
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h5>Bill To</h5>
                                            <h6>{{ $purchase->VendorName->name }}</h6>
                                            <address>
                                                <p>{{ $purchase->VendorName->address }} <br>
                                                    {{ $purchase->VendorName->phone }} <br>
                                                    {{ $purchase->VendorName->email }}</p>
                                            </address>
                                        </div>
                                        <div class="col-sm-5">
                                            <p><b>Invoie Number:</b> <span>{{ $purchase->purchase_no }}</span></p>
                                            <p><b>Invoie Date:</b> <span
                                                    class="ml-4">{{ $purchase->purchase_date }}</span></p>
                                            <p><b>Order Number:</b> <span class="ml-4">{{ $purchase->order_no }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table-borderless custom-table">
                                                <thead class="custom-header-table">
                                                    <tr>
                                                        <th width="100%"
                                                            class="item text text-semibold text-alignment-left text-left text-white border-radius-first">
                                                            Item</th>
                                                        <th>Quanitity</th>
                                                        <th>Price</th>
                                                        <th
                                                            class="item text text-semibold text-alignment-left text-left text-white border-radius-last">
                                                            Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="customer-table-boody">
                                                    @foreach($purchase->InvDetails as $item)
                                                    <tr>
                                                        <td style="margin-left: 10px;"> {{ $item->productName->CategoryName->name }} {{ $item->productName->name }}
                                                            <p style="font-size: 12px;">
                                                                {{ $item->productName->description }}</p>
                                                        </td>
                                                        <td align="right"> {{ $item->qty }}</td>
                                                        <td align="right"> {{ $item->sale_price }}</td>
                                                        <td align="right"> {{ $item->amount }}</td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot class="custom-table-footer">
                                                    <tr style="margin-top: 20px;!">
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            Subtotal:</td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $purchase->amount }}</td>
                                                    </tr>
                                                    @if($purchase->discount>0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            Discount: </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $purchase->discount }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">Total:
                                                        </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $purchase->nettotal }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            Payment:
                                                        </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $paymentAmount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">Due:
                                                        </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $due }}</td>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <th></th>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modeldata.payment')
<script>
$(document).ready(function() {

    $("#payment_type").val("2");
    $("#operation_type").val("2");
    $("#invoice_id").val("{{ $purchase->id }}")
    $("#due_amount").val("{{ $purchase->due }}");
});
</script>
@endsection