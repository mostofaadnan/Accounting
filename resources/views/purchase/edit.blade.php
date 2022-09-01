@extends('layouts.app')
@section('wrapper')
<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Purchase</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4" style="height: 140px;">
                            <div class="customer-info-panel">
                                <h4 id="customer-name">{{ $purchase->VendorName->name }}</h4>
                                <address>
                                    <p>
                                        <span id="address">{{ $purchase->VendorName->address }}</span><br>
                                        <span id="phone">{{ $purchase->VendorName->phone }}</span><br>
                                        <span id="email">{{ $purchase->VendorName->email }}<span>
                                    </p>
                                    <!-- <p><a href="#" id="choice-customer">Choice Deffrent Customer</a></p> -->
                                </address>
                            </div>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="invoicedate">Purchase Date</label>
                                        <input type="text" class="form-control" id="dateinput"
                                            placeholder="Invoice date" value="{{ $purchase->purchase_date }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="invoicedate">Purchase Number</label>
                                        <input type="text" id="invoice_number" class="form-control"
                                            placeholder="Invoice Number" value="{{ $purchase->purchase_no }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="invoicedate">Order Number</label>
                                    <input type="text" class="form-control" id="order_number" placeholder="Order Number"
                                        value="{{ $purchase->order_no }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data-table" style="width:100%"
                                    id="table">
                                    <thead>
                                        <tr>
                                            <th width="30%">Item</th>
                                            <th width="30%">Description</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchase->InvDetails as $inv)
                                        <tr class="i" data-item_id="{{ $inv->item_id }}"
                                            data-mrp="{{ $inv->sale_price }}">
                                            <td>{{  $inv->productName->name }}</td>
                                            <td contenteditable="true">{{  $inv->productName->description }}</td>
                                            <td class="qty" contenteditable="true" align="right">{{  $inv->qty }}</td>
                                            <td contenteditable="true" align="right" class="price">
                                                {{  $inv->purchase_price }}</td>
                                            <td class="amount" align="right">{{  $inv->amount }}</td>
                                            <td>
                                                <div class="d-grid"><button class="btn btn-sm btn-delete"><i class="fa-solid fa-xmark"></i></button></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr id="search-panel" style="display:none;">
                                            <td colspan="6">
                                                <div class="mb-3 select2-sm">
                                                    <select class="single-select" id="item-entry">
                                                        <option value="">Select</option>
                                                        @foreach($items as $item)
                                                        <option data-name="{{ $item->name }}"
                                                            data-mrp="{{ $item->sale_price }}"
                                                            data-unitname="{{ $item->unit }}"
                                                            data-description="{{ $item->description }}"
                                                            data-tp="{{ $item->purchase_price }}"
                                                            value=" {{  $item->id }}">{{ $item->CategoryName->name }}-{{  $item->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <div class="d-grid">
                                                    <button class="btn btn-default text-center" id="addrow">Add
                                                        Item</button>
                                                </div>
                                            </td>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>Sub Total</h6>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-right" id="amount">{{ $purchase->amount }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>Discount</h6>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-right" contenteditable="true" id="discount"
                                        style="padding-top: 1px;">{{ $purchase->discount }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6>Net Total</h6>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-right" id="nettotal">{{ $purchase->nettotal }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="float-end">
                        <div class="d-grid">
                            <div class="btn-group button-grp" role="group" aria-label="Basic example">
                                <button class="btn btn-default px-3">Cancel</button>
                                <button id="datainsert" class="btn btn-success px-3">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var sl = 1;
var vendorid = "{{ $purchase->vendor_id }}";
$('#dateinput').bootstrapMaterialDatePicker({
    time: false
});
$(function() {
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;
    $("#dateinput").val(output);
});
$("#addrow").on('click', function() {
    $("#search-panel").show();

});
$("#item-entry").on('change', function() {
    Adrows();
});

function Adrows() {
    var item_id = $("#item-entry").val();
    var itemname = $("#item-entry").find(':selected').data('name')
    var description = $("#item-entry").find(':selected').data('description')
    var mrp = $("#item-entry").find(':selected').data('mrp')
    var tp = $("#item-entry").find(':selected').data('tp')
    var qty = 1;
    var amount = parseFloat(qty * mrp).toFixed(2);
    $(".data-table tbody").append('<tr class="i" data-item_id=' + item_id + ' data-mrp=' + mrp + '>' +
        '<td>' + itemname + '</td>' +
        '<td contenteditable="true" >' + description + '</td>' +
        '<td class="qty" contenteditable="true" align="right">' + qty + '</td>' +
        '<td contenteditable="true" align="right" class="price">' + tp + '</td>' +
        '<td  class="amount" align="right">' + amount + '</td>' +
        '<td><div class="d-grid"><button class="btn btn-sm btn-delete"><i class="fa-solid fa-xmark"></i></button></div></td>' +
        '</tr>');
    TablelSummation();
    $("#search-panel").hide();

}


$("body").on("keyup", '.qty', function() {
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    var qty = $(this).parent("tr").find("td").eq(2).text();
    if (qty == "" || !numberRegex.test(qty)) {
        qty = 0;
    }
    var mrp = $(this).parent("tr").find("td").eq(3).text();
    var amount = parseFloat(qty * mrp).toFixed(2);
    $(this).parents("tr").find("td:eq(4)").text(amount);
    TablelSummation();
});

$("body").on("keyup", '.price', function() {
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    var price = $(this).parent("tr").find("td").eq(3).text();
    if (price == "" || !numberRegex.test(price)) {
        price = 0;
    }
    var qty = $(this).parent("tr").find("td").eq(2).text();
    var amount = parseFloat(qty * price).toFixed(2);
    $(this).parents("tr").find("td:eq(4)").text(amount);
    TablelSummation();
});


$("body").on("click", ".btn-delete", function() {
    swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $(this).parents("tr").remove();
                ///  TablelSummation();
            } else {
                //swal("Your imaginary file is safe!");
            }
        });
});

