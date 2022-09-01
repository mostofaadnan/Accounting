@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 text-uppercase">New Customer</h4>
                    </div>
                    <div class="card-body">
                        @include('layouts.ErrorMessage')
                        <form action="{{ route('account.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $accountinfo->id }}">
                            <div class="form-group">
                                <label for="bank_type">Account Type</label>
                                <select name="account_type" class="form-control">
                                    <option value="1" {{ $accountinfo->account_type==1 ? 'selected':'' }}>Cash</option>
                                    <option value="2" {{ $accountinfo->account_type==2 ? 'selected':'' }}>Bank</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="accountname">Account Name</label>
                                <input type="text" name="account_name" class="form-control"
                                    value="{{ $accountinfo->account_name }}" placeholder="Account Name">
                            </div>
                            <div class="form-group">
                                <label for="accountname">Account Number</label>
                                <input type="text" name="account_number" class="form-control"
                                    value="{{ $accountinfo->account_number }}" placeholder="Account Number">
                            </div>
                            <div class="form-group">
                                <label for="accountname">Opening Balance</label>
                                <input type="number" name="opening_balance" class="form-control"
                                    value="{{ $accountinfo->opening_balance }}" placeholder="Opening Balance">
                            </div>
                            <hr>
                            <h4>Bank</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="accountname">Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control"
                                            value="{{ $accountinfo->bank_name }}" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="accountname">Bank Phone</label>
                                        <input type="text" name="bank_phone" class="form-control"
                                            value="{{ $accountinfo->bank_phone }}" placeholder="Account Name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="accountname">Bank Address</label>
                                <textarea name="" id="" cols="30" rows="5" name="bank_address" class="form-control"
                                    placeholder="Account Name">{{ $accountinfo->bank_phone }}</textarea>
                            </div>
                            <div class="float-end mt-2">
                                <button class="btn btn-sm btn-default">Cancel</button>
                                <button type="submit" class="btn  btn  btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
