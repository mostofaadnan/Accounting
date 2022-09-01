@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 text-uppercase">New Product</h4>
                    </div>
                    <div class="card-body">
                        @include('layouts.ErrorMessage')
                        <form action="{{ route('item.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                 <label for="category">Category</label>
                                 <select name="category_id" class="form-control">
                                @foreach($Categories as $cate)    
                                 <option value="{{ $cate->id }}" {{ $cate->id==$item->category-id? 'selected':'' }}>{{ $cate->name }}</option>
                                 @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="name">Name <span style="color:red;">*</span></label>
                                <input type="text" name="name" placeholder="Name" value="{{ $item->name }}"
                                    class="form-control" require>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="description">Description</label>
                                <textarea name="description" id="" cols="30" rows="5"
                                    class="form-control">{{ $item->description }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="type">Item Type</label>
                                <select name="type" id="" class="form-control">
                                    <option value="general" {{ $item->type=='general'? 'selected':'' }}>General</option>
                                    <option value="Blend" {{ $item->type=='Blend'? 'selected':'' }}>Blend</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <input class="form-check-input" type="checkbox" value="{{ $item->sale }}"
                                        id="defaultCheck1" name="sale" checked>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Purchase Informaiton
                                    </label>
                                    @error('sale')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-check-input" type="checkbox" value="{{ $item->purchase }}"
                                        name="purchase" id="defaultCheck1" checked>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Sale Informaiton
                                    </label>

                                    @error('purchase')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="saleprice">Purchase Price <span style="color:red;">*</span></label>
                                        <input type="text" name="purchase_price" value="{{ $item->purchase_price }}"
                                            placeholder="Purchase Price" class="form-control" require>
                                        @error('purchase_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="saleprice">Sale Price <span style="color:red;">*</span></label>
                                        <input type="text" name="sale_price" placeholder="Sale Price"
                                            value="{{ $item->sale_price }}" class="form-control" require>
                                        @error('sale_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="openingstock">Opening Stock <span
                                                style="color:red;">*</span></label>
                                        <input type="text" name="opening_stock" id="" placeholder="Opening Stock"
                                            value="{{ $item->opening_stock }}" purchase_price class="form-control"
                                            require>
                                        @error('opening_stock')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="float-end mt-20">
                                <button class="btn btn-sm btn-default">Cancel</button>
                                <button type="submit" class="btn  btn  btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection