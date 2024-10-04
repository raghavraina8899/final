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
                        <h1>Add City</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add City</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                City Added successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="d-flex justify-content-center align-items-center vh-10">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">City Details</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="state_id">Select State</label>
                                <select id="state_id" name="state_id" class="form-control">
                                    <option value="">Select a State</option>
                                    <!-- Options will be loaded dynamically via AJAX -->
                                </select>
                                <p id="stateError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="city_name">City Name</label>
                                <input type="text" id="city_name" name ="city_name" class="form-control text-capitalize" value="">
                                <p id="newCityNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="PIN">PIN</label>
                                <input type="text" id="PIN" name = "PIN" class="form-control text-uppercase" value="">
                                <p id="newPINError" class="error-message"></p>
                            </div>
                            <button id="add_city" class="btn btn-success float-right">Add City</button>
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

            // Fetch states and populate the dropdown
            $.ajax({
                url: '{{ url('/api/view-state-list') }}',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    let options = '<option value="">Select a State</option>';
                    response.forEach(state => {
                        options += `<option value="${state.id}">${state.state_name}</option>`;
                    });
                    $('#state_id').html(options);
                },
                error: function(xhr) {
                    $('#stateError').text('Failed to fetch states.');
                }
            });

            $('#add_city').on('click', function(e) {
                e.preventDefault();

                $('#newCityNameError').text('');
                $('#newPINError').text('');
                $('#stateError').text('');

                var data = {
                    state_id: $('#state_id').val(),
                    city_name: $('#city_name').val(),
                    PIN: $('#PIN').val(),
                };

                $.ajax({
                    url: '{{ url('/api/add-city') }}',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        showFlashMessage();
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view_city') }}";
                        }, 1000);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.state_id) {
                            $('#stateError').text(errors.state_id[0]);
                        }
                        if (errors && errors.city_name) {
                            $('#newCityNameError').text(errors.city_name[0]);
                        }
                        if (errors && errors.PIN) {
                            $('#newPINError').text(errors.PIN[0]);
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
