<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Namari - Profile Page</title>
    <base href="{{ asset('profile-assets') }}/" />
    <base href="{{ asset('admincss') }}/" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <link rel="shortcut icon" href="images/favicon.ico" title="Favicon"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/namari-color.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
                        <img src="images/logo.png" id="banner-logo" alt="Landing Page"/>
                        <img src="images/logo-2.png" id="navigation-logo" alt="Landing Page"/>
                    </div>

                    <!--Main Navigation-->
                    <nav id="nav-main">
                        <ul>
                            <li><a href="/profile">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="/update">Update</a></li>
                            <li><a href="/logout" onclick="logoutUser()">Logout</a></li>
                        </ul>
                            {{-- <div class="profile-buttons">
                                <button type="button" onclick="logoutUser()" class="button">Logout</button>
                            </div> --}}

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
                    <h1>.</h1>
                    <h1>.</h1>
                    <h1>.</h1>

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


                </div>
            </div>
        </section>
        <!--End of Profile Form Section-->
    </main>
    <!--End Main Content Area-->

    <!--Footer-->
    <footer id="landing-footer" class="clearfix">
        <div class="row clearfix">
            <p id="copyright" class="col-2">Made with love by <a href="https://www.shapingrain.com">ShapingRain</a></p>

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
        // Check for the presence of the token
        const token = localStorage.getItem('api_token');
        if (!token) {
            window.location.href = "/login";
        }

        // Preloader
        $(window).on('load', function() {
            $("#status").fadeOut();
            $("#preloader").delay(350).fadeOut("slow");
        });

        // Profile form submission
        $("#profileForm").on("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: "/api/profile",
                type: "PUT",
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert("Profile updated successfully!");
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error updating profile: " + xhr.responseText);
                }
            });
        });
    });

    function logoutUser() {
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
    }
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
