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

        .container {
            padding: 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .vh-100 {
            height: 100vh;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 py-3">
                        <h1>{{ __('lang.add user') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('lang.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('lang.addUser') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
            {{ __('lang.userMessage') }}
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('lang.userDetails') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('lang.name') }}</label>
                                <input type="text" id="name" name="name" class="form-control">
                                <p id="newNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('lang.email') }}</label>
                                <input type="email" id="email" name="email" class="form-control">
                                <p id="newEmailError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="role">{{ __('lang.role') }}</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">{{ __('lang.selectRole') }}</option>
                                    <option value="admin">{{ __('lang.admin') }}</option>
                                    <option value="user">{{ __('lang.user') }}</option>
                                </select>
                                <p id="newRoleError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('lang.phone') }}</label>
                                <input type="text" id="phone" name="phone" class="form-control">
                                <p id="newPhoneError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="gender">{{ __('lang.gender') }}</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">{{ __('lang.selectGender') }}</option>
                                    <option value="male">{{ __('lang.male') }}</option>
                                    <option value="female">{{ __('lang.female') }}</option>
                                    <option value="other">{{ __('lang.other') }}</option>
                                </select>
                                <p id="newGenderError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('lang.address') }}</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                <p id="newAddressError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="country">{{ __('lang.country') }}</label>
                                <select class="form-control" id="country" name="country_id" required>
                                    <option value="">{{ __('lang.selectCountry') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newCountryError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="state">{{ __('lang.state') }}</label>
                                <select class="form-control" id="state" name="state_id" required disabled>
                                    <option value="">{{ __('lang.selectState') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newStateError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="city">{{ __('lang.city') }}</label>
                                <select class="form-control" id="city" name="city_id" required disabled>
                                    <option value="">{{ __('lang.selectCity') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newCityError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="PIN">{{ __('lang.pin') }}</label>
                                <input type="text" id="PIN" name="pin" class="form-control">
                                <p id="newPINError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="branch">{{ __('lang.branch') }}</label>
                                <select class="form-control" id="branch" name="branch_id" required disabled>
                                    <option value="">{{ __('lang.selectBranch') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newBranchError" class="error-message"></p>
                            </div>
                            <button id="add_user" class="btn btn-success float-right">{{ __('lang.addUser') }}</button>
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
                url: '{{ url('/api/view-country-list') }}', 
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    let options = '<option value="">{{ __('lang.selectCountry') }}</option>';
                    $.each(response, function(index, country) {
                        options += `<option value="${country.id}">${country.country_name}</option>`;
                    });
                    $('#country').html(options);
                }
            });

            $('#country').on('change', function() {
                const countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: '{{ url('/api/view-states-list') }}/' + countryId,
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        success: function(response) {
                            let options = '<option value="">{{ __('lang.selectState') }}</option>';
                            $.each(response, function(index, state) {
                                options += `<option value="${state.id}">${state.state_name}</option>`;
                            });
                            $('#state').html(options).prop('disabled', false);
                        }
                    });
                } else {
                    $('#state').html('<option value="">{{ __('lang.selectState') }}</option>').prop('disabled', true);
                    $('#city').html('<option value="">{{ __('lang.selectCity') }}</option>').prop('disabled', true);
                }
            });

            $('#state').on('change', function() {
                const stateId = $(this).val();
                if (stateId) {
                    $.ajax({
                        url: '{{ url('/api/view-cities-list') }}/' + stateId,
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        success: function(response) {
                            let options = '<option value="">{{ __('lang.selectCity') }}</option>';
                            $.each(response, function(index, city) {
                                options += `<option value="${city.id}">${city.city_name}</option>`;
                            });
                            $('#city').html(options).prop('disabled', false);
                        }
                    });
                } else {
                    $('#city').html('<option value="">{{ __('lang.selectCity') }}</option>').prop('disabled', true);
                }
            });

            $('#city').on('change', function() {
                const cityId = $(this).val();
                if (cityId) {
                    $.ajax({
                        url: '{{ url('/api/view-branches-list') }}/' + cityId, 
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        success: function(response) {
                            let options = '<option value="">{{ __('lang.selectBranch') }}</option>';
                            $.each(response, function(index, branch) {
                                options += `<option value="${branch.id}">${branch.branch_name}</option>`;
                            });
                            $('#branch').html(options).prop('disabled', false);
                        }
                    });
                } else {
                    $('#branch').html('<option value="">{{ __('lang.selectBranch') }}</option>').prop('disabled', true);
                }
            });

            $('#add_user').on('click', function() {
                const formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    address: $('#address').val(),
                    role: $('#role').val(),
                    gender: $('#gender').val(),
                    country_id: $('#country').val(),
                    state_id: $('#state').val(),
                    city_id: $('#city').val(),
                    pin: $('#PIN').val(),
                    branch_id: $('#branch').val()
                };

                $.ajax({
                    url: '{{ route('api.add_user') }}', 
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(formData),
                    success: function(response) {
                        $('#flashMessage').show().delay(3000).fadeOut();
                        $('#add_user').prop('disabled', true);
                    },
                    error: function(response) {
                        const errors = response.responseJSON.errors;
                        $('#newNameError').text(errors.name ? errors.name[0] : '');
                        $('#newEmailError').text(errors.email ? errors.email[0] : '');
                        $('#newPhoneError').text(errors.phone ? errors.phone[0] : '');
                        $('#newAddressError').text(errors.address ? errors.address[0] : '');
                        $('#newRoleError').text(errors.role ? errors.role[0] : '');
                        $('#newGenderError').text(errors.gender ? errors.gender[0] : '');
                        $('#newCountryError').text(errors.country_id ? errors.country_id[0] : '');
                        $('#newStateError').text(errors.state_id ? errors.state_id[0] : '');
                        $('#newCityError').text(errors.city_id ? errors.city_id[0] : '');
                        $('#newPINError').text(errors.pin ? errors.pin[0] : '');
                        $('#newBranchError').text(errors.branch_id ? errors.branch_id[0] : '');
                    }
                });
            });
        });

        function hideFlashMessage() {
            $('#flashMessage').hide();
        }
    </script>
@endsection
