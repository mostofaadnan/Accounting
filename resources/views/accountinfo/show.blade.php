@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 text-uppercase">{{ $accountinfo->account_name }}</h3>
                    <div class="float-end">
                        <a href="{{ route('account.create') }}" class="btn btn-sm btn-info">New Payment</a>
                        <a href="{{ route('account.create') }}" class="btn btn-sm">Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.ErrorMessage')
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h2 style="border-bottom:1px #ccc solid;" align="center">{{ $credit }}/-</h2>
                                    <p align="center">Credit</p>
                                </div>
                                <div class="col-sm-4">
                                    <h2 style="border-bottom:1px #ccc solid;" align="center">{{ $debit }}/</h2>
                                    <p align="center">Debit</p>
                                </div>
                                <div class="col-sm-4">
                                    <h2 style="border-bottom:1px #ccc solid;" align="center">{{ $currentbalance }}/-
                                    </h2>
                                    <p align="center">Current Balance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="info-account">
                                <p>Account Number</p>
                                <p>{{ $accountinfo->account_number }}</p>

                                <p>Opening Balance</p>
                                <p>{{ $accountinfo->opening_balance }}</p>
                            </div>
                        </div>
                        <div class="col-sm-9" style=" border-left:1px #ccc solid;">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%" id="mytable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transection Number</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Billing Info</th>
                                            <th>Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transection Number</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Billing Info</th>
                                            <th>Amount</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var table;

$(document).ready(function() {


    var accountid = "{{ $accountinfo->id }}";

    function DataTable() {

        table = $('#mytable').DataTable({
            responsive: true,
            paging: true,
            scrollY: 400,
            ordering: true,
            searching: true,
            colReorder: true,
            keys: true,
            processing: true,
            serverSide: true,

            //dom: 'lBfrtip',
            dom: "<'row'<'col-sm-5'l><'col-sm-7'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "ajax": {
                "url": "{{ url('Account/LoadAllAccountDetails')}}" + '/' + accountid,
                "type": "GET",
            },
            columns: [

                {
                    data: 'date',
                    name: 'date',

                },
                {
                    data: 'transection_no',
                    name: 'transection_no',

                },
                {
                    data: 'type',
                    name: 'type',

                },
                {
                    data: 'description',
                    name: 'description',

                },
                {
                    data: 'document',
                    name: 'document',



                },
                {
                    data: 'amount',
                    name: 'amount',

                },


            ],
        });
        $('.dataTables_length').addClass('bs-select');
    }
    window.onload = DataTable();

});

$(document).on('click', '#deletedata', function() {
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this  data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var dataid = $(this).data("id");
                $.ajax({
                    type: "delete",
                    url: "{{ url('Customer/delete')}}" + '/' + dataid,
                    success: function(data) {
                        table.ajax.reload();

                    },
                    error: function() {
                        swal("Opps! Faild", "Form Submited Faild", "error");

                    }
                });
                swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });


})
</script>
@endsection
