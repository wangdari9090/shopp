@extends('layouts.usermain')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold text-center mb-4">Contact Us</h2>
    <p class="text-center mb-5 text-muted">We’d love to hear from you. Please fill out the form below.</p>

    <div class="row justify-content-center">
        {{-- Contact Form --}}
        <div class="col-lg-6">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('contact') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Get in Touch</h5>
                    <p><i class="bi bi-geo-alt-fill me-2"></i>123 Main Street, City, Country</p>
                    <p><i class="bi bi-telephone-fill me-2"></i>+1 234 567 890</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>support@myshop.com</p>

                    <h6 class="fw-bold mt-4 mb-3">Follow Us</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-decoration-none text-primary"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="text-decoration-none text-info"><i class="bi bi-twitter fs-4"></i></a>
                        <a href="#" class="text-decoration-none text-danger"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#" class="text-decoration-none text-secondary"><i class="bi bi-linkedin fs-4"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
