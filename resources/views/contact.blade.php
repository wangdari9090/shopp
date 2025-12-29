@extends('layouts.usermain')

@section('content')
{{-- Use a subtle gradient or light background to match the "mist" theme --}}
<section class="py-5 bg-light overflow-hidden">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-success fw-bold text-uppercase small tracking-widest">Connect</span>
            <h2 class="section-title-luxury mt-2">Get in Touch</h2>
            <div class="mx-auto" style="width: 50px; height: 2px; background: #198754;"></div>
        </div>

        <div class="row g-5 justify-content-center">
            {{-- Contact Form --}}
            <div class="col-lg-7">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm p-3 p-md-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <form action="{{ route('contact') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control border-light-subtle py-2" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control border-light-subtle py-2" placeholder="john@example.com" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="subject" class="form-label small fw-bold text-muted text-uppercase">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control border-light-subtle py-2" placeholder="How can we help?" required>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label small fw-bold text-muted text-uppercase">Message</label>
                                <textarea name="message" id="message" class="form-control border-light-subtle" rows="5" placeholder="Your inquiry..." required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg py-3 shadow-sm text-uppercase fw-bold tracking-widest" style="font-size: 0.85rem; background-color: #093822; border: none;">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Contact Info Side --}}
            <div class="col-lg-4">
                <div class="h-100 d-flex flex-column gap-4">
                    {{-- Info Card --}}
                    <div class="card border-0 bg-white shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 text-dark">Contact Information</h5>
                            
                            <div class="d-flex mb-4">
                                <div class="icon-box me-3" style="color: #093822">
                                    <i class="bi bi-geo-alt fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small text-uppercase fw-bold">Boutique Office</p>
                                    <p class="mb-0 text-dark">123 Main Street, City, Country</p>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="icon-box me-3" style="color: #093822">
                                    <i class="bi bi-telephone fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small text-uppercase fw-bold">Call Us</p>
                                    <p class="mb-0 text-dark">+1 234 567 890</p>
                                </div>
                            </div>

                            <div class="d-flex mb-0">
                                <div class="icon-box me-3" style="color: #093822">
                                    <i class="bi bi-envelope fs-4"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small text-uppercase fw-bold">Email Support</p>
                                    <p class="mb-0 text-dark">support@myshop.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Socials --}}
                    <div class="card border-0 shadow-sm text-center bg-light" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h6 class="text-uppercase tracking-widest small mb-3 text-light-emphasis">Follow the Craft</h6>
                            <div class="d-flex justify-content-center gap-4">
                                <a href="#" style="color: #0d3b26;" class="opacity-75 hover-opacity-100">
                                    <i class="bi bi-facebook fs-4"></i>
                                </a>
                                <a href="#" style="color: #0d3b26;" class="opacity-75 hover-opacity-100">
                                    <i class="bi bi-twitter-x fs-4"></i>
                                </a>
                                <a href="#" style="color: #0d3b26;" class="opacity-75 hover-opacity-100">
                                    <i class="bi bi-instagram fs-4"></i>
                                </a>
                                <a href="#" style="color: #0d3b26;" class="opacity-75 hover-opacity-100">
                                    <i class="bi bi-linkedin fs-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection