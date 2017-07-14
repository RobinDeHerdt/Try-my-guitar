@if (Session::has('success-message'))
    <div class="alert alert-success alert-margin" id="alert">{{ Session::get('success-message') }}</div>
@endif
@if (Session::has('info-message'))
    <div class="alert alert-info alert-margin" id="alert">{{ Session::get('info-message') }}</div>
@endif
@if (Session::has('warning-message'))
    <div class="alert alert-warning alert-margin" id="alert">{{ Session::get('warning-message') }}</div>
@endif
@if (Session::has('error-message'))
    <div class="alert alert-danger alert-margin" id="alert">{{ Session::get('error-message') }}</div>
@endif