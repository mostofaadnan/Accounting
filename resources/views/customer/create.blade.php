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
                        <form action="{{ route('customer.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="name">Name <span style="color:red;">*</span></label>
                                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                                    class="form-control" require>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                    class="form-control" require>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="phone">Phone</label>
                                <input type="phone" name="phone" placeholder="Phone" value="{{ old('phone') }}"
                                    class="form-control" require>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="description">Address</label>
                                <textarea name="address" id="" cols="30" rows="3"
                                    class="form-control">{{ old('address') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="float-end mt-20">
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
