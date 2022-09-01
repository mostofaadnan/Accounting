@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h4>Report</h4>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="d-grid gap-2 col-3 mx-auto">
                        <a href="{{ route('report.purchase') }}" class="btn btn-lg btn-outline-secondary">Purchase</a>
                        <a href="{{ route('report.purchasePaymentCreate') }}"
                            class="btn btn-lg btn-outline-secondary">Purchase Payment</a>
                        <a href="{{ route('report.invoice') }}" class="btn btn-lg btn-outline-secondary">Sales</a>
                        <a href="{{ route('report.invoicePaymentCreate') }}" class="btn btn-lg btn-outline-secondary">Invoice Payment</a>
                        <button class="btn btn-lg btn-outline-secondary">Transection</button>
                        <button class="btn btn-lg btn-outline-secondary">Transfer</button>
                        <button class="btn btn-lg btn-outline-secondary">Expense</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
