@extends('pdf.app')
@section('content')
<style>
.amount-section {
    background-color: rgb(85, 88, 139);
    width: 400px;
    padding: 10px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    color: #fff;
    margin-top: 30px;
    float: right;

}

.table-bottom-border {
    border-bottom: 2px #ccc dotted;
}
</style>
<p>Reciept</p>

<table width="100%">
    <tr>
        <td width="30%">Number:</td>
        <td class="table-bottom-border">{{ $account->transection_no }}</td>
    </tr>
    <tr>
        <td width="30%">Date:</td>
        <td class="table-bottom-border">{{ $account->date }}</td>
    </tr>
    <tr>
        <td width="30%">Account:</td>
        <td class="table-bottom-border">{{ $account->AccountInfo->account_name }}</td>
    </tr>
    <tr>
        <td width="30%">Category:</td>
        <td class="table-bottom-border">{{ $account->description }}</td>
    </tr>
    <tr>
        <td width="30%">Payment Method:</td>
        <td class="table-bottom-border">
            <?php
if ($account->payment_method == 1) {
    $paymentMethod = "Cash";
} else {
    $paymentMethod = "Bank Transfer";
}
?>
            {{ $paymentMethod }}
        </td>
    </tr>
    <tr>
        <td>Description:</td>
        <td class="table-bottom-border">
            {{ $account->payment_descripiton   }}
        </td>
    </tr>
</table>
<hr>
<p><b>Paid By</b></p>
<p><b>Bill To</b></p>

<table width="100%">
    @if($account->operation_type==4)
    <tr>
        <td width="30%">Name</td>
        <td class="table-bottom-border">

        </td>
    </tr>
    <tr>
        <td width="30%">Address</td>
        <td class="table-bottom-border">
            N/A
        </td>
    </tr>
    <tr>
        <td width="30%">Phone</td>
        <td class="table-bottom-border">

        </td>
    </tr>
    <tr>
        <td width="30%">Email</td>
        <td class="table-bottom-border">

        </td>
    </tr>

    @else
    <tr>
        <td width="30%">Name</td>
        <td class="table-bottom-border">
            {{ $paidinfo->name }}
        </td>
    </tr>
    <tr>
        <td width="30%">Address</td>
        <td class="table-bottom-border">
            {{ $paidinfo->address }}
        </td>
    </tr>
    <tr>
        <td width="30%">Phone</td>
        <td class="table-bottom-border">
            {{ $paidinfo->phone }}
        </td>
    </tr>
    <tr>
        <td width="30%">Email</td>
        <td class="table-bottom-border">
            {{ $paidinfo->email }}
        </td>
    </tr>
    @endif
</table>
<hr>
<p><b>Related Invoice</b></p>
<table class="table">
    <thead>
        <tr>
            <th>
                Number<br>
                Date
            </th>
            <th>
                Descrition
            </th>
            <th>
                Amount
            </th>
        </tr>
    </thead>
    <tbody>
        @if($account->operation_type==1)
        <tr>
            <td><a href="{{ route('invoice.show',$operationinfo->id) }}">{{ $operationinfo->invoice_no }}
                    <br>{{ $operationinfo->date }} </a>
            </td>
            <td>
                <p>Invoice</p>{{ $operationinfo->CustomerName->name }}
            </td>
            <td align="right">{{ $operationinfo->nettotal }}</td>
        </tr>
        @elseif($account->operation_type==2)
        <tr>
            <td> <a href="{{ route('purchase.show',$operationinfo->id) }}">{{ $operationinfo->purchase_no }}
                    <br> {{ $operationinfo->date }} </a>
            </td>
            <td>
                <p>Purchase Payment</p>{{ $operationinfo->VendorName->name }}
            </td>
            <td align="right">{{ $operationinfo->nettotal }}</td>
        </tr>
        @elseif($account->operation_type==3)
        <tr>
            <td> <a href="{{ route('account.payment.show',$account->id) }}">{{ $account->transection_no }}
                    <br>{{ $account->date }}</a>
            </td>
            <td>
                <p>{{ $operationinfo->description }}</p>{{ $operationinfo->name }}
            </td>
            <td align="right">{{ $account->amount }}</td>
        </tr>
        @else
        <tr>
            <td> <a href="{{ route('transfer.show',$account->invoice_id) }}">{{ $account->transection_no }}
                    <br>{{ $account->date }}</a>
            </td>
            <td>
                <p>{{ $operationinfo->description }}</p>
            </td>
            <td align="right">{{ $account->amount }}</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="amount-section">
    <table width="100%">
        <tr>
            <td></td>
            <td width="100%" align="right">Amount: </td>
            <td align="right">{{ $account->amount }}/-</td>
        </tr>
    </table>
</div>
@endsection