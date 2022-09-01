@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3>{{ $type }} : {{ $invoice->invoice_no }}</h3>
                        </div>
                        <div class="col-sm-5">
                            <div class="float-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('invoice.create') }}" class="btn btn-sm custom-btn">New
                                    {{ $type }} </a>
                                    <a href="{{ route('invoice.edit', $invoice->id ) }}" class="btn btn-sm">Edit</a>
                                    <div class="dropdown">
                                        <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">

                                            <a class="dropdown-item" id="datashow"
                                                data-id="' . $invoice->id . '">View</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('invoice.pdf',$invoice->id) }}" class="dropdown-item"
                                                target="_blank">PDF</a>
                                            <div class="dropdown-divider"></div>

                                            <a class="dropdown-item" id="mail" data-id="' . $invoice->id . '">Send
                                                Mail</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('salereturn.create',$invoice->id ) }}"
                                                class="dropdown-item" data-id="' . $invoice->id . '">Return</a>
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
                                <p>{{ $invoice->username->name }} created this invoice on {{ $invoice->invoice_date }}</p>
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
                                    <h4>{{ $type }} </h4>
                                    <div class="row">
                                        @include('layouts.company')
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h5>Bill To</h5>
                                            <h6>{{ $invoice->CustomerName->name }}</h6>
                                            <address>
                                                <p>{{ $invoice->CustomerName->address }} <br>
                                                    {{ $invoice->CustomerName->phone }} <br>
                                                    {{ $invoice->CustomerName->email }}</p>
                                            </address>
                                        </div>
                                        <div class="col-sm-5">
                                          <p><b>Type:</b> <span>{{ $invoice->type==1? 'Order':'Invoice' }}</span></p>
                                            <p><b>{{ $type }}  Number:</b> <span>{{ $invoice->invoice_no }}</span></p>
                                            <p><b>{{ $type }}  Date:</b> <span
                                                    class="ml-4">{{ $invoice->invoice_date }}</span></p>
                                            <p><b>Order Number:</b> <span class="ml-4">{{ $invoice->order_no }}</span></p>
                                            @if($invoice->type==1)
                                            <p><b>Delivery Date:</b> <span>{{ $invoice->deliverydate }}</span></p>
                                            @endif
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
                                                    @foreach($invoice->InvDetails as $item)
                                                    <tr>
                                                        <td style="margin-left: 10px;">  {{ $item->productName->CategoryName->name }} {{ $item->productName->name }}
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
                                                            {{ $invoice->amount }}</td>
                                                    </tr>
                                                    @if($invoice->discount>0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            Discount: </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $invoice->discount }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">Total:
                                                        </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $invoice->nettotal }}</td>
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

    $("#payment_type").val("1");
    $("#operation_type").val("1");
    $("#invoice_id").val("{{ $invoice->id }}");
    $("#due_amount").val("{{ $invoice->due }}");
    $("#due_amount").val("{{ $invoice->due }}");
});
</script>
@endsection