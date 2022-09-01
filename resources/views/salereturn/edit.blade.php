@extends('layouts.app')
@section('wrapper')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h3>Sale Return</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4" style="height: 140px;">
                        <div class="customer-info-panel">
                            <h4 id="customer-name">{{ $invoice->CustomerName->name }}</h4>
                            <address>
                                <p>
                                    <span id="address">{{ $invoice->CustomerName->address }}</span><br>
                                    <span id="phone">{{ $invoice->CustomerName->phone }}</span><br>
                                    <span id="email">{{ $invoice->CustomerName->email }}<span>
                                </p>
                            </address>
                        </div>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoicedate">Invoice Date</label>
                                    <input type="text" class="form-control" placeholder="Invoice date"
                                        value="{{ $invoice->invoice_date }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoicedate">Invoice Number</label>
                                    <input type="text" id="incoice_no" class="form-control" placeholder="Invoice Number"
                                        value="{{ $invoice->invoice_no }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="invoicedate">Retun Date</label>
                                <input type="text" class="form-control" id="dateinput" placeholder="return Date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="invoicedate">Retun No</label>
                                <input type="text" class="form-control" id="return_no" placeholder="Order Number"
                                    value="{{ $return_no }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="invoicedate">Return Type</label>
                                <select name="" id="return_type" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="1">Adjustment</option>
                                    <option value="2">Return Cash</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6" style="border-right:1px #ccc solid;">
                        <h6>Invoice Details</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered invoice-table" style="width:100%">
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
                                    @foreach($invoice->InvDetails as $inv)
                                    <tr class="i" data-item_id="{{ $inv->item_id }}"
                                        data-tp="{{ $inv->purchase_price }}">
                                        <td>{{  $inv->productName->name }}</td>
                                        <td>{{  $inv->productName->description }}</td>
                                        <td align="right">{{  $inv->qty }}</td>
                                        <td align="right" class="price">
                                            {{  $inv->sale_price }}</td>
                                        <td align="right">{{  $inv->amount }}</td>
                                        <td>
                                            <div class="d-grid"><button class="btn btn-sm add-return"><i
                                                        class="fa-solid fa-right-long"></i></button></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right">Subtotal</td>
                                        <td>{{ $invoice->amount }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">Discount</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">Nettotal</td>
                                        <td>{{ $invoice->nettotal }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">Payment</td>
                                        <td>{{ $paymentAmount }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">Due</td>
                                        <td>{{ $due }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h6>Return Details</h6>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered return-table" style="width:100%"
                                id="return-table">
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
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right">Subtotal</td>
                                        <td id="return-amount"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">Discount</td>
                                        <td id="return-discount" contenteditable="true"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">Nettotal</td>
                                        <td id="return-nettotal"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="adjustment" style="display:none;">
                    <h6>Adjustment</h6>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered data-table" style="width:100%" id="table">
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
                                <tbody></tbody>
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
                                                        data-tp="{{ $item->purchase_price }}" value=" {{  $item->id }}">
                                                        {{  $item->name }}</option>
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
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-8">
                                <h6>Sub Total</h6>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-right" id="amount"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <h6>Discount</h6>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-right" contenteditable="true" id="discount" style="padding-top: 1px;">
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <h6>Net Total</h6>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-right" id="nettotal"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <h6>Payment</h6>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-right" id="paymenamt"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <h6>Due</h6>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-right" id="dueamt"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="cashreturn" style="display:none;">

                    <div class="col-sm-6 mx-auto">
                        <h6 style="border-bottom:1px #ccc;">Cash Return Payment</h6>
                        <!-- <div class="form-group mb-1">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" id="due_amount" placeholder="Amount"
                                value="">
                        </div> -->
                        <div class="form-group mb-1">
                            <label for="paymentmethod">Payment Methos</label>
                            <select name="payment_method" id="payment_method" class="form-control">
                                <option value="1">Cash</option>
                                <option value="2">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <label for="account">Account</label>
                            <div class="mb-3 select2-sm">
                                <select name="account_id" id="account_id" class="form-control">
                                    <option value="0">Select</option>
                                    @foreach($accountinfos as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-1">
                            <label for="Payment Description">Payment Description</label>
                            <textarea id="payment_descripiton" cols="30" rows="5" name="payment_descripiton"
                                class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-end">
                    <div class="d-grid">
                        <div class="btn-group button-grp" role="group" aria-label="Basic example">
                            <button class="btn btn-default px-3">Cancel</button>
                            <button id="datainsert" class="btn btn-success px-3">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var sl = 1;
var customerid = "{{ $invoice->customer_id }}";

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



$("body").on("click", ".add-return", function() {

    var item_id = $(this).parents("tr").attr('data-item_id');
    var itemname = $(this).parents("tr").find("td").eq(0).text();
    var description = $(this).parents("tr").find("td").eq(1).text();
    var tp = $(this).parents("tr").attr('data-tp');
    var mrp = $(this).parents("tr").find("td").eq(3).text();
    var qty = $(this).parents("tr").find("td").eq(2).text();
    var amount = parseFloat(qty * mrp).toFixed(2);

    $(".return-table tbody").append('<tr class="i" data-item_id=' + item_id + ' data-tp=' + tp + '>' +
        '<td>' + itemname + '</td>' +
        '<td contenteditable="true" >' + description + '</td>' +
        '<td class="return-qty" contenteditable="true" align="right">' + qty + '</td>' +
        '<td align="right">' + mrp + '</td>' +
        '<td  class="return-amount" align="right">' + amount + '</td>' +
        '<td><div class="d-grid"><button class="btn btn-sm btn-delete"><i class="fa-solid fa-xmark"></i></button></div></td>' +
        '</tr>');
    RetunTablelSummation();
});

function RetunTablelSummation() {
    $("#return-discount").html("0.00")
    var nettotal = 0;
    var discount = 0;
    if ($("#return-discount").text() == "") {
        discount = 0;
    } else {
        var discount = parseFloat($("#return-discount").text());

    }
    Retunnetamount();
    var subtotal = parseFloat($("#return-amount").text());
    nettotal = (subtotal - discount).toFixed(2);
    $("#return-nettotal").html(nettotal);
    if (nettotal < 0) {
        $("#return-nettotal").css("color", "red");
    } else {
        $("#return-nettotal").css("color", "#000");
    }
}

function Retunnetamount() {
    var sum = 0;
    $(".return-amount").each(function() {
        var value = $(this).text();
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }
    });
    $("#return-amount").html(sum.toFixed(2));
}

$("body").on("keyup", '.return-qty', function() {
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    var qty = $(this).parent("tr").find("td").eq(2).text();
    if (qty == "" || !numberRegex.test(qty)) {
        qty = 0;
    }
    var mrp = $(this).parent("tr").find("td").eq(3).text();
    var amount = parseFloat(qty * mrp).toFixed(2);
    $(this).parents("tr").find("td:eq(4)").text(amount);
    RetunTablelSummation();
});
$("body").on("keyup", '#return-discount', function() {
    RetunTablelSummation();
});

$("#return_type").on('change', function() {
    var return_type = $(this).val();
    console.log(return_type);
    switch (return_type) {
        case '1':
            $("#adjustment").show();
            $("#cashreturn").hide();
            break;
        case '2':
            $("#cashreturn").show();
            $("#adjustment").hide();
            break;
        case '0':
            $("#cashreturn").hide();
            $("#adjustment").hide();
            break;
        default:
            $("#cashreturn").hide();
            $("#adjustment").hide();
            break;
    }
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
    $(".data-table tbody").append('<tr class="i" data-item_id=' + item_id + ' data-tp=' + tp + '>' +
        '<td>' + itemname + '</td>' +
        '<td contenteditable="true" >' + description + '</td>' +
        '<td class="qty" contenteditable="true" align="right">' + qty + '</td>' +
        '<td contenteditable="true" align="right" class="price">' + mrp + '</td>' +
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
                 TablelSummation();
                 RetunTablelSummation();
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
    $("#discount").html("0.00")
    var nettotal = 0;
    var discount = 0;
    if ($("#discount").html() == "") {
        discount = 0;
    } else {
        var discount = parseFloat($("#discount").html());

    }
    netamount();
    console.log(discount);
    var subtotal = parseFloat($("#amount").text());
    nettotal = (subtotal - discount).toFixed(2);
    $("#nettotal").html(nettotal);
    if (nettotal < 0) {
        $("#nettotal").css("color", "red");
    } else {
        $("#nettotal").css("color", "#000");
    }
}

function PaymentCalculation(){

    
}
$("#add-customer").on("click", function() {
    $(".customer-search").show();
    $(".add-customer-panel").hide();
});

$("#choice-customer").on('click', function() {
    customerid = 0;
    $(".customer-search").hide();
    $(".customer-info-panel").hide();
    $(".add-customer-panel").show();

})
$("#customer-info").on('change', function() {

    $(".customer-info-panel").show();
    $(".customer-search").hide();
    $(".add-customer-panel").hide();
    customerid = $("#customer-info").val();
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

function dataInsert() {
    var return_type = $("#return_type").val();
    if (return_type == "0") {
        alert("please select return type");
    } else {
        var return_amount = $("#return-nettotal").text();
        if (return_amount == "0" || return_amount == "") {
            alert("Return Table ahuld not be empty");
        } else {

            if (return_type == "1") {
                var nettotal = $("#nettotal").text();
                if (nettotal == "0") {
                    alert("Please make an adjustment");
                } else {
                    if (nettotal < return_amount) {
                        alert("Adjustment amount should be grater than or equel from return amount");
                    } else {
                        NewInsert();
                    }
                }
            } else {
                var account_id = $("#account_id").val();
                if (account_id == "0") {
                    alert("Please Select adjustment");
                } else {
                    NewInsert();
                }

            }
        }

    }

}

function NewInsert() {
    //Return
    var date = $("#dateinput").val();
    var invoice_id = "{{ $invoice->id }}";
    var return_no = $("#return_no").val();
    var return_type = $("#return_type").val();
    var return_amount = $("#return-amount").text();
    var return_discount = $("#return-discount").text();
    var return_nettotal = $("#return-nettotal").text();
    var return_itemtables = new Array();
    $("#return-table TBODY TR").each(function() {
        var row = $(this);
        var item = {};
        item.item_id = row.data('item_id');
        item.purchase_price = row.data('tp');
        item.name = row.find("TD").eq(0).html();
        item.description = row.find("TD").eq(1).html();
        item.qty = row.find("TD").eq(2).html();
        item.sale_price = row.find("TD").eq(3).html();
        item.amount = row.find("TD").eq(4).html();

        if (item.amount > 0) {
            return_itemtables.push(item);
        }
    });

    if (return_type == "1") {

        //Adjustment
        var amount = $("#amount").text();
        var discount = $("#discount").text();
        var nettotal = $("#nettotal").text();
        var itemtables = new Array();
        $("#table TBODY TR").each(function() {
            var row = $(this);
            var item = {};
            item.item_id = row.data('item_id');
            item.purchase_price = row.data('tp');
            item.name = row.find("TD").eq(0).html();
            item.description = row.find("TD").eq(1).html();
            item.qty = row.find("TD").eq(2).html();
            item.sale_price = row.find("TD").eq(3).html();
            item.amount = row.find("TD").eq(4).html();

            if (item.amount > 0) {
                itemtables.push(item);
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('salereturn.store') }}",
            data: {
                date: date,
                invoice_id: invoice_id,
                return_no: return_no,
                return_type: return_type,
                return_amount: return_amount,
                return_discount: return_discount,
                return_nettotal: return_nettotal,
                return_itemtables: return_itemtables,
                itemtables: itemtables,
                amount: amount,
                discount: discount,
                nettotal: nettotal,
            },
            datatype: ("json"),
            success: function(data) {
                url = "{{ url('Sale-Return/show')}}" + '/' + data,
                    window.location = url;
            },
            error: function(data) {

                console.log(data);
            }
        });

    } else {

        //Cashreturn
        var payment_method = $("#payment_method").val();
        var account_id = $("#account_id").val();
        var payment_description = $("#payment_descripiton").val();

        $.ajax({
            type: "POST",
            url: "{{ route('salereturn.store') }}",
            data: {
                date: date,
                invoice_id: invoice_id,
                return_no: return_no,
                return_type: return_type,
                return_amount: return_amount,
                return_discount: return_discount,
                return_nettotal: return_nettotal,
                return_itemtables: return_itemtables,

                payment_method: payment_method,
                account_id: account_id,
                payment_description: payment_description,
            },
            datatype: ("json"),
            success: function(data) {
                url = "{{ url('Sale-Return/show')}}" + '/' + data,
                    window.location = url;
            },
            error: function(data) {
                $("#overlay").fadeOut();
                swal("Ops! Fail To submit", "Data Submit", "error");
                console.log(data);
            }
        });

    }



}




$("#datainsert").on('click', function() {

    dataInsert();

})
</script>
@endsection