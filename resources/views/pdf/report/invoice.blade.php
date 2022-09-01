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
            <th class="item text text-semibold text-alignment-left text-left text-white">Date</th>
            <th class="text-center">Invoice No</th>
            <th width="30%" class="text-center">Customer</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Paid</th>
            <th class="item text text-semibold text-alignment-left text-left text-white">Due</th>
        </tr>
    </thead>
    <tbody class="customer-table-boody">
       <?php 
       $totalpayment=0;
       $totaldue=0;
       ?> 
        @foreach($data['invoice'] as $item)
        <?php
$netttoal = $item->nettotal;
$payment = $item->paidinfo()->sum('amount');
$due = $netttoal - $payment;
?>
        <tr>
            <td style="margin-left: 10px;"> {{ $item->invoice_date }}</td>
            <td> {{ $item->invoice_no }}</td>
            <td> {{ $item->CustomerName->name }}</td>
            <td align="right"> {{ $netttoal  }}</td>
            <td align="right"> {{ $payment  }}</td>
            <td align="right">{{ $due }}</td>
        </tr>
<?php 
$totalpayment=$totalpayment+$payment;
$totaldue=$totaldue+$due;
?>
        @endforeach

    </tbody>
    <tfoot class="custom-table-footer">
        <tr style="margin-top: 20px;">
            <td colspan="2"></td>
            <td align="right"><b>Netotal</b></td>
            <td align="right"><b>{{ $data['invoice']->sum('nettotal') }}</b></td>
            <td align="right"><b>{{ $totalpayment }}</b></td>
            <td align="right"><b>{{ $totaldue }}</b></td>
        </tr>
    </tfoot>

</table>
@endsection