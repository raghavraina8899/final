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
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                User Updated successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" value="">
                                <p id="newNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" class="form-control" value="" >
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <button id="edit_user" class="btn btn-success float-right">Update User</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('customJs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
                    } else {
                        alert('Failed to load user details. Please try again.');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Something went wrong while fetching user details.');
                }
            });

            $('#edit_user').on('click', function(e) {
                e.preventDefault();

                $('#newNameError').text('');
                var data = {
                    name: $('#name').val(),
                    phone: $('#phone').val(),
                    address: $('#address').val(),
                    gender: $('#gender').val(),
                };

                $.ajax({
                    url: '{{ url('/api/edit_user') }}',
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


                $('#passwordError').text('');
                $('#confirmPasswordError').text('');

                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();

                //Check if passwords match
                if (password !== confirmPassword) {
                    $('#confirmPasswordError').text("Passwords do not match.");
                    return;
                }

                var data = {
                    current_password: $('#current_password').val(),
                    password: password,
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
                        if (errors && errors.name) {
                            $('#newNameError').text(errors.name[0]);
                        } else {
                            $('#resetPasswordMessage').text(xhr.responseJSON.message);
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
