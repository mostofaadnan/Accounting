<div class="col-sm-8">
    <img src="{{ asset('image/logo/'.config('company.company_logo')) }}" alt="" width="100px" height="100px">
</div>
<div class=" col-sm-4">
    <h6>{{ config('company.company_name') }}</h6>
    <address>
        <p>{{ config('company.address') }} <br>
            {{ config('company.email') }} <br>
            {{ config('company.phone') }}</p>
    </address>
</div>
