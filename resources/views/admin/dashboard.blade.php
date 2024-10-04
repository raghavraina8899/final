@extends('admin.layout')

@section('customCss')
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('lang.dashboard') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">{{ __('lang.home') }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- User Registrations Box -->
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 id="userCount">Loading...</h3> <!-- Dynamically updated using AJAX -->
                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('admin.view_user') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Products Box -->
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="productCount">Loading...</h3> <!-- Dynamically updated using AJAX -->
                                <p>Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('admin.view_product') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- <div class="col-lg-3 col-6">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px">%</sup></h3>
                                <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    

                    <div class="col-lg-3 col-6">

                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>65</h3>
                                <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div> -->

                </div>
            </div>
        </section>

    </div>
@endsection

@section('customJs')
    <script>
        $(document).ready(function () {
            // Fetch dashboard stats using AJAX
            $.ajax({
                url: '/api/dashboard-stats', // The API endpoint
                method: 'GET',
                success: function (response) {
                    // Update the counts in the respective HTML elements
                    $('#userCount').text(response.userCount);
                    $('#productCount').text(response.productCount);
                },
                error: function () {
                    alert('Failed to load dashboard stats');
                }
            });
        });
    </script>
@endsection
