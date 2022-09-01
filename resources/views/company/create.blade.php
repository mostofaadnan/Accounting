@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 text-uppercase">Company Information</h4>
                    </div>
                    <div class="card-body">



                    <form action="{{ route('general.update') }}" method="post"  enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="site-header">Company Name</label>
                                <input type="text" name="company_name" value="{{ config('company.company_name') }}"
                                    class="form-control" require>
                            </div>
                            <div class="form-group">
                                <label for="site-header">Address</label>
                                <input type="text" name="address"
                                    value="{{ config('company.address') }}" class="form-control" placeholder="Address" require>
                            </div>
                            <div class="form-group">
                                <label for="site-header">Email Address</label>
                                <input type="email" name="email" value="{{ config('company.email') }}"
                                    class="form-control" require>
                            </div>
                            <div class="form-group">
                                <label for="site-header">Mobile Number</label>
                                <input type="phone" name="phone" value="{{ config('company.phone') }}"
                                    class="form-control" require>
                            </div>
                         
                            <div class="form-group">
                                <label for="site-header">Main Logo</label><br>
                                <img src="{{ asset('image/logo/'.config('company.company_logo')) }}" alt="">
                                <input type="file" name="company_logo" class="mt-2 mb-2">
                            </div>
                     
                            <button type="submit" class="btn btn-success mt-2">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
