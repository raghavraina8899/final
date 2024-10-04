@extends('layout')

@section('customCss')
<style>
    #product-list img {
        position: relative;
        height: 200px;
        object-fit: cover;
    }
    #product-list .member-info{
        z-index: 999;
    }
</style>
@endsection

@section('content')
<main class="main">

<section id="hero" class="hero section dark-background">
  <img src="/usercss/img/hero-bg.jpg" alt="" data-aos="fade-in" class="hero-bg">
  <section id="speakers" class="speakers section">
      <div class="container section-title" data-aos="fade-up">
        <h2>{{ __('lang.availableEvents') }}<br></h2>
      </div>

      <div class="container">
        <div class="row gy-4" id="product-list">
          <!-- Product cards will be inserted here by AJAX -->
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
    function fetchProducts() {
        $.ajax({
            url: "{{ route('api.view-product-list') }}", 
            type: "GET",
            dataType: "json",
            success: function(response) {
                
                if (response.status === false) {
                    console.log(response.message); 
                    return;
                }

                
                $('#product-list').empty();

                
                $.each(response, function(index, product) {
                    const imageUrl = product.image_url ? `/storage/${product.image_url}` : 'https://media.istockphoto.com/id/499517325/photo/a-man-speaking-at-a-business-conference.jpg?s=612x612&w=0&k=20&c=gWTTDs_Hl6AEGOunoQ2LsjrcTJkknf9G8BGqsywyEtE=';
                    $('#product-list').append(`
                        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                            <div class="member">
                                <img src="${imageUrl || 'https://media.istockphoto.com/id/499517325/photo/a-man-speaking-at-a-business-conference.jpg?s=612x612&w=0&k=20&c=gWTTDs_Hl6AEGOunoQ2LsjrcTJkknf9G8BGqsywyEtE='}" class="img-fluid" alt="${product.product_name}">
                                <div class="member-info">
                                    <div class="member-info-content">
                                    <h4><a href="{{ url('events/view_product') }}/${product.id}">${product.product_name}</a></h4><span>Rs. ${product.product_cost}</span>
                                    </div>
                                    <div class="social">
                                        <a href="{{ url('events/view_product') }}/${product.id}"><i class="bi bi-cart-fill"></i> Book Now</a>
                                        <a href="{{ url('events/view_product') }}/${product.id}"><i class="bi bi-info-circle"></i> Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText); 
            }
        });
    }

    
    fetchProducts();
});
</script>
@endsection