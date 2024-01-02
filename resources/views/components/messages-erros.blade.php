@if ($errors->any())
    <div class="card-body">
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif
@if (session('message'))
    <div class="card-body">
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    </div>
@endif
<!-- infos -->
@if (session('info'))
    <div class="card-body">
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    </div>
@endif