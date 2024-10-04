@extends('admin.layout')

@section('customCss')
    <style>
        /* Centering the modal vertically and horizontally */
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh; /* Full height */
        }

        /* Optional: Adding some animation for better user experience */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translateY(-50px);
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }

        /* Additional styling can go here */
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Product List</h3>
                        </div>
                        <div class="card-body">
                            <table id="productTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Product Name</th>
                                        <th>Product Cost</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated via AJAX -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Product Name</th>
                                        <th>Product Cost</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bootstrap Modal for Editing Product -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm" enctype="multipart/form-data">
                            <input type="hidden" id="editProductId">
                            
                            <!-- Display current product image -->
                            <div class="form-group">
                                <label for="currentProductImage">Current Image</label><br>
                                <img id="currentProductImage" src="" alt="Product Image" style="max-width: 100%; height: auto;">
                            </div>
                            
                            <div class="form-group">
                                <label for="editProductName">Product Name</label>
                                <input type="text" id="editProductName" class="form-control">
                                <p id="editProductNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="editProductCost">Product Cost</label>
                                <input type="text" id="editProductCost" class="form-control">
                                <p id="editProductCostError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="editProductDescription">Product Description</label>
                                <textarea id="editProductDescription" class="form-control" rows="2"></textarea>
                                <p id="editProductDescriptionError" class="error-message"></p>
                            </div>

                            <!-- File input for product image -->
                            <div class="form-group">
                                <label for="editProductImage">Upload New Image (optional)</label>
                                <input type="file" id="editProductImage" class="form-control">
                                <p id="editProductImageError" class="error-message"></p>
                            </div>
                            
                            <button type="button" id="updateProduct" class="btn btn-success">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Deleting Product -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('api_token');
            let selectedProductId = null;

            // Function to fetch the Product list and populate the DataTable
            function fetchProductList() {
                $.ajax({
                    url: '{{ route('api.view-product-list') }}',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(data) {
                        let tableBody = '';
                        $.each(data, function(index, product) {
                            tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${product.product_name}</td>
                                <td>${product.product_cost}</td>
                                <td><a href="#" class="btn btn-primary edit-btn" data-id="${product.id}">Edit</a></td>
                                <td><a href="#" class="btn btn-danger delete-btn" data-id="${product.id}">Delete</a></td>
                            </tr>`;
                        });
                        $('#productTable tbody').html(tableBody);
                        $('#productTable').DataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": false,
                            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                        }).buttons().container().appendTo('#productTable_wrapper .col-md-6:eq(0)');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching Product data:', error);
                    }
                });
            }

            // Handle Edit Button Click
            $('#productTable').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                selectedProductId = $(this).data('id');
                $.ajax({
                    url: `{{ route('api.view-product', ['id' => '__id__']) }}`.replace('__id__', selectedProductId),
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(product) {
                        $('#editProductId').val(product.id);
                        $('#editProductName').val(product.product_name);
                        $('#editProductCost').val(product.product_cost);
                        $('#editProductDescription').val(product.product_description); // Set product description
                        
                        const baseUrl = 'http://final.test/';
                        $('#currentProductImage').attr('src', product.image_url ? baseUrl + product.image_url : '/default_image_url.jpg');
                        $('#editModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching Product data:', error);
                    }
                });
            });

            // Handle Update Product
            $('#updateProduct').on('click', function(e) {
                e.preventDefault();
                $('#editProductNameError').text('');
                $('#editProductCostError').text('');
                $('#editProductDescriptionError').text(''); // Reset description error
                $('#editProductImageError').text('');

                const formData = new FormData();
                formData.append('product_name', $('#editProductName').val());
                formData.append('product_cost', $('#editProductCost').val());
                formData.append('product_description', $('#editProductDescription').val()); // Append description

                // Check if an image file is selected and append it
                const imageFile = $('#editProductImage')[0].files[0];
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                $.ajax({
                    url: `{{ route('api.update-product', ['id' => '__id__']) }}`.replace('__id__', selectedProductId),
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                    },
                    data: formData,
                    processData: false, // Important for file uploads
                    contentType: false, // Important for file uploads
                    success: function(response) {
                        $('#editModal').modal('hide');
                        fetchProductList();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.product_name) {
                                $('#editProductNameError').text(errors.product_name[0]);
                            }
                            if (errors.product_cost) {
                                $('#editProductCostError').text(errors.product_cost[0]);
                            }
                            if (errors.product_description) {
                                $('#editProductDescriptionError').text(errors.product_description[0]); // Handle description error
                            }
                            if (errors.image) {
                                $('#editProductImageError').text(errors.image[0]);
                            }
                        } else {
                            console.error('Error updating product:', xhr.responseText);
                        }
                    }
                });
            });

            // Handle Delete Button Click
            $('#productTable').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                selectedProductId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: `{{ route('api.delete-product', ['id' => '__id__']) }}`.replace('__id__', selectedProductId),
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        fetchProductList();
                    },
                    error: function(xhr) {
                        console.error('Error deleting product:', xhr.responseText);
                    }
                });
            });

            // Fetch the Product List on page load
            fetchProductList();
        });
    </script>
@endsection
