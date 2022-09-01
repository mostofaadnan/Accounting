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
                        <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                 <label for="category">Category</label>
                                 <select name="category_id" class="form-control">
                                @foreach($Categories as $cate)    
                                 <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                 @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="name">Name <span style="color:red;">*</span></label>
                                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
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
                                    class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="type">Item Type</label>
                                <select name="type" id="" class="form-control">
                                    <option value="general">General</option>
                                    <option value="Blend">Blend</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1"
                                        name="sale" checked>
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
                                    <input class="form-check-input" type="checkbox" value="1" name="purchase"
                                        id="defaultCheck1" checked>
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
                                        <input type="text" name="purchase_price" value="{{ old('purchase_price') }}"
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
                                            value="{{ old('sale_price') }}" class="form-control" require>
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
                                            value="{{ old('opening_stock') }}" purchase_price class="form-control"
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