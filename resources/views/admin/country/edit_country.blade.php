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
                        <h1>Update Country</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="">Countries</a></li>
                            <li class="breadcrumb-item active">Update</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                Country Updated successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>
                        </div>
                        <div class="card-body">
                            <form id="editCountryForm">
                                <input type="hidden" id="countryId" value="{{ $country->id }}">
                                <div class="form-group">
                                    <label for="country_name">Country Name</label>
                                    <input type="text" id="country_name" class="form-control" value="{{ $country->country_name }}">
                                    <p id="newCountryNameError" class="error-message"></p>
                                </div>
                                <div class="form-group">
                                    <label for="code">ISO Code</label>
                                    <input type="text" id="code" class="form-control" value="{{ $country->code }}">
                                </div>
                                <button type="button" id="edit_country" class="btn btn-success float-right">Update Country</button>
                            </form>
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
            const countryId = $('#countryId').val();

            $('#edit_country').on('click', function(e) {
                e.preventDefault();

                $('#newCountryNameError').text('');
                const data = {
                    country_name: $('#country_name').val(),
                    code: $('#code').val(),
                };

                $.ajax({
                    url: `{{ route('api.update-country', ['id' => '__id__']) }}`.replace('__id__', countryId),
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        showFlashMessage();
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view_country') }}";
                        }, 2000);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors && errors.country_name) {
                            $('#newCountryNameError').text(errors.country_name[0]);
                        }
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
        });
    </script>
@endsection
