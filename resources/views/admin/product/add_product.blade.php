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
                        <h1>Add Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                Product Added successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="d-flex justify-content-center align-items-center vh-10">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Product Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tax">Select Tax</label>
                                <select id="tax" name="tax_id" class="form-control">
                                    <option value="">-- Select Tax --</option>
                                </select>
                                <p id="taxError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" id="product_name" name="product_name" class="form-control text-capitalize">
                                <p id="newProductNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="product_cost">Product Cost</label>
                                <input type="text" id="product_cost" name="product_cost" class="form-control text-capitalize">
                                <p id="newProductCostError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="product_image">Product Image</label>
                                <input type="file" id="product_image" name="product_image" class="form-control">
                                <p id="imageError" class="error-message"></p>
                            </div>

                            <!-- New product description field -->
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea id="product_description" name="product_description" class="form-control" rows="3"></textarea>
                                <p id="descriptionError" class="error-message"></p>
                            </div>

                            <button id="add_product" class="btn btn-success float-right">Add Product</button>
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

            // Fetch Taxes on page load
            $.ajax({
                url: '{{ url("/api/view-tax-list") }}',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    response.forEach(function(tax) {
                        $('#tax').append('<option value="' + tax.id + '">' + tax.tax_name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error("Error fetching Taxes: ", xhr.responseText);
                }
            });

            // Handle Product addition
            $('#add_product').on('click', function(e) {
                e.preventDefault();

                $('#newProductNameError').text('');
                $('#newProductCostError').text('');
                $('#taxError').text('');
                $('#imageError').text('');
                $('#descriptionError').text(''); // Reset description error

                var data = new FormData();
                data.append('product_name', $('#product_name').val());
                data.append('product_cost', $('#product_cost').val());
                data.append('tax_id', $('#tax').val());
                data.append('product_description', $('#product_description').val()); // Append product description
                const imageFile = $('#product_image')[0].files[0];
                if (imageFile) {
                    data.append('image', imageFile);
                }

                if (!data.get('tax_id')) {
                    $('#taxError').text('Please select a tax.');
                    return;
                }

                $.ajax({
                    url: '{{ url("/api/add-product") }}',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showFlashMessage();
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view_product') }}";
                        }, 1000);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.product_name) {
                            $('#newProductNameError').text(errors.product_name[0]);
                        } if (errors && errors.product_cost) {
                            $('#newProductCostError').text(errors.product_cost[0]);
                        } else if (errors && errors.tax_id) {
                            $('#taxError').text(errors.tax_id[0]);
                        } else if (errors && errors.image) {
                            $('#imageError').text(errors.image[0]);
                        } else if (errors && errors.product_description) {
                            $('#descriptionError').text(errors.product_description[0]); // Show description error
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
