@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Pagina Principal</h1>
@endsection

@section('content')
    <div class="row">
        <!-- Slider Section -->
        <div class="col-md-12">
            <div id="dashboardSlider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('vendor/adminlte/dist/img/Slider1.jpg') }}" class="d-block w-100" alt="Slide 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Welcome to the Cargo System</h5>
                            <p>Manage your operations efficiently.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('vendor/adminlte/dist/img/Slider2.jpg') }}" class="d-block w-100" alt="Slide 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Track Your Shipments</h5>
                            <p>Real-time tracking and updates.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('vendor/adminlte/dist/img/Slider3.jpg') }}" class="d-block w-100" alt="Slide 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Optimize Your Routes</h5>
                            <p>Save time and reduce costs.</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#dashboardSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#dashboardSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Statistics Section -->
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>
                    <p>Active Shipments</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53%</h3>
                    <p>Efficiency Rate</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>
                    <p>Pending Deliveries</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.carousel').carousel();
        });
    </script>
@endsection