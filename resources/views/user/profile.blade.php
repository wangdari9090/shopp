@extends('layouts.usermain')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                
                <div class="text-center mb-4">
                    <h4 class="fw-bold mb-1">Account Settings</h4>
                    <p class="text-muted small">Update your personal information</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 small py-2">{{ session('success') }}</div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        <div class="mb-2">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('storage/profiles/'.Auth::user()->profile_image) }}" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border" style="width: 80px; height: 80px;">
                                    <span class="text-muted fw-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="profile_image" class="form-control form-control-sm d-inline-block w-auto">
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">NAME</label>
                            <input type="text" name="name" class="form-control border-light shadow-none" value="{{ Auth::user()->name }}" style="background: #fcfcfc;">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">EMAIL ADDRESS</label>
                            <input type="email" class="form-control border-light shadow-none bg-light text-muted" value="{{ Auth::user()->email }}" disabled>
                        </div>

                        <div class="col-12 pt-3">
                            <button type="submit" class="btn w-100 py-2 fw-bold" style="background: #0d3b26; color: white;">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="my-4 opacity-25">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('index') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Home</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-link text-danger p-0 text-decoration-none small">Logout</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #0d3b26 !important;
        box-shadow: none !important;
    }
</style>
@endsection