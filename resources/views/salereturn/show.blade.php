@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3>Return No:INV-{{ $salereturn->return_no }}</h3>
                        </div>
                        <div class="col-sm-5">
                            <div class="float-end">
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('invoice.pdf',$salereturn->id) }}" class="dropdown-item"
                                            target="_blank">PDF</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" id="printslip" data-id="' . $invoice->id . '">Print</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" id="mail" data-id="' . $salereturn->id . '">Send
                                            Mail</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" id="canceldata"
                                            data-id="' . $salereturn->id . '">Cancel</a>

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
                                <p>{{ $salereturn->username->name }} created this Sale Return on {{ $salereturn->invoice_date }}
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
                                    <h4>Sale Return</h4>
                                    <div class="row">
                                    @include('layouts.company')
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h5>Bill To</h5>
                                            <h6>{{ $salereturn->CustomerName->name }}</h6>
                                            <address>
                                                <p>{{ $salereturn->CustomerName->address }} <br>
                                                    {{ $salereturn->CustomerName->phone }} <br>
                                                    {{ $salereturn->CustomerName->email }}</p>
                                            </address>
                                        </div>
                                        <div class="col-sm-5">
                                            <p><b>Number:</b> <span>{{ $salereturn->return_no }}</span></p>
                                            <p><b>Date:</b> <span class="ml-4">{{ $salereturn->return_date }}</span>
                                            </p>

                                            <p><b>Return Type:</b> <span class="ml-4">
                                                    <?php
if ($salereturn->return_type == 1) {
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
                                                    @foreach($salereturn->InvDetails as $item)
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
                                                            {{ $salereturn->amount }}</td>
                                                    </tr>
                                                    @if($salereturn->discount>0)
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            Discount: </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $salereturn->discount }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">Total:
                                                        </td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $salereturn->nettotal }}</td>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    @if($salereturn->return_type==1)
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
                                                    @if($salereturn->return_type==1)
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('invoice.show',$salereturn->AdjustmentInvoice->id) }}">{{ $salereturn->AdjustmentInvoice->invoice_no }}</a><br>
                                                        </td>
                                                        <td>{{ $salereturn->AdjustmentInvoice->invoice_date }}</td>
                                                        <td>{{ $salereturn->AdjustmentInvoice->nettotal }}</td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('account.payment.show',$salereturn->CashReturn->id) }}">{{ $salereturn->CashReturn->transection_no }}</a><br>
                                                        </td>
                                                        <td>{{ $salereturn->AdjustmentInvoice->date }}</td>
                                                        <td>{{ $salereturn->AdjustmentInvoice->amount }}</td>
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