@extends('dashboard.app')
@section('title', 'Data Check Sheet Apar')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-2 pb-2 mb-3 border-bottom col-lg-12">
        <h3>Informasi Profile</h3>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-12">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="card col-lg-8">
        <div class="card-body">
            @if (session()->has('success1'))
                <div class="alert alert-success">
                    {{session()->get('success1')}}
                </div>
            @endif
            <div class="row">
                <div class="h6 col-4">Nama</div>
                <div class="col-4 text-muted">{{ auth()->user()->name }}</div>
              </div>
              <hr class="mt-2">
              <div class="row">
                <div class="h6 col-4">NPK</div>
                <div class="col-4 text-muted">{{ auth()->user()->npk }}</div>
              </div>
              <hr>
              <div class="row">
                <div class="h6 col-4">Role</div>
                <div class="col-4 text-muted">{{ auth()->user()->role }}</div>
              </div>
        </div>
      </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom col-md-8">
            <h1 class="h2">Ganti Password</h1>
        </div>
        <div class="card col-md-8 mb-5">
            <div class="card-body">
                <form action="/dashboard/profile" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{session()->get('success')}}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{session()->get('error')}}
                        </div>
                    @endif

                    @if (session()->has('error1'))
                        <div class="alert alert-danger">
                            {{session()->get('error1')}}
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Lama" required>
                            <span class="input-group-text toggle-password" id="toggle-password">
                                <i class="bi bi-eye-slash" id="password-icon"></i>
                            </span>
                        </div>
                        <div id="password-error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="passwordBaru" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passwordBaru" name="passwordBaru" placeholder="Masukkan Password Baru" required>
                            <span class="input-group-text toggle-password" id="toggle-passwordBaru">
                                <i class="bi bi-eye-slash" id="passwordBaru-icon"></i>
                            </span>
                        </div>
                        <div id="passwordBaru-error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label for="ulangiPassword" class="form-label">Ulangi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="ulangiPassword" name="ulangiPassword" placeholder="Masukkan Ulang Password Baru" required>
                            <span class="input-group-text toggle-password" id="toggle-ulangiPassword">
                                <i class="bi bi-eye-slash" id="ulangiPassword-icon"></i>
                            </span>
                        </div>
                        <div id="ulangiPassword-error" class="invalid-feedback"></div>
                    </div>

                    <button type="submit" class="btn btn-warning">Edit</button>
                </form>
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

            // Menambahkan event listener untuk setiap input password
            document.querySelectorAll('.toggle-password').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const inputId = toggle.previousElementSibling.id;
                    const iconId = toggle.querySelector('i').id;
                    togglePasswordVisibility(inputId, iconId);
                });
            });

            // Jika Anda ingin menghilangkan pesan kesalahan saat pengguna mengklik input
            ['password', 'passwordBaru', 'ulangiPassword'].forEach(function (inputId) {
                document.getElementById(inputId).addEventListener('focus', function () {
                    const errorId = inputId + '-error';
                    document.getElementById(errorId).textContent = '';
                    document.getElementById(inputId).classList.remove('is-invalid');
                });
            });
        </script>

@endsection
