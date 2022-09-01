@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
<div class="row">
    <div class="col-sm-6 mx-auto">
    <div class="card">
            <div class="card-header">
                <h3 class="mb-0 text-uppercase">Category</h3>
                <div class="float-end">
                    <a href="{{ route('category.create') }}" class="btn btn-sm btn-info">New Category</a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.ErrorMessage')
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%" id="mytable">
                        <thead>
                            <tr>
                                <th width="90%">Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th width="90%">Name</th>
                                <th>Action</th>
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
                "url": "{{ route('category.loadall') }}",
                "type": "GET",
            },
            columns: [

                {
                    data: 'name',
                    name: 'name',

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
                    url: "{{ url('Category/delete')}}" + '/' + dataid,
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