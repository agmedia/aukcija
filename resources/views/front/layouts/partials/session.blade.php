@if(session('success'))
    <!-- Success alert -->
    <div class="alert alert-success d-flex alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <i class="ci-check-circle"></i>
        </div>
        <span class="fw-medium me-2">Uspjeh..! </span> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger d-flex" role="alert">
        <div class="alert-icon">
            <i class="ci-close-circle"></i>
        </div>
        <div>Greška..! {{ session('error') }}</div>
    </div>

@endif
@if(session('warning'))
    <div class="alert alert-warning d-flex" role="alert">
        <div class="alert-icon">
            <i class="ci-security-announcement"></i>
        </div>
        <div>Upozorenje..! {{ session('warning') }}</div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
