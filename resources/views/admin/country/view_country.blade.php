@extends('admin.layout')

@section('customCss')
    {{-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}
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
                        <h1>Countries</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Countries List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            {{-- <div id="flashMessage" class="flash-message">
                Country Updated successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Country List</h3>
                        </div>
                        <div class="card-body">
                            <table id="countryTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Country Name</th>
                                        <th>ISO Code</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated via AJAX -->
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bootstrap Modal for Editing Country -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Country</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editCountryForm">
                            <input type="hidden" id="editCountryId">
                            <div class="form-group">
                                <label for="editCountryName">Country Name</label>
                                <input type="text" id="editCountryName" class="form-control">
                                <p id="editCountryNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="editCode">ISO Code</label>
                                <input type="text" id="editCode" class="form-control">
                            </div>
                            <button type="button" id="updateCountry" class="btn btn-success">Update Country</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Deleting Country -->
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
                        Are you sure you want to delete this Country?
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
    <!-- <script src="plugins/datatables/jquery.dataTables.min.js"></script>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('api_token');
            let selectedCountryId = null;

            // Function to fetch the country list and populate the DataTable
            function fetchCountryList() {
                $.ajax({
                    url: '{{ route('api.view-country-list') }}',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(data) {
                        let tableBody = '';
                        $.each(data, function(index, country) {
                            tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${country.country_name}</td>
                                <td>${country.code}</td>
                                <td><a href="#" class="btn btn-primary edit-btn" data-id="${country.id}">Edit</a></td>
                                <td><a href="#" class="btn btn-danger delete-btn" data-id="${country.id}">Delete</a></td>
                            </tr>`;
                        });
                        $('#countryTable tbody').html(tableBody);
                        // $('#countryTable').DataTable({
                        //     "responsive": true,
                        //     "lengthChange": false,
                        //     "autoWidth": false,
                        //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                        // }).buttons().container().appendTo('#countryTable_wrapper .col-md-6:eq(0)');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching country data:', error);
                    }
                });
            }

            // Handle Edit Button Click
            $('#countryTable').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                selectedCountryId = $(this).data('id');
                $.ajax({
                    url: `{{ route('api.view-country', ['id' => '__id__']) }}`.replace('__id__',
                        selectedCountryId),
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(country) {
                        $('#editCountryId').val(country.id);
                        $('#editCountryName').val(country.country_name);
                        $('#editCode').val(country.code);
                        $('#editModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching country details:', error);
                    }
                });
            });

            // Handle Update Country
            $('#updateCountry').on('click', function(e) {
                e.preventDefault();
                $('#editCountryNameError').text('');
                const data = {
                    country_name: $('#editCountryName').val(),
                    code: $('#editCode').val(),
                };

                $.ajax({
                    url: `{{ route('api.update-country', ['id' => '__id__']) }}`.replace('__id__',
                        selectedCountryId),
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        $('#editModal').modal('hide');
                        fetchCountryList();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.country_name) {
                                $('#editCountryNameError').text(errors.country_name[0]);
                            }
                        } else {
                            console.error('Error updating country:', xhr.responseText);
                        }
                    }
                });
            });

            // Handle Delete Button Click
            $('#countryTable').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                selectedCountryId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            // Handle Confirm Delete
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: `{{ route('api.delete-country', ['id' => '__id__']) }}`.replace('__id__',
                        selectedCountryId),
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        fetchCountryList();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting country:', error);
                    }
                });
            });

            // Initial fetch of country list
            fetchCountryList();
        });
    </script>
@endsection
