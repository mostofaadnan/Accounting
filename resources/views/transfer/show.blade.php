@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3>Transfer</h3>
                        </div>
                        <div class="col-sm-5">
                            <div class="float-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('invoice.create') }}" class="btn btn-sm custom-btn">New Income</a>
                                    <a href="" class="btn btn-sm">Edit</a>
                                    <div class="dropdown">
                                        <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">

                                            <a class="dropdown-item" id="datashow" data-id="">View</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('transfer.pdf',$transfer->id) }}" class="dropdown-item" target="_blank">PDF</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" id="printslip" data-id="">Print</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" id="mail" data-id="">Send
                                                Mail</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" id="datashow" data-id="">Return</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" id="canceldata" data-id="">Cancel</a>

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
                                <p>{{ $transfer->username->name }} created this Transfer on {{ $transfer->PaymentInfo->date }}</p>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4>Transfer</h4>
                                    <div class="row">
                                    @include('layouts.company')
                                    </div>
                                </div>
                                <div class="card-body">
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