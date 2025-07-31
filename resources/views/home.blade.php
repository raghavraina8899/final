@extends('layout')

@section('customCss')
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <style>
    #product-list img {
      height: 220px;
      object-fit: cover;
    }

    .swiper-slide {
      display: flex;
      justify-content: center;
    }

    .swiper-wrapper {
      display: flex;
      align-items: stretch;
    }

    .swiper-button-next,
    .swiper-button-prev {
      z-index: 999;
      width: 40px;
      height: 1500px;
    }

    .swiper-button-next {
      right: 10px;
    }

    .swiper-button-prev {
      left: 10px;
    }
  </style>
@endsection

@section('content')  

<main class="main">

  <!-- Hero Section -->
  <section id="hero" class="hero section dark-background">

    <img src="/usercss/img/hero-bg.jpg" alt="" data-aos="fade-in" class="">

    <div class="container d-flex flex-column align-items-center text-center mt-auto">
      <h2 data-aos="fade-up" data-aos-delay="100" class="">{{ __('lang.welcome') }}<br>{{ __('lang.to') }}<br><span>{{ __('lang.new') }}</span> {{ __('lang.acropolis') }}</h2>
      <p data-aos="fade-up" data-aos-delay="200">{{ __('lang.internationalOrg') }}</p>
      <div data-aos="fade-up" data-aos-delay="300" class="">
        <a href="https://youtu.be/DRU5bhj8wb8?si=6FHCBEYIGfeBN-Vk" class="glightbox pulsating-play-btn mt-3"></a>
      </div>
    </div>

    <div class="about-info mt-auto position-relative">
      <div class="container position-relative" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-6">
            <h2>{{ __('lang.newAcropolis') }}</h2>
            <p>{{ __('lang.acropolisMessage') }}</p>
          </div>
          <div class="col-lg-3">
            <h3>{{ __('lang.where') }}</h3>
            <p>{{ __('lang.whereMessage') }}</p>
          </div>
          <div class="col-lg-3">
            <h3>{{ __('lang.about') }}</h3>
            <p>{{ __('lang.aboutMessage') }}</p>
          </div>
        </div>
      </div>
    </div>

  </section>

  <!-- Available Events Section with Swiper -->
  <section id="speakers" class="speakers section">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ __('lang.availableEvents') }}<br></h2>
    </div>

    <div class="container">
      <!-- Swiper Wrapper -->
      <div class="swiper-container">
        <div class="swiper-wrapper" id="product-list">
          <!-- Event cards will be inserted here by AJAX -->
        </div>
        
        <!-- Swiper Navigation Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ __('lang.contact') }}</h2>
      <p></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <div class="col-lg-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-geo-alt"></i>
            <h3>{{ __('lang.address') }}</h3>
            <p>India</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-telephone"></i>
            <h3>{{ __('lang.call') }}</h3>
            <p>+1 5589 55488 55</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-envelope"></i>
            <h3>{{ __('lang.email') }}</h3>
            <p>email@example.com</p>
          </div>
        </div>
      </div>

      <div class="row gy-4 mt-1">
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3357.9916166071457!2d74.9014103758691!3d32.686268473701794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391e85bcf9317339%3A0x38c9e3b9fb85f981!2sLadybird%20Web%20Solution%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1727893091873!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" style="border:0; width: 100%; height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="col-lg-6">
          <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="400">
            <div class="row gy-4">
              <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
              </div>

              <div class="col-md-6 ">
                <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
              </div>

              <div class="col-md-12">
                <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
              </div>

              <div class="col-md-12">
                <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
              </div>

              <div class="col-md-12 text-center">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>

                <button type="submit">{{ __('lang.sendMessage') }}</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</main>

@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
  $(document).ready(function() {
    // Fetch Products
    function fetchProducts() {
      $.ajax({
        url: "{{ route('api.view-user-product-list') }}",
        type: "GET",
        dataType: "json",
        success: function(response) {
          if (response.status === false) {
            console.log(response.message);
            return;
          }

          $('#product-list').empty();

          $.each(response, function(index, product) {
            const imageUrl = product.image_url ? `/storage/${product.image_url}` : 'https://media.istockphoto.com/image-placeholder.jpg';
            
            $('#product-list').append(`
              <div class="swiper-slide col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                <div class="member">
                  <img src="${imageUrl}" class="img-fluid" alt="${product.product_name}">
                  <div class="member-info">
                    <div class="member-info-content">
                      <h4><a href="{{ url('events/view_product') }}/${product.id}">${product.product_name}</a></h4>
                      <span>Rs. ${product.product_cost}</span>
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

          // Initialize Swiper after fetching products
          var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
              delay: 2000,
              disableOnInteraction: false,
            },
            slidesPerView: 4,
            spaceBetween: 20,
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
          });

          // Pause Swiper on hover
          $('.swiper-slide').on('mouseenter', function() {
            swiper.autoplay.stop();
          }).on('mouseleave', function() {
            swiper.autoplay.start();
          });
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        }
      });
    }

    // Fetch products on page load
    fetchProducts();
  });
</script>
@endsection
