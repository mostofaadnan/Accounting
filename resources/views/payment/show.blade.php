@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3>Reciept</h3>
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
                                            <a href="{{ route('account.payment.pdf', $account->id ) }}"
                                                class="dropdown-item" target="_blank">PDF</a>
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
                                <p>{{ $account->username->name }} created this payment on {{ $account->date }}</p>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4>Reciept</h4>
                                    <div class="row">
                                    @include('layouts.company')
                                    </div>
                                </div>
                                <div class="card-body">
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
                                            <td class="table-bottom-border">{{ $account->AccountInfo->account_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Category:</td>
                                            <td class="table-bottom-border">{{ $account->description }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%">Payment Method:</td>
                                            <td class="table-bottom-border">
                                                <?php
if ($account->payment_method == "1") {
    $paymentMethod = "Cash";
} else {
    $paymentMethod = "Bank Transfer";
}
?>
                                                {{ $paymentMethod }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Payment Description:</td>
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