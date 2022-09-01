@extends('layouts.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h4>Report Query</h4>
            </div>
            <div class="card-body">
                <h4>Report type : {{ $type }}</h4>
                <div class="row">
                @include('layouts.ErrorMessage')
                    <form action="{{ route('report.reportquery') }}" method="GET">
                        <input type="hidden" name="inputtype" value="{{ $inputtype }}">
                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="to">To</label>
                                <input type="text" name="todate" class="form-control" placeholder="To" id="todate">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="to">Form</label>
                                <input type="text" name="fromdate" class="form-control" placeholder="Form" id="fromdate">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-info btn-sm" value="Submit">
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
$('#todate').bootstrapMaterialDatePicker({
    time: false
});
$('#fromdate').bootstrapMaterialDatePicker({
    time: false
});
</script>
@endsection
