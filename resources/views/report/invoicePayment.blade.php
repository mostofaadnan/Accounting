@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">

        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 text-uppercase">Invoice Payment</h3>
            </div>
            <div class="card-body">
                @include('layouts.ErrorMessage')
                <div class="row">
                    <div class="col-sm-12" style=" border-left:1px #ccc solid;">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="width:100%" id="mytable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Transection Number</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Billing Info</th>
                                        <th>Amount</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Transection Number</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
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
            footerCallback: function() {
                var sum = 0;
                var column = 0;
                this.api().columns('6', {
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
            //dom: 'lBfrtip',
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-2'<'col-sm-4'i><'col-sm-4 text-center'B><'col-sm-4'p>>",
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>Excel',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    footer: true,
                },
                {
                    text: '<i class="fa fa-file-pdf-o"></i>PDF',
                    className: 'btn btn-danger',
                    attr: {
                        id: 'pdfconforms',
                    },

                },

            ],
            "ajax": {
                "url": "{{ route('report.invoicePaymentData')}}",
                "type": "GET",
            },
            columns: [

                {
                    data: 'date',
                    name: 'date',

                },
                {
                    data: 'account',
                    name: 'account',

                },
                {
                    data: 'transection_no',
                    name: 'transection_no',

                },
                {
                    data: 'invoice_no',
                    name: 'invoice_no',

                },
                {
                    data: 'invoice_date',
                    name: 'invoice_data',

                },
                {
                    data: 'customer',
                    name: 'customer',

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

$(document).on('click', '#pdfconforms', function() {

    url = "{{ url('Report/invoicePaymentPdf')}}",
        window.open(url, '_blank');

});
</script>
@endsection
