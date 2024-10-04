<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <base href="{{ asset('profile-assets') }}/" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/namari-color.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="/usercss/css/main.css" rel="stylesheet">
    <style>
        /* Preloader styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .form-box {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 1.5rem;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .flash-message {
            border-radius: 0.375rem;
            background-color: #e53e3e;
            color: #ffffff;
            padding: 1rem;
            position: relative;
            margin-bottom: 1rem;
        }

        .close-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #ffffff;
            cursor: pointer;
        }

        .close-button:hover {
            color: #c53030;
        }

        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
            cursor: pointer;
        }

        .password-container {
            position: relative;
        }
    </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top pl-6">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="/" class="logo d-flex align-items-center me-auto">
        <img src="https://www.acropolis.org/wp-content/uploads/2022/07/LogoNA-VSG-e1659015536206.png" alt="">
      </a>
    </div>
  </header>

    <!-- Preloader -->
    <!-- <div id="preloader">
        <div class="la-ball-triangle-path">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div> -->

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Login Here!</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm form-box">
            <!-- Flash Message -->
            <div id="flashMessage" class="flash-message" style="display: none;">
                <span id="flashMessageContent"></span>
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>

            <form id="loginForm" class="space-y-6" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                        address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <p id="emailError" class="error-message"></p> <!-- Error message for email -->
                </div>

                <div class="password-container">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2 relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password pr-6"></span>
                    </div>
                    <p id="passwordError" class="error-message"></p> <!-- Error message for password -->
                </div>

                <div>
                    <button id="signInButton" type="button"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Login</button>
                    <div class="text-sm py-2">
                        <a href="/forgotPassword" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot
                            password?</a>
                    </div>
                    <div>
                        <p class="text-sm py-2 text-gray-500">
                            Not a member?
                            <a href="/register" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Register
                                Here!</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $(window).on('load', function () {
                    $("#status").fadeOut();
                    $("#preloader").delay(350).fadeOut("slow");
                });

                $('#signInButton').click(function () {
                    const email = $("#email").val();
                    const password = $("#password").val();

                    // Clear previous error messages
                    $('#emailError').text('');
                    $('#passwordError').text('');

                    $('#preloader').fadeIn();

                    $.ajax({
                        url: '/api/login',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            email: email,
                            password: password,
                        }),
                        success: function (response) {
                            $('#preloader').fadeOut();
                            if (response.status && response.token) {
                                localStorage.setItem('api_token', response.token);
                                if (response.reset_password_required) {
                                    window.location.href = "{{ route('first') }}";
                                } else {
                                    window.location.href = response.redirect_url; // Use redirect URL from response
                                }
                            } else {
                                showFlashMessage(response.message);
                            }
                        },
                        error: function (xhr) {
                            $('#preloader').fadeOut();
                            // Show validation errors below the fields
                            const errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#emailError').text(errors.email[0]);
                            }
                            if (errors.password) {
                                $('#passwordError').text(errors.password[0]);
                            }
                        }
                    });
                });

                $(".toggle-password").click(function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            });

            function showFlashMessage(message) {
                $('#flashMessageContent').text('Login failed: ' + message);
                $('#flashMessage').fadeIn();

                setTimeout(function () {
                    hideFlashMessage();
                }, 3000); // Auto hide after 3 seconds
            }

            function hideFlashMessage() {
                $('#flashMessage').fadeOut();
            }
        </script>

</body>

</html>
