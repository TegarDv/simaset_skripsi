<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=chrome">
    {{-- <link rel="icon" href=""> --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons-1.10.5/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-4.1.0-rc.0/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap-5-theme-1.3.0/select2-bootstrap-5-theme.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>SIMASET - Login</title>
</head>
<body>
    <div class="container">
        <div style="margin-top: 200px;"></div>
        <div class="row m-5">
            <div class="col-lg-6 d-none d-lg-block d-flex justify-content-center align-items-center mt-5">
                <img src="https://spmb.polinema.ac.id/devel/asset/images/polinema_logo.png" class="object-fit-contain rounded" alt="Logo" style="min-height: 20rem; min-width: 20rem; max-height: 20rem; max-width: 20rem;">
            </div>
            <div class="col-lg-6 justify-content-center align-items-center">
                <h3>Selamat Datang</h3>
                <h5>Silahkan Login terlebih dahulu</h5>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" placeholder="name@example.com" name="email" required>
                        <div class="invalid-feedback">
                            Please provide a valid email address.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                        <div class="invalid-feedback">
                            Please provide a password.
                        </div>
                    </div>
                    <button class="btn btn-primary container" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/bootstrap-5.3.1-dist/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
</body>
</html>