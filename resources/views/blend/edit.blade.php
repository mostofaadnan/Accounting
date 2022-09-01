@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3>New Blend</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="blenditem">Item</label>
                                        <div class="mb-3 select3-sm">
                                            <select class="single-select" id="blend_item">
                                                <option value="">Select</option>
                                                @foreach($blenditems as $item)
                                                <option data-name="{{  $item->CategoryName->name }} {{ $item->name }}"
                                                    data-mrp="{{ $item->sale_price }}" data-unitname="{{ $item->unit }}"
                                                    data-description="{{ $item->description }}"
                                                    data-tp="{{ $item->purchase_price }}" value="{{  $item->id }}"
                                                    {{  $blend->productName->id==$item->id?'selected':'' }}>
                                                    {{ $item->CategoryName->name }}-{{  $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="purchase_price">Purchase Price</label>
                                    <input type="text" id="purchase_price" placeholder="Purchase Price"
                                        class="form-control" value="{{ $blend->purchase_price }}">
                                </div>
                                <div class="col-sm-6">
                                    <label for="purchase_price">Sale Price</label>
                                    <input type="text" id="sale_price" placeholder="Sale Price" class="form-control"
                                        value="{{ $blend->sale_price }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="invoicedate">Date</label>
                                <input type="text" class="form-control" id="dateinput" placeholder="Invoice date"
                                    value="{{ $blend->date }}">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <h5>Blend Details</h5>
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
                                        @foreach($blend->InvDetails as $inv)
                                        <tr class="i" data-item_id="{{ $inv->item_id }}"
                                            data-mrp="{{ $inv->sale_price }}">
                                            <td>{{  $inv->productName->CategoryName->name }} {{  $inv->productName->name }}</td>
                                            <td contenteditable="true">{{  $inv->productName->description }}</td>
                                            <td class="qty" contenteditable="true" align="right">{{  $inv->qty }}</td>
                                            <td contenteditable="true" align="right" class="price">
                                                {{  $inv->purchase_price }}</td>
                                            <td class="amount" align="right">{{  $inv->amount }}</td>
                                            <td>
                                                <div class="d-grid"><button class="btn btn-sm btn-delete"><i
                                                            class="fa-solid fa-xmark"></i></button></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" align="right"><b>Total</b></td>
                                            <td id="totalqty" align="right">{{  $blend->totalqty }}</td>
                                            <td></td>
                                            <td id="amount" align="right">{{ $blend->amount }}</td>
                                            <td></td>
                                        </tr>
                                        <tr id="search-panel" style="display:none;">
                                            <td colspan="6">
                                                <div class="mb-3 select2-sm">
                                                    <select class="single-select" id="item-entry">
                                                        <option value="">Select</option>
                                                        @foreach($generalitems as $item)
                                                        <option
                                                            data-name="{{  $item->CategoryName->name }} {{ $item->name }}"
                                                            data-mrp="{{ $item->sale_price }}"
                                                            data-unitname="{{ $item->unit }}"
                                                            data-description="{{ $item->description }}"
                                                            data-tp="{{ $item->purchase_price }}"
                                                            value=" {{  $item->id }}">
                                                            {{ $item->CategoryName->name }}-{{  $item->name }}</option>
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
</div>
@include('modeldata.vendor')
<script src="https://unpkg.com/feather-icons"></script>
<script>
feather.replace()
var sl = 1;
var item_id = "{{ $blend->item_id }}";
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
$("#blend_item").on('change', function() {
    item_id = $("#blend_item").val();
    var mrp = $("#blend_item").find(':selected').data('mrp');
    var tp = $("#blend_item").find(':selected').data('tp');
    $("#sale_price").val(mrp);
    $("#purchase_price").val(tp);
    console.log(item_id);

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
    var amount = parseFloat(qty * tp).toFixed(2);
    $(".data-table tbody").append('<tr class="i" data-item_id=' + item_id + ' data-mrp=' + mrp + '>' +
        '<td><div class="form-group">' + itemname + '</td>' +
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

function totalqty() {
    var sum = 0;
    $(".qty").each(function() {
        var value = $(this).text();
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }
    });

    $("#totalqty").html(sum.toFixed(2));

}

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
    totalqty();
    netamount();

}

//DataInsert
function DataInsert() {


    var date = $("#dateinput").val();
    var totalqty = $("#totalqty").text();
    var amount = $("#amount").text();
    var sale_price = $("#sale_price").val();
    var purchase_price = $("#purchase_price").val();

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
        url: "{{ route('blend.update') }}",
        data: {
            id:"{{  $blend->id }}",
            itemtables: itemtables,
            date: date,
            item_id: item_id,
            sale_price: sale_price,
            purchase_price: purchase_price,
            amount: amount,
            totalqty: totalqty,
        },
        datatype: ("json"),
        success: function(data) {
            $("#overlay").fadeOut();
            if (data > 0) {
                url = "{{ url('Blend/show')}}" + '/' + data,
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
    var amount = parseFloat($("#amount").text());
    var totalqty = parseFloat($("#totalqty").text());
    if (amount > 0 && item_id > 0 && totalqty > 0) {
        DataInsert();
    }
})
</script>
@endsection
