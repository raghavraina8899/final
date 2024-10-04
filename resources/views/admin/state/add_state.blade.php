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
            display: none;
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
                        <h1>Add State</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add State</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                State Added successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="d-flex justify-content-center align-items-center vh-10">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">State Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="country">Select Country</label>
                                <select id="country" name="country_id" class="form-control">
                                    <option value="">-- Select Country --</option>
                                </select>
                                <p id="countryError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="state_name">State Name</label>
                                <input type="text" id="state_name" name="state_name" class="form-control text-capitalize">
                                <p id="newStateNameError" class="error-message"></p>
                            </div>
                            <button id="add_state" class="btn btn-success float-right">Add State</button>
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

            // Fetch countries on page load
            $.ajax({
                url: '{{ url("/api/view-country-list") }}',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    response.forEach(function(country) {
                        $('#country').append('<option value="' + country.id + '">' + country.country_name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error("Error fetching countries: ", xhr.responseText);
                }
            });

            // Handle state addition
            $('#add_state').on('click', function(e) {
                e.preventDefault();

                $('#newStateNameError').text('');
                $('#countryError').text('');

                var data = {
                    state_name: $('#state_name').val(),
                    country_id: $('#country').val()
                };

                if (!data.country_id) {
                    $('#countryError').text('Please select a country.');
                    return;
                }

                $.ajax({
                    url: '{{ url("/api/add-state") }}',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        showFlashMessage();
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view_state') }}";
                        }, 1000);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.state_name) {
                            $('#newStateNameError').text(errors.state_name[0]);
                        } else if (errors && errors.country_id) {
                            $('#countryError').text(errors.country_id[0]);
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
