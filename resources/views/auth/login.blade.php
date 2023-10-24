@extends('layout.master')
@section('title', 'Login')

@section('content')
    <div class="container mt-2 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body m-2 rounded"
                        style="background-image:url('https://www.aisinindonesia.co.id/assetweb/image/login/bg.jpg');background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;background-position:center;">
                        <div class="m-4">
                            <h2>LOGIN</h2>

                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if (session()->has('loginError'))
                                <div class="alert alert-danger">
                                    {{ session()->get('loginError') }}
                                </div>
                            @endif

                            <form action="/login" method="POST">
                                @csrf
                                <div class="mb-3 mt-3">
                                    <label for="npk" class="form-label">NPK <span class="text-danger">*</span></label>
                                    <input type="number" step="1" min="0"
                                        class="form-control @error('npk')
                                    is-invalid @enderror"
                                        name="npk" id="npk" aria-describedby="npk" autofocus required
                                        value="{{ old('npk') }}">
                                    @error('npk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password">
                                        <span class="input-group-text" id="toggle-password">
                                            <i class="bi bi-eye-slash" id="password-icon"></i>
                                        </span>
                                    </div>
                                    <div id="password-error" class="invalid-feedback"></div>
                                </div>

                                <button type="submit" class="btn btn-primary center-block w-100 mb-3">LOG IN</button>
                                <p class="text-muted">
                                    Dont Have an account yet?
                                    <a href="/register" style="font-weight: 700;" class="custom-link">
                                        Register now.</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        const passwordError = document.getElementById('password-error');

        document.getElementById('toggle-password').addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            }
        });

        // Jika Anda ingin menghilangkan pesan kesalahan saat pengguna mengklik input
        passwordInput.addEventListener('focus', function () {
            passwordError.textContent = '';
            passwordInput.classList.remove('is-invalid');
        });
    </script>


@endsection
