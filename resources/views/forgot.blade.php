<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <base href="{{ asset('profile-assets') }}/" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/namari-color.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
            /* Hidden by default */
            align-items: center;
            justify-content: center;
            z-index: 9999;
            /* Ensure it's on top of other content */
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
            border: 1px solid #e5e7eb; /* Light gray border */
            border-radius: 0.375rem; /* Rounded corners */
            padding: 1.5rem; /* Padding inside the box */
            background-color: #ffffff; /* White background */

            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4); /* Light shadow */
        }

        .flash-message {
            border-radius: 0.375rem;
            background-color: #38a169;
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
            color: #e53e3e;
        }

        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }


    </style>
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="la-ball-triangle-path">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Reset Here!</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm form-box">
            <div id="flashMessage" class="flash-message" style="display: none;">
                Check Email to Reset Password!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <form class="space-y-6" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <p id="emailError" class="error-message"></p> <!-- Error message for email -->
                </div>

                <div>
                    <button id="ResetButton" type="button"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Send Mail</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            $(window).on('load', function() {
                $("#status").fadeOut();
                $("#preloader").delay(350).fadeOut("slow");
            });

            $('#ResetButton').click(function() {
                const email = $("#email").val();

                // Clear previous error messages
                $('#emailError').text('');

                // Show the preloader
                $('#preloader').fadeIn();

                $.ajax({
                    url: '/api/forgotPassword', // Update this URL
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: email,
                    }),
                    success: function(response) {
                        $('#preloader').fadeOut(); // Hide the preloader
                        showFlashMessage();
                        setTimeout(function() {
                            window.location.href = "/login";
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        $('#preloader').fadeOut(); // Hide the preloader
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors && response.errors.email) {
                            $('#emailError').text(response.errors.email[0]);
                        } else {
                            $('#emailError').text('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });

        function showFlashMessage() {
            $('#flashMessage').fadeIn();

            setTimeout(function() {
                hideFlashMessage();
            }, 2000); // Auto hide after 3 seconds
        }

        function hideFlashMessage() {
            $('#flashMessage').fadeOut();
        }
    </script>
</body>

</html>
