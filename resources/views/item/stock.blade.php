@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 text-uppercase">Stock Information</h3>
                <div class="float-end">
                    <a href="{{ route('item.create') }}" class="btn btn-sm btn-info">New Item</a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.ErrorMessage')
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%" id="mytable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Purchase Price</th>
                                <th>Sale Price</th>
                                <th>Opening Stock</th>
                                <th>Purchase</th>
                                <th>Sale</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Purchase Price</th>
                                <th>Sale Price</th>
                                <th>Opening Stock</th>
                                <th>Purchase</th>
                                <th>Sale</th>
                                <th>Stock</th>
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
                "url": "{{ route('item.stock.loadall') }}",
                "type": "GET",
            },
            columns: [

                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'type',
                    name: 'type',

                },
                {
                    data: 'purchase_price',
                    name: 'purchase_price',

                },
                {
                    data: 'sale_price',
                    name: 'sale_price',

                },

                {
                    data: 'opening_stock',
                    name: 'opening_stock',

                },
                {
                    data: 'purchase',
                    name: 'purchase',

                },
                {
                    data: 'invoice',
                    name: 'invoice',

                },
                {
                    data: 'stock',
                    name: 'stock',

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
                    url: "{{ url('Item/delete')}}" + '/' + dataid,
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