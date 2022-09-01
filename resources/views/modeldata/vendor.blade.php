<div class="modal fade" id="vendormodel" tabindex="-1" aria-labelledby="citymodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Vendor</h5>
                <button type="button" class="btn-close model-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{ route('purchase.newvendor') }}" method="post" enctype="multipart/form-data">
                        @csrf
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
                            <label for="email">Email</label>
                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                class="form-control" require>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="phone">Phone</label>
                            <input type="phone" name="phone" placeholder="Phone" value="{{ old('phone') }}"
                                class="form-control" require>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="description">Address</label>
                            <textarea name="address" id="" cols="30" rows="3"
                                class="form-control">{{ old('address') }}</textarea>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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