@extends('layout')

@section('customCss')
<style>
    .hero-bg {
        width: 100%;
        height: auto;
        position: relative;
        object-fit: cover;
    }

    .booking-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        margin: 10px 10px;
        background-color: rgba(10, 10, 10, 0.5);
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.3s;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        width: 100%; 
        max-width: 400px; 
        box-sizing: border-box; 
    }

    .booking-card:hover {
        box-shadow: 0 4px 15px rgba(130, 130, 130, 10); 
        transform: translateY(-20px); 
    }

    .booking-title {
        font-size: 22px;
        font-weight: bold;
        color: #f9f9f9; 
        margin-bottom: 10px;
    }

    .booking-details {
        font-size: 16px;
        color: #555; 
        margin: 5px 0;
    }

    .booking-price {
        font-size: 18px;
        font-weight: bold;
        color: #28a745; 
        margin-top: 10px;
    }

    .empty-message {
        text-align: center;
        font-size: 18px;
        color: #888;
        margin-top: 20px; 
    }
</style>
@endsection

@section('content')
<main class="main">
    <section id="hero" class="hero section dark-background">
        <img src="/usercss/img/hero-bg.jpg" alt="" data-aos="fade-in" class="hero-bg">
        <section id="my-bookings" class="my-bookings section">
            <div class="container section-title" data-aos="fade-up">
                <h2>My Bookings<br></h2>
            </div>

            <div class="container">
                <div class="row gy-4" id="booking-list">
                    <!-- Booking cards will be inserted here by AJAX -->
                </div>
                <div class="empty-message" id="empty-message" style="display: none;">
                    You have no bookings yet!
                </div>
            </div>
        </section>
    </section>
</main>
@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        const token = localStorage.getItem('api_token'); 

        if (!token) {
            window.location.href = '{{ route("login") }}'; 
            return;
        }

        // Fetch user's bookings
        function fetchBookings() {
            $.ajax({
                url: '/api/my-bookings', 
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token, 
                },
                success: function(response) {
                    console.log(response);
                    // console.log(response.bookings);
 
                    if (response.status) {
                        
                        $('#booking-list').empty();
                        
                        
                        if (response.bookings.length > 0) {
                            response.bookings.forEach(booking => {
                                $('#booking-list').append(`
                                    <div class="col-md-4">
                                        <div class="booking-card">
                                            <div class="booking-title">${booking.product_name}</div>
                                            <div class="booking-details">Quantity: ${booking.pivot.quantity}</div>
                                            <div class="booking-price">Price: Rs. ${booking.pivot.total_price}</div>
                                        </div>
                                    </div>
                                `);
                            });
                            $('#empty-message').hide(); 
                        } else {
                            $('#empty-message').show(); 
                        }
                    } else {
                        alert(response.message); 
                    }
                },
                error: function(xhr) {
                    console.error("Failed to fetch bookings: ", xhr.responseText);
                }
            });
        }

        
        fetchBookings();
    });
</script>
@endsection
