@extends('admin.layout')

@section('customCss')
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('lang.users') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('lang.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('lang.usersList') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('lang.usersList') }}</h3>
                            </div>
                            <div class="card-body">
                                <table id="usersTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('lang.s.no.') }}</th>
                                            <th>{{ __('lang.name') }}</th>
                                            <th>{{ __('lang.email') }}</th>
                                            <th>{{ __('lang.phone') }}</th>
                                            <th>{{ __('lang.role') }}</th>
                                            <th>{{ __('lang.gender') }}</th>
                                            <th>{{ __('lang.edit') }}</th>
                                            <th>{{ __('lang.delete') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be populated via AJAX -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>{{ __('lang.s.no.') }}</th>
                                            <th>{{ __('lang.name') }}</th>
                                            <th>{{ __('lang.email') }}</th>
                                            <th>{{ __('lang.phone') }}</th>
                                            <th>{{ __('lang.role') }}</th>
                                            <th>{{ __('lang.gender') }}</th>
                                            <th>{{ __('lang.edit') }}</th>
                                            <th>{{ __('lang.delete') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Bootstrap Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('lang.confirmDelete') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                {{ __('lang.deleteMessage') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                    <button type="button" id="confirmDelete" class="btn btn-danger">{{ __('lang.delete') }}</button>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('api_token');
            let deleteId = null;

            function fetchUsers() {
                $.ajax({
                    url: '{{ route('api.view_users') }}',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function(data) {
                        let tableBody = '';
                        $.each(data, function(index, user) {
                            tableBody += `<tr>
                                <td>${index + 1}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone}</td>
                                <td>${user.role}</td>
                                <td>${user.gender}</td>
                                <td><a href="{{ url('admin/edit_user') }}/${user.id}" class="btn btn-primary">{{ __('lang.edit') }}</a></td>

                                <td><a href="#" class="btn btn-danger delete-btn" data-id="${user.id}">{{ __('lang.delete') }}</a></td>
                            </tr>`;
                        });
                        $('#usersTable tbody').html(tableBody);
                        $('#usersTable').DataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": false,
                            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                        }).buttons().container().appendTo('#usersTable_wrapper .col-md-6:eq(0)');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching user data:', error);
                    }
                });
            }

            // Handle Delete Button Click
            $('#usersTable').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                deleteId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDelete').click(function() {
                $.ajax({
                    url: `{{ route('api.delete_user', '') }}/${deleteId}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    success: function() {
                        $('#deleteModal').modal('hide');
                        fetchUsers(); // Refresh the user list after deletion
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting user:', error);
                    }
                });
            });

            fetchUsers(); // Fetch user data when the page loads
        });
    </script>
@endsection
