@extends('layouts.app')
@section('wrapper')


<div class="page-wrapper">
    <div class="page-content">
        <style>
        .user-panel {
            box-shadow: none;
        }
        </style>
        <div class="row">
            <div class="col-sm-8 form-single-input-section">
                <div class="card">
                    <div class="card-header card-header-section">New User</div>
                    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            @include('user.partials.userform')
                        </div>

                        <div class="card-footer card-footer-section">

                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="submit" class="btn btn-success">
                                        Submit
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection