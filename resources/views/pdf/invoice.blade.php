@extends('pdf.app')
@section('content')
<table class="table">
    <tr>
        <td>
            <h5>Bill To</h5>
            <h6>{{ $invoice->CustomerName->name }}</h6>
            <address>
                <p>{{ $invoice->CustomerName->address }} <br>
                    {{ $invoice->CustomerName->phone }} <br>
                    {{ $invoice->CustomerName->email }}</p>
            </address>
        </td>
        <td>
            <p><b>Invoie Number:</b> <span>{{ $invoice->invoice_no }}</span></p>
            <p><b>Invoie Date:</b> <span class="ml-4">{{ $invoice->invoice_date }}</span></p>
            <p><b>Order Number:</b> <span class="ml-4">{{ $invoice->order_no }}</span>
            </p>
        </td>
    </tr>
</table>

<table class="table-borderless custom-table" width="100%">
    <thead class="custom-header-table">
        <tr>
            <th width="100%"
                class="item text text-semibold text-alignment-left text-left text-white border-radius-first">
                Item</th>
            <th>Quanitity</th>
            <th>Price</th>
            <th class="item text text-semibold text-alignment-left text-left text-white border-radius-last">
                Amount</th>
        </tr>
    </thead>
    <tbody class="customer-table-boody">
        @foreach($invoice->InvDetails as $item)
        <tr>
            <td style="margin-left: 10px;"> {{ $item->productName->name }} <p style="font-size: 12px;">
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
            <td align="right" style="border-bottom: 1px #003 solid;">Subtotal:</td>
            <td align="right" style="border-bottom: 1px #003 solid;">{{ $invoice->amount }}</td>
        </tr>
        @if($invoice->discount>0)
        <tr>
            <td colspan="2"></td>
            <td align="right" style="border-bottom: 1px #003 solid;">Discount: </td>
            <td align="right" style="border-bottom: 1px #003 solid;">{{ $invoice->discount }}</td>
        </tr>
        @endif
        <tr>
            <td colspan="2"></td>
            <td align="right" style="border-bottom: 1px #003 solid;">Total:</td>
            <td align="right" style="border-bottom: 1px #003 solid;">{{ $invoice->nettotal }}</td>
        </tr>
    </tfoot>

</table>
@endsection