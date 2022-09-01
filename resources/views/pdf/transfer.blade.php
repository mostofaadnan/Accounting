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
    margin-top: 100px;
    float: right;

}

.table-bottom-border {
    border-bottom: 2px #ccc dotted;
}
</style>
<p><b>From</b></p>
<table width="100%">
    <tr>
        <td>Aaccount Name:</td>
        <td>{{ $transfer->fromAccountInfo->account_name }}</td>
    </tr>
    <tr>
        <td>Aaccount number:</td>
        <td>{{ $transfer->fromAccountInfo->account_number }}</td>
    </tr>
    <tr>
        <td>Bank Name:</td>
        <td>{{ $transfer->fromAccountInfo->bank_name }}</td>
    </tr>
    <tr>
        <td>Phone:</td>
        <td>{{ $transfer->fromAccountInfo->bank_phone }}</td>
    </tr>
    <tr>
        <td>Address:</td>
        <td>{{ $transfer->fromAccountInfo->bank_phone }}</td>
    </tr>
</table>
<hr>
<p><b>To</b></p>
<table width="100%">
    <tr>
        <td>Aaccount Name:</td>
        <td>{{ $transfer->toAccountInfo->account_name }}</td>
    </tr>
    <tr>
        <td>Aaccount number:</td>
        <td>{{ $transfer->toAccountInfo->account_number }}</td>
    </tr>
    <tr>
        <td>Bank Name:</td>
        <td>{{ $transfer->toAccountInfo->bank_name }}</td>
    </tr>
    <tr>
        <td>Phone:</td>
        <td>{{ $transfer->toAccountInfo->bank_phone }}</td>
    </tr>
    <tr>
        <td>Address:</td>
        <td>{{ $transfer->toAccountInfo->bank_phone }}</td>
    </tr>
</table>
<hr>
<p><b>Details</b></p>
<table whidth="100%">
    <tr>
        <td>Date:</td>
        <td>{{ $transfer->PaymentInfo->date }}</td>
    </tr>
    <tr>
        <?php
if ($transfer->PaymentInfo->payment_method == 1) {
    $type = 'Cash';
} else {
    $type = 'Bank transfer';
}
?>
        <td>Peyment Method:</td>
        <td>{{  $type }}</td>
    </tr>
    <tr>
        <th>Peyment Description:</th>
        <td>{{ $transfer->PaymentInfo->payment_descripiton }}</td>
    </tr>
</table>
<div class="amount-section">
    <table width="100%">
        <tr>
            <td></td>
            <td width="100%" align="right">Amount: </td>
            <td align="right">{{ $transfer->PaymentInfo->amount }}/-</td>
        </tr>
    </table>
</div>
@endsection