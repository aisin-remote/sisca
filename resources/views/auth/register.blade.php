@extends('layout.master')
@section('title', 'Registrasi')

@section('content')

    <div class="container mt-2 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body m-2 rounded"
                        style="background-image:url('https://www.aisinindonesia.co.id/assetweb/image/login/bg.jpg');background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;background-position:center;">
                        <div class="m-4">
                            <h2>REGISTRATION</h2>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="/register" method="POST">
                                @csrf

                                <div class="mb-3 mt-3">
                                    <label for="name" class="form-label">Name
                                        <span class="text-danger">*</span></label>
                                    <input type="name"
                                        class="form-control @error('name')
                                    is-invalid @enderror"
                                        id="name" name="name" aria-describedby="name" required
                                        value="{{ old('name') }}" autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="npk" class="form-label">NPK
                                        <span class="text-danger">*</span></label>
                                    <input type="number" step="1" min="0"
                                        class="form-control @error('npk')
                                    is-invalid @enderror"
                                        id="npk" name="npk" aria-describedby="npk" required
                                        value="{{ old('npk') }}" autofocus>
                                    @error('npk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" disabled selected>Select role</option>
                                        <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>Safety</option>
                                        <option value="MTE" {{ old('role') == 'MTE' ? 'selected' : '' }}>MTE</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password">
                                        <span class="input-group-text" id="toggle-password">
                                            <i class="bi bi-eye-slash" id="password-icon"></i>
                                        </span>
                                    </div>
                                    <div id="password-error" class="invalid-feedback"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Password Confirmation <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation">
                                        <span class="input-group-text" id="toggle-password-confirmation">
                                            <i class="bi bi-eye-slash" id="password-confirmation-icon"></i>
                                        </span>
                                    </div>
                                    <div id="password-confirmation-error" class="invalid-feedback"></div>
                                </div>

                                <button type="submit" class="btn btn-primary center-block w-100 mb-3">SIGN UP</button>
                                <p class="text-muted">
                                    Alredy have an account?
                                    <a href="/login" style="font-weight: 700;" class="custom-link">
                                        Login now.</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }

        document.getElementById('toggle-password').addEventListener('click', function() {
            togglePasswordVisibility('password', 'password-icon');
        });

        document.getElementById('toggle-password-confirmation').addEventListener('click', function() {
            togglePasswordVisibility('password_confirmation', 'password-confirmation-icon');
        });

        // Jika Anda ingin menghilangkan pesan kesalahan saat pengguna mengklik input
        ['password', 'password_confirmation'].forEach(function(inputId) {
            document.getElementById(inputId).addEventListener('focus', function() {
                const errorId = inputId + '-error';
                document.getElementById(errorId).textContent = '';
                document.getElementById(inputId).classList.remove('is-invalid');
            });
        });
    </script>

@endsection
