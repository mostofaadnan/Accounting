@extends('pdf.app')
@section('content')

<table class="table">
    <tr>
        <td>
            <p><b>From:</b> <span>{{ $data['fromdate'] }}</span></p>
            <p><b>To:</b> <span class="ml-4">{{ $data['todate'] }}</span></p>
            </p>
        </td>
    </tr>
</table>

<table class="table-bordered custom-table" width="100%">
    <thead class="custom-header-table">
        <tr>
            <th class="item text text-semibold text-alignment-left text-left text-white">Payment Date</th>
            <th class="text-center">Transection No</th>
            <th class="text-center">Account</th>
            <th class="text-center">Invoice Information</th>
            <th width="20%" class="text-center">Billing Info</th>
            <th class="item text text-semibold text-alignment-left text-left text-white">Amount</th>
        </tr>
    </thead>
    <tbody class="customer-table-boody">

        @foreach($data['invoicePayment'] as $item)
        <tr>
            <td style="margin-left: 10px;"> {{ $item->date }}</td>
            <td> {{ $item->transection_no }}</td>
            <td> {{ $item->AccountInfo->account_name }}</td>
            <td>
            Date:  {{ $item->InvoiceNo->invoice_date  }} <br>
            No:  {{ $item->InvoiceNo->invoice_no  }} <br>
            Amount:{{ $item->InvoiceNo->nettotal  }}
           </td>

            <td>{{ $item->InvoiceNo->CustomerName->name  }}</td>
            <td align="right"> {{ $item->amount }}</td>
        </tr>
        @endforeach

    </tbody>
    <tfoot class="custom-table-footer">
        <tr style="margin-top: 20px;">
            <td colspan="4"></td>
            <td align="right"><b>Nettotal</b></td>
            <td align="right"><b>{{ $data['invoicePayment']->sum('amount') }}</b></td>
        </tr>
    </tfoot>

</table>
@endsection
