@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <style .input-group-text{width:auto;}></style>
            <div class="card-header card-header-section">
                <div class="float-start">
                   User Manage
                </div>
                <div class="float-end">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group" role="group" aria-label="First group">
                            <a type="button" class="btn btn-light px-5 radius-30"
                                href="{{Route('user.create')}}">New User</i>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('user.partials.userTable')
            </div>
        </div>
    </div>
</div>
@include('user.partials.userregisterscript')
@endsection