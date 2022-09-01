@foreach($products as $product)
<option id="{{ $product->id }}" data-name="{{ $product->name }}" data-mrp="{{ $product->sale_price }}"
    data-unitname="{{ $product->unit }}" value="{{ $product->name }}">
    @endforeach
