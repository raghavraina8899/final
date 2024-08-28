<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <base href="{{ asset('profile-assets') }}/" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="images/favicon.ico" title="Favicon" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/namari-color.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div id="status" class="la-ball-triangle-path">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="page-border" data-wow-duration="0.7s" data-wow-delay="0.2s">
        <div class="top-border wow fadeInDown animated"></div>
        <div class="right-border wow fadeInRight animated"></div>
        <div class="bottom-border wow fadeInUp animated"></div>
        <div class="left-border wow fadeInLeft animated"></div>
    </div>

    <div id="wrapper">

        <header id="banner" class="scrollto clearfix" data-enllax-ratio=".5">
            <div id="header" class="nav-collapse">
                <div class="row clearfix">
                    <div class="col-1">
                        <!--Logo-->
                        <div id="logo">
                            <img src="images/logo.png" id="banner-logo" alt="Landing Page" />
                            <img src="images/logo-2.png" id="navigation-logo" alt="Landing Page" />
                        </div>

                        <!--Main Navigation-->
                        <nav id="nav-main">
                            <ul>
                                <li><a href="/profile">Home</a></li>
                                <li><a href="#about">About</a></li>
                                <li><a href="#gallery">Gallery</a></li>
                                <li><a href="#services">Services</a></li>
                                <li><a href="#testimonials">Testimonials</a></li>
                                <li><a href="#clients">Clients</a></li>
                                {{-- <li><a href="#pricing">Pricing</a></li>
                                <li><a href="javascript:void(0);" onclick="logoutUser()">Logout</a></li> --}}
                            </ul>
                        </nav>

                        <div id="nav-trigger"><span></span></div>
                        <nav id="nav-mobile"></nav>

                    </div>
                </div>
            </div>

            <!--Banner Content-->
            <div id="banner-content" class="row clearfix">
                <div class="col-38">
                    <div class="section-heading">
                        <h1>Profile Page</h1>
                        <h2>Update your profile information here.</h2>
                    </div>
                </div>
            </div>
        </header>

        <!--Main Content Area-->
        <main id="content">
            <!--Profile Form Section-->
            <section id="profile" class="scrollto">
                <div class="row clearfix">
                    <div class="col-3">
                        <div class="section-heading">
                            <h2 class="section-title">Edit Your Profile</h2>
                        </div>
                        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                            @if (auth()->check())
                                <form id="profileForm" action="{{ url('/api/update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Email Field (Read-only) -->
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                        <div class="mt-2">
                                            <input id="email" name="email" type="email"
                                                value="{{ auth()->user()->email }}" readonly
                                                class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 bg-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    <!-- Name Field -->
                                    <div>
                                        <label for="name"
                                            class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                                        <div class="mt-2">
                                            <input id="name" name="name" type="text"
                                                value="{{ old('name', auth()->user()->name) }}" required
                                                class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                                        </div>
                                        @error('name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone Field -->
                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-medium leading-6 text-gray-900">Phone
                                            Number</label>
                                        <div class="mt-2">
                                            <input id="phone" name="phone" type="text"
                                                value="{{ old('phone', auth()->user()->phone) }}" required
                                                class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                                        </div>
                                        @error('phone')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- New Password Field -->
                                    <div>
                                        <label for="new_password"
                                            class="block text-sm font-medium leading-6 text-gray-900">New
                                            Password</label>
                                        <div class="mt-2">
                                            <input id="new_password" name="new_password" type="password" required
                                                class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                                        </div>
                                        @error('new_password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div>
                                        <button type="submit"
                                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update
                                            Profile</button>
                                    </div>
                                </form>
                            @else
                                <p class="text-red-500 text-sm mt-1">You need to be logged in to update your profile.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            <!--End of Profile Form Section-->
        </main>
        <!--End Main Content Area-->

        <!--Footer-->
        <footer id="landing-footer" class="clearfix">
            <div class="row clearfix">
                <p id="copyright" class="col-2">Made with love by <a
                        href="https://www.shapingrain.com">ShapingRain</a></p>

                <!--Social Icons in Footer-->
                <ul class="col-2 social-icons">
                    <li>
                        <a target="_blank" title="Facebook" href="https://www.facebook.com/username">
                            <i class="fa fa-facebook fa-1x"></i><span>Facebook</span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="Google+" href="http://google.com/+username">
                            <i class="fa fa-google-plus fa-1x"></i><span>Google+</span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="Twitter" href="http://www.twitter.com/username">
                            <i class="fa fa-twitter fa-1x"></i><span>Twitter</span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="Instagram" href="http://www.instagram.com/username">
                            <i class="fa fa-instagram fa-1x"></i><span>Instagram</span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="Behance" href="http://www.behance.net">
                            <i class="fa fa-behance fa-1x"></i><span>Behance</span>
                        </a>
                    </li>
                </ul>
                <!--End of Social Icons in Footer-->
            </div>
        </footer>
        <!--End of Footer-->

    </div>

    <script>
        $(document).ready(function() {
            // Get the token from localStorage
            const token = localStorage.getItem('api_token');

            if (!token) {
                alert('kjhg');
                window.location.href = "/login";
            }

            // Profile form submission
            $("#updateForm").on("submit", function(event) {
                event.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '/api/update',
                    type: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('api_token'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        name: $('#name').val(),
                        phone: $('#phone').val(),
                        password: $('#password').val()
                    }),
                    success: function(response) {
                        console.log(response);
                        // Handle success
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });

            });
        });
    </script>


    <script src="js/wow.min.js"></script>
    <script src="js/featherlight.min.js"></script>
    <script src="js/featherlight.gallery.min.js"></script>
    <script src="js/jquery.enllax.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jquery.stickyNavbar.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/images-loaded.min.js"></script>
    <script src="js/lightbox.min.js"></script>
    <script src="js/site.js"></script>

</body>

</html>
