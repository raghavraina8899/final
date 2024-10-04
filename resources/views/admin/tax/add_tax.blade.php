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
                        <h1>Add Tax</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Tax</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                Tax Added successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="d-flex justify-content-center align-items-center vh-10">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Tax Details</h3>
                            {{-- <div class="card-tools">
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tax_name">Tax Name</label>
                                <input type="text" id="tax_name" name ="tax_name" class="form-control text-capitalize" value="">
                                <p id="newTaxNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="tax_percentage">Tax Percentage</label>
                                <input type="text" id="tax_percentage" name = "tax_percentage" class="form-control text-uppercase" value="">
                                <p id="newPercentageError" class="error-message"></p>
                            </div>
                            <button id="add_tax" class="btn btn-success float-right">Add Tax</button>
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

            $('#add_tax').on('click', function(e) {
                e.preventDefault();

                $('#newTaxNameError').text('');
                $('#newPercentageError').text('');

                var data = {
                    tax_name: $('#tax_name').val(),
                    tax_percentage: $('#tax_percentage').val(),
                };

                $.ajax({
                    url: '{{ url('/api/add-tax') }}',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        showFlashMessage();
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view_tax') }}";
                        }, 1000);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.tax_name) {
                            $('#newTaxNameError').text(errors.tax_name[0]);
                        }if (errors && errors.tax_percentage) {
                            $('#newPercentageError').text(errors.tax_percentage[0]);
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
