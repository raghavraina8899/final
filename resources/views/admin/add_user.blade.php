@extends('admin.layout')

@section('customCss')
    <style>

        /* Preloader styles */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .preloader img {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

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
                    <div class="col-sm-6 py-3">
                        <h1>Add User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add User</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                User Added successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="d-flex justify-content-center align-items-center vh-100">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">User Details</h3>
                            <div class="card-tools">
                                {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name ="name" class="form-control" value="">
                                <p id="newNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name = "email" class="form-control" value="">
                                <p id="newEmailError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <p id="newRoleError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="">
                                <p id="newPhoneError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <p id="newGenderError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                <p id="newAddressError" class="error-message"></p>
                            </div>
                            <button id="add_user" class="btn btn-success float-right">Add User</button>
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

            $('#add_user').on('click', function(e) {
                e.preventDefault();

                $('#newNameError').text('');
                $('#newEmailError').text('');
                $('#newRoleError').text('');
                $('#newPhoneError').text('');
                $('#newGenderError').text('');
                $('#newAddressError').text('');

                var data = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    address: $('#address').val(),
                    gender: $('#gender').val(),
                    role: $('#role').val()
                };

                $.ajax({
                    url: '{{ url('/api/add_user') }}',
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
                        }if (errors && errors.email) {
                            $('#newEmailError').text(errors.email[0]);
                        }if (errors && errors.email) {
                            $('#newRoleError').text(errors.role[0]);
                        }if (errors && errors.email) {
                            $('#newPhoneError').text(errors.phone[0]);
                        }if (errors && errors.email) {
                            $('#newGenderError').text(errors.gender[0]);
                        }if (errors && errors.email) {
                            $('#newAddressError').text(errors.address[0]);
                        } else {
                            $('#resetPasswordMessage').text(xhr.responseJSON.message);
                        }
                    }
                });
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
