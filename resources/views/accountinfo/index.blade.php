@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 text-uppercase">Account</h3>
                <div class="float-end">
                    <a href="{{ route('account.create') }}" class="btn btn-sm btn-info">New Account</a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.ErrorMessage')
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%" id="mytable">
                        <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Bank</th>
                                <th>Current Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Account Name</th>
                                <th>Bank</th>
                                <th>Current Balance</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var table;

$(document).ready(function() {

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
                "url": "{{ route('account.loadall') }}",
                "type": "GET",
            },
            columns: [

                {
                    data: 'account_name',
                    name: 'account_name',

                },
                {
                    data: 'bank_name',
                    name: 'bank_name',

                },
                {
                    data: 'current_balance',
                    name: 'current_balance',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
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
