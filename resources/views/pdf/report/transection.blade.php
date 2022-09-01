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
            <th class="text-center">Type</th>
            <th class="text-center">Description</th>
            <th width="20%" class="text-center">Billing Info</th>
            <th class="item text text-semibold text-alignment-left text-left text-white">Amount</th>
        </tr>
    </thead>
    <tbody class="customer-table-boody">

        @foreach($data['transection'] as $item)

        <?php
$type = $item->operation_type;

switch ($type) {
    case 1:
        $billingInfo = $item->InvoiceNo->CustomerName->name;
        break;
    case 2:
        $billingInfo = $item->purchaseNo->VendorName->name;
        break;
    case 3:
        $billingInfo = $item->ExpenseInfo->description;
        break;
    case 4:
        $billingInfo = $item->Transfeinfo->description;
        break;
    default:
        break;
}
?>
        <tr>
            <td style="margin-left: 10px;"> {{ $item->date }}</td>
            <td>{{ $item->transection_no }}</td>
            <td>{{ $item->AccountInfo->account_name }}</td>
            <td>{{  $item->payment_type == 1 ? 'income' : 'Expense'; }}</td>
            <td>{{ $item->description }}</td>
            <td>{{  $billingInfo  }}</td>
            <td align="right"> {{ $item->amount }}</td>
        </tr>
        @endforeach

    </tbody>
    <tfoot class="custom-table-footer">
        <tr style="margin-top: 20px;">
            <td colspan="5"></td>
            <td align="right"><b>Nettotal</b></td>
            <td align="right"><b>{{ $data['invoicePayment']->sum('amount') }}</b></td>
        </tr>
    </tfoot>

</table>
@endsection