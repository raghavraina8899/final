@extends('admin.layout')

@section('customCss')
    <style>
        .flash-message {
            border-radius: 0.375rem;
            background-color: #38a169;
            color: #ffffff;
            padding: 1rem;
            position: relative;
            margin-bottom: 1rem;
            display: none;
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

        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
            padding-right: 30px;
        }

        .container {
            padding-top: 50px;
            margin: auto;
        }

        .profile-pic-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
        }

        #profilePic{
            width: 150px;
            height: 150px;
            object-fit: cover;

        }

        #profilePic-ok {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .btn-upload {
            margin-bottom: 0.5rem;
        }

        #removePic {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('lang.profile') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('lang.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('lang.profile') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
            {{ __('lang.profileMessage') }}
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('lang.general') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="profile-pic-container">
                                <label for="profile_picture">{{ __('lang.profile picture') }}</label>
                                <div id="profilePicPreview">
                                    <div id="profilePic-ok">
                                    <img id="profilePic" src="{{ asset('storage/profile_pictures/default.webp') }}" alt="Profile Picture">
                                    </div>
                                </div>
                                <button id="uploadBtn" class="btn btn-primary btn-upload">{{ __('lang.upload') }}</button>
                                <input type="file" id="profile_picture" class="form-control" accept="image/*" style="display: none;">
                                <button id="removePic" class="btn btn-danger">{{ __('lang.remove') }}</button>
                            </div>

                            <div class="form-group">
                                <label for="name">{{ __('lang.name') }}</label>
                                <input type="text" id="name" class="form-control" value="">
                                <p id="newNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('lang.email') }}</label>
                                <input type="text" id="email" class="form-control" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('lang.phone') }}</label>
                                <input type="text" id="phone" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="gender">{{ __('lang.gender') }}</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">{{ __('lang.selectGender') }}</option>
                                    <option value="male">{{ __('lang.male') }}</option>
                                    <option value="female">{{ __('lang.female') }}</option>
                                    <option value="other">{{ __('lang.other') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('lang.address') }}</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <button id="update_profile" class="btn btn-success float-right">{{ __('lang.update profile') }}</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('lang.update password') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="current_password">{{ __('lang.current password') }}</label>
                                <input type="password" id="current_password" class="form-control" placeholder="Enter current password">
                                <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <p id="currentPasswordError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('lang.new password') }}</label>
                                <input type="password" id="password" class="form-control" placeholder="Enter new password">
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <p id="passwordError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">{{ __('lang.confirm password') }}</label>
                                <input type="password" id="confirm_password" class="form-control" placeholder="Confirm new password">
                                <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <p id="confirmPasswordError" class="error-message"></p>
                            </div>
                            <button id="update_password" class="btn btn-success float-right">{{ __('lang.update password') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('customJs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('api_token');

            $.ajax({
                url: '{{ url('/api/dashboard') }}',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    if (response.status) {
                        $('#name').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#phone').val(response.data.phone);
                        $('#gender').val(response.data.gender);
                        $('#address').val(response.data.address);
                        $('#profilePic').attr('src', response.data.profile_picture || '{{ asset('storage/profile_pictures/default.webp') }}');

                        if (response.data.profile_picture) {
                            $('#removePic').show();
                            $('#uploadBtn').text('{{ __('lang.change') }}');
                        } else {
                            $('#removePic').hide();
                            $('#uploadBtn').text('{{ __('lang.upload') }}');
                        }
                    } else {
                        alert('Failed to load user details. Please try again.');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Something went wrong while fetching user details.');
                }
            });

            $('#uploadBtn').on('click', function() {
                $('#profile_picture').click();
            });

            $('#profile_picture').on('change', function() {
                var file = this.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profilePic').attr('src', e.target.result);
                        $('#removePic').show();
                        $('#uploadBtn').text('{{ __('lang.change') }}');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#removePic').on('click', function() {
                $.ajax({
                    url: '{{ url('/api/remove_profile_picture') }}',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#profilePic').attr('src', '{{ asset('storage/profile_pictures/default.webp') }}');
                            $('#removePic').hide();
                            $('#uploadBtn').text('Upload');
                        } else {
                            alert('Failed to remove profile picture. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Something went wrong while removing profile picture.');
                    }
                });
            });

            $('#update_profile').on('click', function(e) {
                e.preventDefault();
                $('#newNameError').text('');

                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('phone', $('#phone').val());
                formData.append('address', $('#address').val());
                formData.append('gender', $('#gender').val());

                if ($('#profile_picture')[0].files[0]) {
                    formData.append('profile_picture', $('#profile_picture')[0].files[0]);
                }

                $.ajax({
                    url: '{{ url('/api/profile_update') }}',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showFlashMessage();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.name) {
                            $('#newNameError').text(errors.name[0]);
                        } else {
                            $('#resetPasswordMessage').text(xhr.responseJSON.message);
                        }
                    }
                });
            });


            $('#update_password').on('click', function(e) {
            e.preventDefault();

            $('#currentPasswordError').text('');
            $('#passwordError').text('');
            $('#confirmPasswordError').text('');

            var currentPassword = $('#current_password').val();
            var newPassword = $('#password').val();
            var confirmPassword = $('#confirm_password').val();

            if (!currentPassword) {
                $('#currentPasswordError').text("Current password is required.");
                return;
            }

            if (!newPassword) {
                $('#passwordError').text("New password is required.");
            }
            if (!confirmPassword) {
                $('#confirmPasswordError').text("Password confirmation is required.");
            }

            if (newPassword && confirmPassword && newPassword !== confirmPassword) {
                $('#confirmPasswordError').text("Passwords do not match.");
                return;
            }

            var data = {
                current_password: currentPassword,
                password: newPassword,
                password_confirmation: confirmPassword
            };

            $.ajax({
                url: '{{ url('/api/password_update') }}',
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(data),
                success: function(response) {
                    showFlashMessage();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        if (errors.current_password) {
                            $('#currentPasswordError').text(errors.current_password[0]);
                        }
                        if (errors.password) {
                            $('#passwordError').text(errors.password[0]);
                        }
                        if (errors.password_confirmation) {
                            $('#confirmPasswordError').text(errors.password_confirmation[0]);
                        }
                    } else {
                        $('#currentPasswordError').text(xhr.responseJSON.message);
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

        function showFlashMessage() {
            $('#flashMessage').fadeIn();
            setTimeout(function() {
                hideFlashMessage();
            }, 5000);
        }

        function hideFlashMessage() {
            $('#flashMessage').fadeOut();
        }
    </script>
@endsection
