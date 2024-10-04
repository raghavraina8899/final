@extends('admin.layout')

@section('customCss')
    {{-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}
    <style>
        
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh; 
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translateY(-50px);
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }

    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Branch</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Branch List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            {{-- <div id="flashMessage" class="flash-message">
                Branch Updated successfully!
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Branch List</h3>
                        </div>
                        <div class="card-body">
                            <table id="branchTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Branch Name</th>
                                        <th>Branch Address</th>
                                        <th>PIN</th>
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
                                        <th>Branch Name</th>
                                        <th>Branch Address</th>
                                        <th>PIN</th>
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

        <!-- Edit Branch Model -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Branch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editBranchForm">
                            <input type="hidden" id="editBranchId">
                            <div class="form-group">
                                <label for="editBranchName">Branch Name</label>
                                <input type="text" id="editBranchName" class="form-control">
                                <p id="editBranchNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="editBranchAddress">Branch Address</label>
                                <input type="text" id="editBranchAddress" class="form-control">
                                <p id="editBranchAddressError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="editPIN">PIN</label>
                                <input type="text" id="editPIN" class="form-control">
                            </div>
                            <button type="button" id="updateBranch" class="btn btn-success">Update Branch</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Branch Model -->
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
                        Are you sure you want to delete this Branch?
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
            let selectedBranchId = null;

            function fetchBranchList() {
                $.ajax({
                    url: '{{ route('api.view-branch-list') }}',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(data) {
                        let tableBody = '';
                        $.each(data, function(index, branch) {
                            tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${branch.branch_name}</td>
                                <td>${branch.branch_address}</td>
                                <td>${branch.PIN}</td>
                                <td><a href="#" class="btn btn-primary edit-btn" data-id="${branch.id}">Edit</a></td>
                                <td><a href="#" class="btn btn-danger delete-btn" data-id="${branch.id}">Delete</a></td>
                            </tr>`;
                        });
                        $('#branchTable tbody').html(tableBody);
                        $('#branchTable').DataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": false,
                            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                        }).buttons().container().appendTo('#branchTable_wrapper .col-md-6:eq(0)');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching Branch data:', error);
                    }
                });
            }

            $('#branchTable').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                selectedBranchId = $(this).data('id');
                $.ajax({
                    url: `{{ route('api.view-branch', ['id' => '__id__']) }}`.replace('__id__',
                        selectedBranchId),
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(branch) {
                        $('#editBranchId').val(branch.id);
                        $('#editBranchName').val(branch.branch_name);
                        $('#editBranchAddress').val(branch.branch_address);
                        $('#editPIN').val(branch.PIN);
                        $('#editModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching Branch details:', error);
                    }
                });
            });

            $('#updateBranch').on('click', function(e) {
                e.preventDefault();
                $('#editBranchNameError').text('');
                const data = {
                    branch_name: $('#editBranchName').val(),
                    branch_address: $('#editBranchAddress').val(),
                    PIN: $('#editPIN').val(),
                };

                $.ajax({
                    url: `{{ route('api.update-branch', ['id' => '__id__']) }}`.replace('__id__',
                        selectedBranchId),
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        $('#editModal').modal('hide');
                        fetchBranchList();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.branch_name) {
                                $('#editBranchNameError').text(errors.branch_name[0]);
                            }
                            if (errors.branch_address) {
                                $('#editBranchAddressError').text(errors.branch_address[0]);
                            }
                        } else {
                            console.error('Error updating branch:', xhr.responseText);
                        }
                    }
                });
            });

            $('#branchTable').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                selectedBranchId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: `{{ route('api.delete-branch', ['id' => '__id__']) }}`.replace('__id__',
                        selectedBranchId),
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        fetchBranchList();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting Branch:', error);
                    }
                });
            });

            fetchBranchList();
        });
    </script>
@endsection
