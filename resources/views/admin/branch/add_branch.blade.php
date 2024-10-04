@extends('admin.layout')

@section('customCss')
    <style>
        
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
                        <h1>Add Branch</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Branch</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                Branch Added successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="d-flex justify-content-center align-items-center vh-10">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Branch Details</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="city_id">Select City</label>
                                <select id="city_id" name="city_id" class="form-control">
                                    <option value="">Select a City</option>
                                    <!-- Options will be loaded dynamically via AJAX -->
                                </select>
                                <p id="cityError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="branch_name">Branch Name</label>
                                <input type="text" id="branch_name" name ="branch_name" class="form-control text-capitalize" value="">
                                <p id="newBranchNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="branch_address">Branch Address</label>
                                <input type="text" id="branch_address" name ="branch_address" class="form-control text-capitalize" value="">
                                <p id="newBranchAddressError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="PIN">PIN</label>
                                <input type="text" id="PIN" name = "PIN" class="form-control text-uppercase" value="">
                                <p id="newPINError" class="error-message"></p>
                            </div>
                            <button id="add_branch" class="btn btn-success float-right">Add Branch</button>
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
                url: '{{ url('/api/view-city-list') }}',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    let options = '<option value="">Select a City</option>';
                    response.forEach(city => {
                        options += `<option value="${city.id}">${city.city_name}</option>`;
                    });
                    $('#city_id').html(options);
                },
                error: function(xhr) {
                    $('#cityError').text('Failed to fetch cities.');
                }
            });

            $('#add_branch').on('click', function(e) {
                e.preventDefault();

                $('#newBranchNameError').text('');
                $('#newBranchAddressError').text('');
                $('#newPINError').text('');
                $('#cityError').text('');

                var data = {
                    city_id: $('#city_id').val(),
                    branch_name: $('#branch_name').val(),
                    branch_address: $('#branch_address').val(),
                    PIN: $('#PIN').val(),
                };

                $.ajax({
                    url: '{{ url('/api/add-branch') }}',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        showFlashMessage();
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view_branch') }}";
                        }, 1000);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.city_id) {
                            $('#cityError').text(errors.city_id[0]);
                        }
                        if (errors && errors.branch_name) {
                            $('#newBranchNameError').text(errors.branch_name[0]);
                        }
                        if (errors && errors.branch_address) {
                            $('#newBranchAddressError').text(errors.branch_address[0]);
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
