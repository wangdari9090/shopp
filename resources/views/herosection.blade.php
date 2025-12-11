@extends('masterdesign')
@section('herosection')
{{-- Hero Section --}}
<section class="hero-section d-flex align-items-center justify-content-center text-center text-white mb-5" 
         style="background-image: url('https://gshock.casio.com/content/casio/locales/intl/en/brands/gshock/products/women/_jcr_content/root/responsivegrid/container/container_1689197747/carousel/image_copy_copy_1169.casiocoreimg.jpeg/1763360726976/gma-p2110-kv-pc.jpeg'); 
                background-size: cover; 
                background-position: center; 
                width: 100%;
                height: 600px; 
                position: relative;">

    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" 
         style="background-color: rgba(0, 0, 0, 0.5);">
    </div>

    <div class="hero-content position-relative">
        <h1 class="display-4 fw-bold">Welcome to MyShop</h1>
        <p class="lead mb-4">Discover the latest trends in fashion and electronics</p>
        <a href="#" class="btn btn-primary btn-lg rounded-pill">Shop Now</a>
    </div>
</section>
@endsection