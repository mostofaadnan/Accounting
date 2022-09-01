@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3></h3>
                        </div>
                        <div class="col-sm-5">
                            <div class="float-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('blend.create') }}" class="btn btn-sm custom-btn">New Blend</a>
                                    <a href="{{ route('blend.edit', $blend->id ) }}" class="btn btn-sm">Edit</a>
                                    <div class="dropdown">
                                        <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('invoice.pdf',$blend->id) }}" class="dropdown-item"
                                                target="_blank">PDF</a>
                                            <div class="dropdown-divider"></div>
                                            <button id="deletedata" class="dropdown-item"
                                                data-id="{{ $blend->id }}">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="col-sm-12">
                                <h5>Create</h5>
                                <p>{{ $blend->username->name }} created this Blend on {{ $blend->date }}
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4>Blend Details</h4>
                                    <div class="row">
                                        @include('layouts.company')
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h5>Item Description</h5>
                                            <h6>{{ $blend->productName->name }}
                                                <br>
                                                Purchase Price:{{ $blend->purchase_price }}<br>
                                                Sale Price:{{ $blend->sale_price }}
                                            </h6>
                                        </div>
                                        <div class="col-sm-5">
                                            <p><b>Date:</b> <span class="ml-4">{{ $blend->date }}</span></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Blend Item Details</h6>
                                            <table class="table-borderless custom-table">
                                                <thead class="custom-header-table">
                                                    <tr>
                                                        <th width="100%"
                                                            class="item text text-semibold text-alignment-left text-left text-white border-radius-first">
                                                            Item</th>
                                                        <th>Quanitity</th>
                                                        <th>Price</th>
                                                        <th
                                                            class="item text text-semibold text-alignment-left text-left text-white border-radius-last">
                                                            Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="customer-table-boody">
                                                    @foreach($blend->InvDetails as $item)
                                                    <tr>
                                                        <td style="margin-left: 10px;">
                                                            {{ $item->productName->CategoryName->name }}
                                                            {{ $item->productName->name }}
                                                            <p style="font-size: 12px;">
                                                                {{ $item->productName->description }}</p>
                                                        </td>
                                                        <td align="right"> {{ $item->qty }}</td>
                                                        <td align="right"> {{ $item->sale_price }}</td>
                                                        <td align="right"> {{ $item->amount }}</td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot class="custom-table-footer">
                                                    <tr style="margin-top: 20px;">
                                                        <td colspan="1" align="right">Net Total</td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $blend->totalqty }}</td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;"></td>
                                                        <td align="right" style="border-bottom: 1px #003 solid;">
                                                            {{ $blend->amount }}</td>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <th></th>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
                console.log(dataid);
                $.ajax({
                    type: "delete",
                    url: "{{ url('Blend/delete')}}" + '/' + dataid,
                    success: function(data) {
                        url = "{{ url('Blend')}}",
                            window.location = url;
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
