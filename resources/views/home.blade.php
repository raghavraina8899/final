@extends('layout')

@section('customCss')
  <style>
    #product-list img{
      height: 220px;
      object-fit: cover;
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

    </section><!-- /Hero Section -->

    <!-- Speakers Section -->
    <!-- <section id="speakers" class="speakers section">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Event Speakers<br></h2>

      </div>

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <img src="/usercss/img/speakers/speaker-1.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4><a href="speaker-details.html">Walter White</a></h4>
                  <span>Quas alias incidunt</span>
                </div>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <img src="/usercss/img/speakers/speaker-2.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4><a href="speaker-details.html">Hubert Hirthe</a></h4>
                  <span>Consequuntur odio aut</span>
                </div>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <img src="/usercss/img/speakers/speaker-3.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4><a href="speaker-details.html">Amanda Jepson</a></h4>
                  <span>Fugiat laborum et</span>
                </div>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="member">
              <img src="/usercss/img/speakers/speaker-4.jpg" class="img-fluid" alt="">
              <div class="member-info">
                <div class="member-info-content">
                  <h4><a href="speaker-details.html">William Anderson</a></h4>
                  <span>Debitis iure vero</span>
                </div>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section> -->

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


    <!-- Schedule Section -->
    <!-- <section id="schedule" class="schedule section">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Event Schedule<br></h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>

      <div class="container">

        <ul class="nav nav-tabs" role="tablist" data-aos="fade-up" data-aos-delay="100">
          <li class="nav-item">
            <a class="nav-link active" href="#day-1" role="tab" data-bs-toggle="tab">Day 1</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#day-2" role="tab" data-bs-toggle="tab">Day 2</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#day-3" role="tab" data-bs-toggle="tab">Day 3</a>
          </li>
        </ul>

        <div class="tab-content row justify-content-center" data-aos="fade-up" data-aos-delay="200">

          <h3 class="sub-heading">Voluptatem nulla veniam soluta et corrupti consequatur neque eveniet officia. Eius necessitatibus voluptatem quis labore perspiciatis quia.</h3>

          
          <div role="tabpanel" class="col-lg-9 tab-pane fade show active" id="day-1">

            <div class="row schedule-item">
              <div class="col-md-2"><time>09:30 AM</time></div>
              <div class="col-md-10">
                <h4>Registration</h4>
                <p>Fugit voluptas iusto maiores temporibus autem numquam magnam.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>10:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-1-2.jpg" alt="Brenden Legros">
                </div>
                <h4>Keynote <span>Brenden Legros</span></h4>
                <p>Facere provident incidunt quos voluptas.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>11:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-2-2.jpg" alt="Hubert Hirthe">
                </div>
                <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>12:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-3-2.jpg" alt="Cole Emmerich">
                </div>
                <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>02:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-4-2.jpg" alt="Jack Christiansen">
                </div>
                <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>03:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-5.jpg" alt="Alejandrin Littel">
                </div>
                <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>04:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-6.jpg" alt="Willow Trantow">
                </div>
                <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
              </div>
            </div>

          </div>

          
          <div role="tabpanel" class="col-lg-9  tab-pane fade" id="day-2">

            <div class="row schedule-item">
              <div class="col-md-2"><time>10:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-1-2.jpg" alt="Brenden Legros">
                </div>
                <h4>Libero corrupti explicabo itaque. <span>Brenden Legros</span></h4>
                <p>Facere provident incidunt quos voluptas.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>11:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-2-2.jpg" alt="Hubert Hirthe">
                </div>
                <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>12:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-3-2.jpg" alt="Cole Emmerich">
                </div>
                <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>02:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-4-2.jpg" alt="Jack Christiansen">
                </div>
                <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>03:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-5.jpg" alt="Alejandrin Littel">
                </div>
                <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>04:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-6.jpg" alt="Willow Trantow">
                </div>
                <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
              </div>
            </div>

          </div>

          
          <div role="tabpanel" class="col-lg-9  tab-pane fade" id="day-3">

            <div class="row schedule-item">
              <div class="col-md-2"><time>10:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-2-2.jpg" alt="Hubert Hirthe">
                </div>
                <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>11:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-3-2.jpg" alt="Cole Emmerich">
                </div>
                <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>12:00 AM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-1-2.jpg" alt="Brenden Legros">
                </div>
                <h4>Libero corrupti explicabo itaque. <span>Brenden Legros</span></h4>
                <p>Facere provident incidunt quos voluptas.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>02:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-4-2.jpg" alt="Jack Christiansen">
                </div>
                <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>03:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-5.jpg" alt="Alejandrin Littel">
                </div>
                <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
              </div>
            </div>

            <div class="row schedule-item">
              <div class="col-md-2"><time>04:00 PM</time></div>
              <div class="col-md-10">
                <div class="speaker">
                  <img src="/usercss/img/speakers/speaker-6.jpg" alt="Willow Trantow">
                </div>
                <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
              </div>
            </div>

          </div>

        </div>

      </div>
    </section> -->

    <!-- Venue Section -->
    <!-- <section id="venue" class="venue section">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Event Venue<br></h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>

      <div class="container-fluid" data-aos="fade-up">

        <div class="row g-0">
          <div class="col-lg-6 venue-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0" allowfullscreen=""></iframe>
          </div>

          <div class="col-lg-6 venue-info">
            <div class="row justify-content-center">
              <div class="col-11 col-lg-8 position-relative">
                <h3>Downtown Conference Center, New York</h3>
                <p>Iste nobis eum sapiente sunt enim dolores labore accusantium autem. Cumque beatae ipsam. Est quae sit qui voluptatem corporis velit. Qui maxime accusamus possimus. Consequatur sequi et ea suscipit enim nesciunt quia velit.</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="container-fluid venue-gallery-container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-0">

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-1.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-1.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-2.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-2.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-3.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-3.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-4.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-4.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-5.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-5.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-6.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-6.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-7.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-7.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href="/usercss/img/venue-gallery/venue-gallery-8.jpg" class="glightbox" data-gall="venue-gallery">
                <img src="/usercss/img/venue-gallery/venue-gallery-8.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

        </div>
      </div>

    </section> -->

    <!-- Hotels Section -->
    <!-- <section id="hotels" class="hotels section">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Hotels</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100">
              <div class="card-img">
                <img src="/usercss/img/hotels-1.jpg" alt="" class="img-fluid">
              </div>
              <h3><a href="#" class="stretched-link">Non quibusdam blanditiis</a></h3>
              <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
              <p>0.4 Mile from the Venue</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100">
              <div class="card-img">
                <img src="/usercss/img/hotels-2.jpg" alt="" class="img-fluid">
              </div>
              <h3><a href="#" class="stretched-link">Aspernatur assumenda</a></h3>
              <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
              <p>0.5 Mile from the Venue</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="card h-100">
              <div class="card-img">
                <img src="/usercss/img/hotels-3.jpg" alt="" class="img-fluid">
              </div>
              <h3><a href="#" class="stretched-link">Dolores ut ut voluptatibu</a></h3>
              <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
              <p>0.6 Mile from the Venue</p>
            </div>
          </div>

        </div>

      </div>

    </section> -->

    <!-- Gallery Section -->
    <!-- <section id="gallery" class="gallery section">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Gallery</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "centeredSlides": true,
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 0
                },
                "768": {
                  "slidesPerView": 3,
                  "spaceBetween": 20
                },
                "1200": {
                  "slidesPerView": 5,
                  "spaceBetween": 20
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-1.jpg"><img src="/usercss/img/event-gallery/event-gallery-1.jpg" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-2.jpg"><img src="/usercss/img/event-gallery/event-gallery-2.jpg" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-3.jpg"><img src="/usercss/img/event-gallery/event-gallery-3.jpg" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-4.jpg"><img src="/usercss/img/event-gallery/event-gallery-4.jpg" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-5.jpg"><img src="/usercss/img/event-gallery/event-gallery-5.jpg" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-6.jpg"><img src="/usercss/img/event-gallery/event-gallery-6.jpg" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-7.jpg"><img src="/usercss/img/event-gallery/event-gallery-7.jpg" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="/usercss/img/event-gallery/event-gallery-8.jpg"><img src="/usercss/img/event-gallery/event-gallery-8.jpg" class="img-fluid" alt=""></a></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section> -->

    <!-- Sponsors Section -->
    <!-- <section id="sponsors" class="sponsors section light-background">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Sponsors</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0 clients-wrap">

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-1.png" class="img-fluid" alt="">
          </div>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-2.png" class="img-fluid" alt="">
          </div>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-3.png" class="img-fluid" alt="">
          </div>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-4.png" class="img-fluid" alt="">
          </div>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-5.png" class="img-fluid" alt="">
          </div>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-6.png" class="img-fluid" alt="">
          </div>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-7.png" class="img-fluid" alt="">
          </div>

          <div class="col-xl-3 col-md-4 client-logo">
            <img src="/usercss/img/clients/client-8.png" class="img-fluid" alt="">
          </div>

        </div>

      </div>

    </section> -->

    <!-- Faq Section -->
    <!-- <section id="faq" class="faq section">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                <div class="faq-content">
                  <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Feugiat scelerisque varius morbi enim nunc faucibus?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                <div class="faq-content">
                  <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor?</h3>
                <div class="faq-content">
                  <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                <div class="faq-content">
                  <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed in suscipit sequi. Distinctio ipsam dolore et.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

            </div>

          </div>

        </div>

      </div>

    </section> -->

    <!-- Buy Tickets Section -->
    <!-- <section id="buy-tickets" class="buy-tickets section light-background">

      
      <div class="container section-title" data-aos="fade-up">
        <h2>Buy Tickets<br></h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>

      <div class="container">

        <div class="row gy-4 pricing-item" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <h3>Standard Access</h3>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <h4><sup>$</sup>150<span> / month</span></h4>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <ul>
              <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
              <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
              <li class="na"><i class="bi bi-x"></i> <span>Pharetra massa massa ultricies</span></li>
            </ul>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <div class="text-center"><a href="#" class="buy-btn">Buy Now</a></div>
          </div>
        </div>

        <div class="row gy-4 pricing-item featured mt-4" data-aos="fade-up" data-aos-delay="200">
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <h3>Premium Access<br></h3>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <h4><sup>$</sup>250<span> / month</span></h4>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <ul>
              <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
              <li><i class="bi bi-check"></i> <strong>Nec feugiat nisl pretium</strong></li>
              <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
            </ul>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <div class="text-center"><a href="#" class="buy-btn">Buy Now</a></div>
          </div>
        </div>

        <div class="row gy-4 pricing-item mt-4" data-aos="fade-up" data-aos-delay="300">
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <h3>Pro Access<br></h3>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <h4><sup>$</sup>350<span> / month</span></h4>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <ul>
              <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
              <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
              <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
            </ul>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-center">
            <div class="text-center"><a href="#" class="buy-btn">Buy Now</a></div>
          </div>
        </div>

      </div>

    </section> -->

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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    function fetchProducts() {
        $.ajax({
            url: "{{ route('api.view-product-list') }}", // Ensure this is the correct route
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Assuming response can have status true or false
                if (response.status === false) {
                    console.log(response.message); // Handle case when no products are available
                    return;
                }

                // Clear existing products
                $('#product-list').empty();

                // Loop through products and append to the product list
                $.each(response, function(index, product) {
                    // Use the correct image URL, defaulting to a placeholder if not available
                    const imageUrl = product.image_url ? `/storage/${product.image_url}` : 'https://media.istockphoto.com/id/499517325/photo/a-man-speaking-at-a-business-conference.jpg?s=612x612&w=0&k=20&c=gWTTDs_Hl6AEGOunoQ2LsjrcTJkknf9G8BGqsywyEtE=';
                    
                    $('#product-list').append(`
                        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                            <div class="member">
                                <img src="${imageUrl}" class="img-fluid" alt="${product.product_name}">
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
                console.error(xhr.responseText); // Handle AJAX errors
            }
        });
    }

    // Fetch products on page load
    fetchProducts();
});
</script>

@endsection
