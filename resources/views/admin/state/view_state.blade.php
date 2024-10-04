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
                        <h1>States</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">States List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            {{-- <div id="flashMessage" class="flash-message">
                State Updated successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">State List</h3>
                        </div>
                        <div class="card-body">
                            <table id="stateTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>State Name</th>
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
                                        <th>State Name</th>
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

        <!-- Bootstrap Modal for Editing State -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit State</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editStateForm">
                            <input type="hidden" id="editStateId">
                            <div class="form-group">
                                <label for="editStateName">State Name</label>
                                <input type="text" id="editStateName" class="form-control">
                                <p id="editStateNameError" class="error-message"></p>
                            </div>
                            <button type="button" id="updateState" class="btn btn-success">Update State</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Deleting State -->
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
                        Are you sure you want to delete this State?
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
            let selectedStateId = null;

            // Function to fetch the State list and populate the DataTable
            function fetchStateList() {
                $.ajax({
                    url: '{{ route('api.view-state-list') }}',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(data) {
                        let tableBody = '';
                        $.each(data, function(index, state) {
                            tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${state.state_name}</td>
                                <td><a href="#" class="btn btn-primary edit-btn" data-id="${state.id}">Edit</a></td>
                                <td><a href="#" class="btn btn-danger delete-btn" data-id="${state.id}">Delete</a></td>
                            </tr>`;
                        });
                        $('#stateTable tbody').html(tableBody);
                        $('#stateTable').DataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": false,
                            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                        }).buttons().container().appendTo('#stateTable_wrapper .col-md-6:eq(0)');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching state data:', error);
                    }
                });
            }

            // Handle Edit Button Click
            $('#stateTable').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                selectedStateId = $(this).data('id');
                $.ajax({
                    url: `{{ route('api.view-state', ['id' => '__id__']) }}`.replace('__id__',
                        selectedStateId),
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(state) {
                        $('#editStateId').val(state.id);
                        $('#editStateName').val(state.state_name);
                        $('#editModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching state details:', error);
                    }
                });
            });

            // Handle Update State
            $('#updateState').on('click', function(e) {
                e.preventDefault();
                $('#editStateNameError').text('');
                const data = {
                    state_name: $('#editStateName').val(),
                };

                $.ajax({
                    url: `{{ route('api.update-state', ['id' => '__id__']) }}`.replace('__id__',
                        selectedStateId),
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        $('#editModal').modal('hide');
                        fetchStateList();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.state_name) {
                                $('#editStateNameError').text(errors.State_name[0]);
                            }
                        } else {
                            console.error('Error updating State:', xhr.responseText);
                        }
                    }
                });
            });

            // Handle Delete Button Click
            $('#stateTable').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                selectedStateId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            // Handle Confirm Delete
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: `{{ route('api.delete-state', ['id' => '__id__']) }}`.replace('__id__',
                        selectedStateId),
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        fetchStateList();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting State:', error);
                    }
                });
            });

            // Initial fetch of State list
            fetchStateList();
        });
    </script>
@endsection
