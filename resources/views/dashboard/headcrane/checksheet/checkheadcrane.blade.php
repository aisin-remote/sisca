@extends('dashboard.app')
@section('title', 'Check Sheet Head Crane')

@section('content')
    <div class="container">
        <h1>Check Sheet Head Crane</h1>
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-success col-lg-12">
                {{ session()->get('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('process.checksheet.headcrane', ['headcraneNumber' => $headcraneNumber]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tanggal_pengecekan" class="form-label">Tanggal Pengecekan</label>
                        <input type="date" class="form-control" id="tanggal_pengecekan" name="tanggal_pengecekan"
                            required readonly value="{{ old('tanggal_pengecekan', now()->toDateString()) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="npk" class="form-label">NPK</label>
                        <input type="text" class="form-control" id="npk" name="npk"
                            value="{{ auth()->user()->npk }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="headcrane_number" class="form-label">Nomor Head Crane</label>
                        <input type="text" class="form-control" id="headcrane_number" value="{{ $headcraneNumber }}"
                            name="headcrane_number" required autofocus readonly>
                    </div>
                </div>
            </div>

            @foreach ($itemChecksheets as $item)
                <div class="row align-items-start mb-4">
                    <!-- Header Label -->
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Item Check</label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Check</label>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Photo</label>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Catatan</label>
                        </div>
                    </div>
                    <!-- List Prosedur -->
                    <div class="row align-items-start mb-3">
                        <!-- Item Check -->
                        <div class="col-md-4">
                            <div class="custom-select"
                                style="border: 1px solid #ced4da; padding: 0.5rem; border-radius: 0.25rem; background-color: #fff;">
                                <p style="margin: 0; font-size: 1rem; color: #495057;">
                                    {{ $item->item_check }} - {{ $item->prosedur }}
                                </p>
                            </div>
                        </div>
                        <!-- Check Select -->
                        <div class="col-md-2">
                            <select class="form-select" id="check" name="check[{{ $item->id }}]" required>
                                <option value="" selected disabled>Select</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <!-- Photo -->
                        <div class="col-md-3 d-flex flex-column align-items-start">
                            <img id="photo-preview" class="img-fluid mb-2"
                                style="max-height: 150px; width: 100%; display: none;">
                            <input type="file" class="form-control" id="photo" name="photo[{{ $item->id }}]"
                                onchange="previewImage(this, 'photo-preview')">
                        </div>

                        <!-- Catatan -->
                        <div class="col-md-3">
                            <textarea class="form-control" id="note" name="note[{{ $item->id }}]" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row mt-3">
                <div class="col-md-12">
                    <p><strong>Catatan:</strong> Jika ada abnormal yang ditemukan segera laporkan ke atasan.</p>
                </div>
            </div>

            <div class="row mt-2 mb-5">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </form>
        <script>
            document.querySelectorAll('.btn-success').forEach(button => {
                button.addEventListener('click', () => {
                    const itemId = button.id.split('_')[1];
                    const catatanField = document.getElementById(`catatanField_${itemId}`);
                    catatanField.style.display = catatanField.style.display === 'none' ? 'block' : 'none';
                });
            });

            function previewImage(input, previewId) {
                const file = input.files[0];
                const preview = document.getElementById(previewId);
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                    preview.style.display = "none";
                }
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const textareas = document.querySelectorAll('textarea');

                textareas.forEach(textarea => {
                    // Set initial height
                    textarea.style.overflow = 'hidden';
                    textarea.style.resize = 'none';

                    const adjustHeight = () => {
                        textarea.style.height = 'auto'; // Reset height
                        textarea.style.height =
                            `${textarea.scrollHeight}px`; // Adjust height based on scroll height
                    };

                    // Adjust height on input
                    textarea.addEventListener('input', adjustHeight);

                    // Initial adjustment
                    adjustHeight();
                });
            });
        </script>

    @endsection
