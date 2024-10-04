@extends('layout')

@section('customCss')
<style>
    .hero-bg {
        width: 100%;
        height: auto;
        position: relative;
        object-fit: cover;
    }

    #product-details img {
        width: 100%;
        height: 100%;
        max-width: 600px;
        border-radius: 10px;
        border: 10px solid #fff;
        object-fit: cover;
    }

    #product_description{
      color: #FA8072;
    }

    /* Modal Styles */
    .modal-success {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        border-radius: 10px;
        margin: 15% auto;
        padding: 20px;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-title {
        font-size: 24px;
        font-weight: bold;
        color: #4CAF50;
        margin-bottom: 10px;
    }

    .modal-message {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .modal-button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .modal-button:hover {
        background-color: #45a049;
    }
</style>
@endsection

@section('content')
<main class="main">

  <section id="hero" class="hero section dark-background">
    <img src="/usercss/img/hero-bg.jpg" alt="" data-aos="fade-in" class="hero-bg">

    <div id="product-details" class="container" style="display:none; position: relative; z-index: 2;">
      <div class="row">
        <div class="col-lg-6">
          <img id="product-image" class="img-fluid" alt="Product Image">
        </div>
        <div class="col-lg-4">
          <h2 id="product-name"></h2>
          <p>Price: Rs. <span id="product-cost"></span></p>
          <p id="product_description"></p>

          <!-- Quantity Selection -->
          <div class="form-group" style="margin: 20px 2px;">
            <label for="quantity" style="font-weight: bold;">Quantity:</label>
            <select id="quantity" class="form-control" style="width: auto; display: inline-block;">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>

          <!-- Total Price Display -->
          <p>Total Price: Rs. <span id="total-price">0.00</span></p>

          <!-- "Book Now" button dynamically shows or hides based on the token presence -->
          <a href="#" class="btn btn-primary" id="book-now" style="display:none;" data-product-id="">Book Now</a>
          <a href="{{ route('login') }}" class="btn btn-primary" id="login-to-book" style="display:none;">Book Now</a>

        </div>
      </div>
    </div>
  </section>

  <!-- Success Modal -->
  <div class="modal-success" id="booking-success-modal">
    <div class="modal-content">
      <div class="modal-title">You did it! Your booking is confirmed! 🎊</div>
      <div class="modal-message">Get ready for an unforgettable experience.</div>
      <button class="modal-button" id="close-modal">Close</button>
    </div>
  </div>

</main>
@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        const token = localStorage.getItem('api_token');
        const productId = window.location.pathname.split('/').pop();
        let productCost = 0;

        // Show "Book Now" or "Login to Book" buttons based on token presence
        if (token) {
            $('#book-now').show();
            $('#login-to-book').hide();
        } else {
            $('#book-now').hide();
            $('#login-to-book').show();
        }

        // Fetch product details
        function fetchProductDetails(productId) {
            $.ajax({
                url: `/api/view-product/${productId}`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.message === 'Product not found') {
                        alert('Product not found!');
                        return;
                    }

                    // Correctly set the image URL
                    const imageUrl = response.image_url ? `/storage/${response.image_url}` : 'https://media.istockphoto.com/id/499517325/photo/a-man-speaking-at-a-business-conference.jpg?s=612x612&w=0&k=20&c=gWTTDs_Hl6AEGOunoQ2LsjrcTJkknf9G8BGqsywyEtE=';
                    $('#product-image').attr('src', imageUrl);
                    $('#product-name').text(response.product_name);
                    $('#product-cost').text(response.product_cost);
                    $('#product_description').text(response.product_description);
                    
                    productCost = parseFloat(response.product_cost); // Store product cost

                    $('#book-now').attr('data-product-id', response.id);
                    $('#total-price').text(productCost.toFixed(2));

                    $('#product-details').fadeIn(1000);
                },
                error: function(xhr) {
                    console.error("Failed to fetch product details: ", xhr.responseText);
                }
            });
        }

        // Update total price based on quantity selection
        $('#quantity').change(function() {
            const selectedQuantity = $(this).val();
            const totalPrice = productCost * selectedQuantity;
            $('#total-price').text(totalPrice.toFixed(2));
        });

        // Handle booking
        $('#book-now').click(function(e) {
            e.preventDefault();

            const productId = $(this).data('product-id');
            const token = localStorage.getItem('api_token');
            const quantity = $('#quantity').val();
            const totalPrice = $('#total-price').text(); 

            if (!token) {
                window.location.href = '{{ route("login") }}';
                return;
            }

            $.ajax({
                url: '{{ route("book-product") }}',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                data: {
                    product_id: productId,
                    quantity: quantity,
                    total_price: totalPrice,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status) {
                        $('#booking-success-modal').fadeIn();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error("Booking failed: ", xhr.responseText);
                }
            });
        });

        $('#close-modal').click(function() {
            $('#booking-success-modal').fadeOut();
            window.location.href = '/my-bookings';
        });

        // Fetch product details on page load
        fetchProductDetails(productId);
    });
</script>
@endsection
