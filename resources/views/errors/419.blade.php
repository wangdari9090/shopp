@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))

@extends('layouts.usermain') {{-- Use your existing luxury layout --}}

@section('title', 'Session Expired')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh; background-color: #f9f9f7;">
    <div class="text-center">
        <h1 class="serif display-1 text-forest" style="opacity: 0.2;">419</h1>
        <h2 class="serif mb-4">Your session has timed out.</h2>
        <p class="text-muted mb-5">For security, your connection has expired. Please refresh the page and try again.</p>
        
        <a href="{{ url()->previous() }}" class="btn btn-luxury px-5 py-3 rounded-0">
            REFRESH PAGE
        </a>
    </div>
</div>

<style>
    .text-forest { color: #0d3b26; }
    .btn-luxury { 
        background-color: #0d3b26; 
        color: white; 
        letter-spacing: 2px; 
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-luxury:hover { 
        background-color: #08291a; 
        color: #d4af37; 
    }
</style>
@endsection