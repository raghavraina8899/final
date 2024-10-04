<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <base href="{{ asset('profile-assets') }}/" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/namari-color.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Preloader Styles */
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

        /* Form Box Styles */
        .form-box {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 1.5rem;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        /* Flash Message Styles */
        .flash-message {
            border-radius: 0.375rem;
            background-color: #38a169;
            color: #ffffff;
            padding: 1rem;
            position: relative;
            margin-bottom: 1rem;
            display: none;
        }

        /* Close Button for Flash Message */
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

        /* Error Message Styles */
        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Eye Button for Password Visibility Toggle */
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }

        .container {
            padding-top: 50px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <!-- Preloader content here, e.g., spinner -->
    </div>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Reset Password</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm form-box">
            <div id="flashMessage" class="flash-message">
                Password reset successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>

            <form id="resetPasswordForm" class="space-y-6" method="POST" action="{{ url('/api/reset-password') }}">
                @csrf
                <input type="hidden" id="token" name="token" value="{{ request()->get('token') }}">

                <div class="password-container">
                    <label for="new_password" class="block text-sm font-medium leading-6 text-gray-900">New Password</label>
                    <div class="mt-2 relative">
                        <input id="new_password" name="new_password" type="password" autocomplete="current-password"
                            class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password pr-6"></span>
                    </div>
                    <p id="newPasswordError" class="error-message"></p>
                </div>

                <div class="password-container mt-4">
                    <label for="confirm_password" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                    <div class="mt-2 relative">
                        <input id="confirm_password" name="confirm_password" type="password" autocomplete="current-password"
                            class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password pr-6"></span>
                    </div>
                    <p id="confirmPasswordError" class="error-message"></p>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Reset Password</button>
                </div>
                <p id="resetPasswordMessage" class="error-message"></p>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(window).on('load', function () {
                $("#preloader").fadeOut("slow");
            });

            // Periodically check if the token is still valid
            setInterval(function() {
                var token = $('#token').val();

                $.ajax({
                    url: '{{ url('/api/check-token-validity') }}', // API route for token validation
                    type: 'GET',
                    data: {
                        token: token
                    },
                    success: function (response) {
                        if (!response.status) {
                            // Token is invalid or expired, redirect to 404 page
                            window.location.href = "{{ route('404.page') }}";
                        }
                    }
                });
            }, 30000); // Check every 30 seconds

            $('#resetPasswordForm').on('submit', function (e) {
                e.preventDefault();

                // Clear previous error messages
                $('#newPasswordError').text('');
                $('#confirmPasswordError').text('');
                $('#resetPasswordMessage').text('');

                var newPassword = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();
                var token = $('#token').val();

                var hasError = false; // Flag to check if there's any error

                // Validate New Password
                if (newPassword === "") {
                    $('#newPasswordError').text('New password is required.');
                    hasError = true; // Set the error flag to true
                }

                // Validate Confirm Password
                if (confirmPassword === "") {
                    $('#confirmPasswordError').text('Confirm password is required.');
                    hasError = true; // Set the error flag to true
                }

                // Check if passwords match (only if both fields are filled)
                if (!hasError && newPassword !== confirmPassword) {
                    $('#confirmPasswordError').text('Passwords do not match.');
                    hasError = true; // Set the error flag to true
                }

                // If there are any errors, stop form submission
                if (hasError) {
                    return;
                }

                // Show the preloader if no error
                $('#preloader').fadeIn();

                // Submit the AJAX request to reset the password
                $.ajax({
                    url: '{{ url('/api/reset-password') }}',
                    type: 'POST',
                    data: {
                        new_password: newPassword,
                        token: token
                    },
                    success: function (response) {
                        $('#preloader').fadeOut();
                        showFlashMessage();
                        setTimeout(function () {
                            window.location.href = "/login";
                        }, 3000);
                    },
                    error: function (xhr) {
                        $('#preloader').fadeOut();
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.new_password) {
                            $('#newPasswordError').text(errors.new_password[0]);
                        } else {
                            $('#resetPasswordMessage').text(xhr.responseJSON.message);
                        }

                        // Redirect to 404 page if token is expired
                        if (xhr.status === 400 && xhr.responseJSON.message === 'Invalid or expired reset token.') {
                            window.location.href = "{{ route('404.page') }}";
                        }
                    }
                });
            });

            // Toggle password visibility
            $(".toggle-password").click(function () {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        });

        function showFlashMessage() {
            $("#flashMessage").fadeIn();
            setTimeout(function () {
                $("#flashMessage").fadeOut();
            }, 3000);
        }

        function hideFlashMessage() {
            $("#flashMessage").fadeOut();
        }
    </script>

</body>

</html>
