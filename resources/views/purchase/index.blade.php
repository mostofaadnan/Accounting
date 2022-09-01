@extends('layouts.app')
@section('wrapper')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 text-uppercase">Purchase</h3>
                <div class="float-end">
                    <a href="{{ route('purchase.create') }}" class="btn btn-sm btn-info">New Purchase</a>
                </div>
            </div>
            <div class="card-body">
                @include('layouts.ErrorMessage')
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%" id="mytable">
                        <thead>
                            <tr>
                                <th>#Sl</th>
                                <th>Date</th>
                                <th>Purchase Number</th>
                                <th>Vendor</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#Sl</th>
                                <th>Date</th>
                                <th>Purchase Number</th>
                                <th>Vendor</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
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
        aLengthMenu: [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 100,

        footerCallback: function() {
            var sum = 0;
            var column = 0;
            this.api().columns('4', {
                page: 'current'
            }).every(function() {
                column = this;
                sum = column
                    .data()
                    .reduce(function(a, b) {
                        a = parseFloat(a, 10);
                        if (isNaN(a)) {
                            a = 0;
                        }
                        b = parseFloat(b, 10);
                        if (isNaN(b)) {
                            b = 0;
                        }
                        return (a + b).toFixed(2);
                    }, 0);
                $(column.footer()).html(sum);

            });
        },

        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

        "ajax": {
            "url": "{{ route('purchase.loadall') }}",
            "type": "GET",
        },

        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: "text-center"
            },
            {
                data: 'purchase_date',
                name: 'purchase_date',
                className: "text-center"
            },
            {
                data: 'purchase_no',
                name: 'purchase_no',
                className: "text-center"
            },

            {
                data: 'vendor',
                name: 'vendor',
            },
            {
                data: 'nettotal',
                name: 'nettotal',
                className: "text-right"
            },
            {
                data: 'payment',
                name: 'payment',
                className: "text-right"
            },
            {
                data: 'due',
                name: 'due',
                className: "text-right"
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
    });

}
window.onload = DataTable();
</script>
@endsection