@extends('layouts.usermain')

@section('title', 'Page Not Found')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="text-center">
        <h1 class="serif display-1 text-forest" style="opacity: 0.1; font-size: 8rem;">404</h1>
        <div class="mt-n5">
            <h2 class="serif text-uppercase tracking-widest mb-3">Timepiece Not Found</h2>
            <p class="text-muted mb-5 px-4">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            
            <a href="{{ url('/') }}" class="btn btn-outline-dark px-5 py-3 rounded-0 fw-bold small tracking-widest">
                RETURN TO GALLERY
            </a>
        </div>
    </div>
</div>
@endsection