function netamount() {
    var sum = 0;
    $(".amount").each(function() {
        var value = $(this).text();
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }
    });

    $("#amount").html(sum.toFixed(2));

}

$("body").on("keyup", '#discount', function() {

    TablelSummation();
});

function TablelSummation() {
    var nettotal = 0;
    var discount = 0;
    if ($("#discount").text() == "") {
        discount = 0;
    } else {
        var discount = parseFloat($("#discount").text());

    }
    netamount();
    var subtotal = parseFloat($("#amount").text());
    nettotal = (subtotal - discount).toFixed(2);
    $("#nettotal").html(nettotal);
    if (nettotal < 0) {
        $("#nettotal").css("color", "red");
    } else {
        $("#nettotal").css("color", "#000");
    }
}
$("#add-customer").on("click", function() {
    $(".customer-search").show();
    $(".add-customer-panel").hide();
});

$("#choice-customer").on('click', function() {
    vendorid = 0;
    $(".customer-search").hide();
    $(".customer-info-panel").hide();
    $(".add-customer-panel").show();

})
$("#customer-info").on('change', function() {

    $(".customer-info-panel").show();
    $(".customer-search").hide();
    $(".add-customer-panel").hide();
    vendorid = $("#customer-info").val();
    var name = $("#customer-info").find(':selected').data('name');
    var phone = $("#customer-info").find(':selected').data('phone');
    var email = $("#customer-info").find(':selected').data('email');
    var address = $("#customer-info").find(':selected').data('address');
    $("#customer-name").html(name);
    $("#phone").html(phone);
    $("#email").html(email);
    $("#address").html(address);

});

//DataInsert

function DataInsert() {

    /*  $("#overlay").fadeIn(); */

    var purchase_no = $("#invoice_number").val();
    var purchase_date = $("#dateinput").val();
    var order_no = $("#order_number").val();
    var amount = $("#amount").text();
    var discount = $("#discount").text();
    var nettotal = $("#nettotal").text();

    var itemtables = new Array();
    $("#table TBODY TR").each(function() {
        var row = $(this);
        var item = {};
        item.item_id = row.data('item_id');
        item.sale_price = row.data('mrp');
        item.name = row.find("TD").eq(0).html();
        item.description = row.find("TD").eq(1).html();
        item.qty = row.find("TD").eq(2).html();
        item.purchase_price = row.find("TD").eq(3).html();
        item.amount = row.find("TD").eq(4).html();

        if (item.amount > 0) {
            itemtables.push(item);
        }
    });
    $.ajax({
        type: "POST",
        url: "{{ route('purchase.update') }}",
        data: {
            itemtables: itemtables,
            id:"{{ $purchase->id }}", 
            purchase_date: purchase_date,
            purchase_no: purchase_no,
            vendor_id: vendorid,
            order_no: order_no,
            amount: amount,
            discount: discount,
            nettotal: nettotal,
        },
        datatype: ("json"),
        success: function(data) {
            $("#overlay").fadeOut();
            if (data > 0) {
                url = "{{ url('Purchase/show')}}" + '/' + data,
                    window.location = url;
            } else {
                swal("Ops! Something Wrong", "Data Submit Fail", "error");
            }
        },
        error: function(data) {
            $("#overlay").fadeOut();
            swal("Ops! Fail To submit", "Data Submit", "error");
            console.log(data);
        }
    });

}

$("#datainsert").on('click', function() {
    var nettotal = parseFloat($("#nettotal").text());
    if (nettotal > 0 && vendorid > 0) {
        DataInsert();
    }
})
</script>
@endsection