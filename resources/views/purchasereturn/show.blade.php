@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3>Return No:INV-{{ $purchasereturn->return_no }}</h3>
                        </div>
                        <div class="col-sm-5">
                            <div class="float-end">
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('invoice.pdf',$purchasereturn->id) }}" class="dropdown-item"
                                            target="_blank">PDF</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" id="mail" data-id="' . $purchasereturn->id . '">Send
                                            Mail</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" id="canceldata"
                                            data-id="' . $purchasereturn->id . '">Cancel</a>

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
                                <p>{{ $purchasereturn->username->name }} created this Sale Return on {{ $purchasereturn->invoice_date }}
                                </p>
                            </div>
                            <hr>
                            <div class="col-sm-12">
                                <h5>Send</h5>
                                <button class="btn btn-sm custom-btn">Send Email</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4>Purchase Return</h4>
                                    <div class="row">
                                    @include('layouts.company')
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h5>Bill To</h5>
                                            <h6>{{ $purchasereturn->VendorName->name }}</h6>
                                            <address>
                                                <p>{{ $purchasereturn->VendorName->address }} <br>
                                                    {{ $purchasereturn->VendorName->phone }} <br>
                                                    {{ $purchasereturn->VendorName->email }}</p>
                                            </address>
                                        </div>
                                        <div class="col-sm-5">
                                            <p><b>Number:</b> <span>{{ $purchasereturn->return_no }}</span></p>
                                            <p><b>Date:</b> <span class="ml-4">{{ $purchasereturn->return_date }}</span>
                                            </p>

                                            <p><b>Return Type:</b> <span class="ml-4">
                                                    <?php
if ($purchasereturn->return_type == 1) {
    $type = "Adjustment";

} else {
    $type = "Cash Return";
}
?>
                                                    {{ $type }}

                                                </span>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row mb-2">
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
                                                    @foreach($purchasereturn->InvDetails as $item)
                                                    <tr>
                                                        <td style="margin-left: 10px;"> {{ $item->productName->name }}
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
                                                            {{ $purchasereturn->amount }}</td>
                                                    </tr>
                                                    @if($purchasereturn->discount>0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            Discount: </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $purchasereturn->discount }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">Total:
                                                        </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $purchasereturn->nettotal }}</td>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    @if($purchasereturn->return_type==1)
                                    <p>Invoice Information:</p>
                                    @else
                                    <p>Payment Information</p>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table-borderless custom-table" width="100%">
                                                <thead class="custom-header-table">
                                                    <tr>
                                                        <th
                                                            class="item text text-semibold text-alignment-left text-left text-white border-radius-first">
                                                            Number
                                                        </th>
                                                        <th>Date</th>
                                                        <th
                                                            class="item text text-semibold text-alignment-left text-left text-white border-radius-last">
                                                            Amount</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    @if($purchasereturn->return_type==1)
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('purchase.show',$purchasereturn->AdjustmentInvoice->id) }}">{{ $purchasereturn->AdjustmentInvoice->purchase_no }}</a><br>
                                                        </td>
                                                        <td>{{ $purchasereturn->AdjustmentInvoice->purchase_date }}</td>
                                                        <td>{{ $purchasereturn->AdjustmentInvoice->nettotal }}</td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('account.payment.show',$purchasereturn->CashReturn->id) }}">{{ $purchasereturn->CashReturn->transection_no }}</a><br>
                                                        </td>
                                                        <td>{{ $purchasereturn->AdjustmentInvoice->date }}</td>
                                                        <td>{{ $purchasereturn->AdjustmentInvoice->amount }}</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
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


        @endsection