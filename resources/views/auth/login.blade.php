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

                            <form>
                                <div class="mb-3 mt-3">
                                    <label for="exampleInputEmail1" class="form-label">NPK <span
                                            class="text-danger">*</span></label>
                                    <input type="npk" class="form-control" id="npk" aria-describedby="npk">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password">
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

@endsection
