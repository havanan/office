@if(Session::has('error'))
    <p class="alert {{ Session::get('alert-class', 'alert alert-danger') }}">{{ Session::get('error') }}</p>
@endif
@if(Session::has('success'))
    <p class="alert {{ Session::get('alert-class', 'alert alert-success') }}">{{ Session::get('success') }}</p>
@endif
