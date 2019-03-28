
@if ($errors->any() )
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success">
        <p>{{ session()->get('success') }}</p>
    </div>
@endif