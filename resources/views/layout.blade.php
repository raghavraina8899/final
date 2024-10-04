<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home</title>
  <base href="{{ asset('usercss') }}/" />
  <base href="{{ asset('admincss') }}/" />
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="/usercss/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/usercss/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/usercss/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/usercss/vendor/aos/aos.css" rel="stylesheet">
  <link href="/usercss/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/usercss/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="/usercss/css/main.css" rel="stylesheet">

  <style>
    .navmenu a{
      justify-content: flex-start !important;
    }
  </style>

  @yield('customCss')
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="/" class="logo d-flex align-items-center me-auto">
        <img src="https://www.acropolis.org/wp-content/uploads/2022/07/cropped-MarcaNA_branca-semslogan-semORG-768x308.png" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/">{{ __('lang.home') }}</a></li>
          <li id="login-button">
            <a href="/login" id="login-button">{{ __('lang.login') }}</a>
          </li>
          <li id="register-button">
            <a href="/register" id="register-button">{{ __('lang.register') }}</a>
          </li>
          <li id="my-bookings-button">
            <a href="/my-bookings" id="my-bookings-button">{{ __('lang.myBookings') }}</a>
          </li>
          <li id="logout-button">
            <a href="#" id="logout-button">{{ __('lang.logout') }}</a>
          </li>
          <li class="dropdown">
            <a href="" class="dropdown-toggle" id="language-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('lang.language') }}</a>
            <ul class="dropdown-menu" aria-labelledby="language-dropdown">

              <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN6NjUzMsxiPYELyWrKg17MA4eLo47fkkM2w&s" class="mx-2" alt="English" width="20"> {{ __('lang.english') }}
                </a>
              </li>

              <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'es') }}">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSaUXWjvnVwnkFCY0vlAPhqAV93oOH9SeFbyg&s" class="mx-2" alt="Spanish" width="20"> {{ __('lang.spanish') }}
                </a>
              </li>

              <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'fr') }}">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGSVvNybJkIV3yXBtARrC1z1qJ-Mw2mRjVZQ&s" class="mx-2" alt="French" width="20"> {{ __('lang.french') }}
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'de') }}">
                  <img src="https://www.countryflags.com/wp-content/uploads/germany-flag-png-xl.png" class="mx-2" alt="German" width="20"> {{ __('lang.german') }}
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'cn') }}">
                  <img src="https://cdn.britannica.com/90/7490-050-5D33348F/Flag-China.jpg" class="mx-2" alt="Chinese" width="20"> {{ __('lang.chinese') }}
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('lang.switch', 'hn') }}">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Flag_of_India.svg/1200px-Flag_of_India.svg.png" class="mx-2" alt="Hindi" width="20"> {{ __('lang.hindi') }}
                </a>
              </li>
              
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="cta-btn d-none d-sm-block" href="{{ route('events.all_events') }}">{{ __('lang.buyTickets') }}</a>

    </div>
  </header>

  @yield('content')

  <footer id="footer" class="footer dark-background">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="/" class="logo d-flex align-items-center">
              <span class="sitename">{{ __('lang.newAcropolis') }}</span>
            </a>
            <div class="footer-contact pt-3">
              <p>XYZ</p>
              <p>India</p>
              <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
              <p><strong>Email:</strong> <span>email@example.com</span></p>
            </div>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>{{ __('lang.usefulLinks') }}</h4>
            <ul>
              <li><a href="/">{{ __('lang.home') }}</a></li>
              <li><a href="/">{{ __('lang.about') }}</a></li>
              <li><a href="/events">{{ __('lang.services') }}</a></li>
              
            </ul>
          </div>

          <!-- <div class="col-lg-2 col-md-3 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><a href="#">Web Design</a></li>
              <li><a href="#">Web Development</a></li>
              <li><a href="#">Product Management</a></li>
              <li><a href="#">Marketing</a></li>
              <li><a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Hic solutasetp</h4>
            <ul>
              <li><a href="#">Molestiae accusamus iure</a></li>
              <li><a href="#">Excepturi dignissimos</a></li>
              <li><a href="#">Suscipit distinctio</a></li>
              <li><a href="#">Dilecta</a></li>
              <li><a href="#">Sit quas consectetur</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Nobis illum</h4>
            <ul>
              <li><a href="#">Ipsam</a></li>
              <li><a href="#">Laudantium dolorum</a></li>
              <li><a href="#">Dinera</a></li>
              <li><a href="#">Trodelas</a></li>
              <li><a href="#">Flexo</a></li>
            </ul>
          </div> -->
          <div class="col-lg-2 col-md-3 footer-links">
            <h4>{{ __('lang.usefulLinks') }}</h4>
            <ul>
              <li><a href="/">{{ __('lang.home') }}</a></li>
              <li><a href="/">{{ __('lang.about') }}</a></li>
              <li><a href="/events">{{ __('lang.services') }}</a></li>
              
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>{{ __('lang.usefulLinks') }}</h4>
            <ul>
              <li><a href="/">{{ __('lang.home') }}</a></li>
              <li><a href="/">{{ __('lang.about') }}</a></li>
              <li><a href="/events">{{ __('lang.services') }}</a></li>
              
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>{{ __('lang.usefulLinks') }}</h4>
            <ul>
              <li><a href="/">{{ __('lang.home') }}</a></li>
              <li><a href="/">{{ __('lang.about') }}</a></li>
              <li><a href="/events">{{ __('lang.services') }}</a></li>
              
            </ul>
          </div>
          
        </div>
      </div>
    </div>

    <div class="copyright text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div>
          {{ __('lang.copyright') }}
          </div>
          <div class="credits">
          {{ __('lang.designed') }} <a href="/">{{ __('lang.newAcropolis') }}</a>
          </div>
        </div>
        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
          <a href="https://x.com/?lang=en"><i class="bi bi-twitter-x"></i></a>
          <a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a>
          <a href="https://in.linkedin.com/"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="/usercss/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/usercss/vendor/php-email-form/validate.js"></script>
  <script src="/usercss/vendor/aos/aos.js"></script>
  <script src="/usercss/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/usercss/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="/usercss/js/main.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      const token = localStorage.getItem('api_token'); // Get token from local storage

      if (token) {
        $('#login-button').hide();
        $('#register-button').hide();
        $('#my-bookings-button').show();
        $('#logout-button').show();
      } else {
        $('#login-button').show();
        $('#register-button').show();
        $('#my-bookings-button').hide();
        $('#logout-button').hide();
      }

      $('#logout-button').on('click', function(e) {
        e.preventDefault();
        const token = localStorage.getItem('api_token');
        if (token) {
            $.ajax({
                url: "/api/logout",
                type: "POST",
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    // Clear the token and redirect
                    localStorage.removeItem('api_token');
                    window.location.href = "/";
                },
                error: function(xhr, status, error) {
                    alert("Error logging out: " + xhr.responseText);
                }
            });
        } else {
            window.location.href = "/";
        }
      });
    });
  </script>

  @yield('customJs')
</body>

</html>
