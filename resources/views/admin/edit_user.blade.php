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
                        <h1>{{ __('lang.updateUser') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('lang.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('lang.update') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div id="flashMessage" class="flash-message">
                <span id="flashMessageText">{{ __('lang.userMessage') }}</span>
                <button class="close-button" onclick="hideFlashMessage()">×</button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('lang.general') }}</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('lang.name') }}</label>
                                <input type="text" id="name" class="form-control" value="">
                                <p id="newNameError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('lang.email') }}</label>
                                <input type="text" id="email" class="form-control" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="role">{{ __('lang.role') }}</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">{{ __('lang.selectRole') }}</option>
                                    <option value="admin">{{ __('lang.admin') }}</option>
                                    <option value="user">{{ __('lang.user') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('lang.phone') }}</label>
                                <input type="text" id="phone" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="gender">{{ __('lang.gender') }}</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">{{ __('lang.gender') }}</option>
                                    <option value="male">{{ __('lang.male') }}</option>
                                    <option value="female">{{ __('lang.female') }}</option>
                                    <option value="other">{{ __('lang.other') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="country">{{ __('lang.country') }}</label>
                                <select class="form-control" id="country" name="country_id" required>
                                    <option value="">{{ __('lang.selectCountry') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newCountryError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="state">{{ __('lang.state') }}</label>
                                <select class="form-control" id="state" name="state_id" required disabled>
                                    <option value="">{{ __('lang.selectState') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newStateError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="city">{{ __('lang.city') }}</label>
                                <select class="form-control" id="city" name="city_id" required disabled>
                                    <option value="">{{ __('lang.selectCity') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newCityError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="branch">{{ __('lang.branch') }}</label>
                                <select class="form-control" id="branch" name="branch_id" required disabled>
                                    <option value="">{{ __('lang.selectBranch') }}</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <p id="newBranchError" class="error-message"></p>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('lang.address') }}</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <button id="update_user" class="btn btn-success float-right">{{ __('lang.updateUser') }}</button>
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

            // Extract user ID from the URL path (e.g., /admin/edit_user/{id})
            const pathArray = window.location.pathname.split('/');
            const userId = pathArray[pathArray.length - 1];

            if (!userId) {
                showFlashMessage('User ID is missing.', 'error');
                return;
            }

            // Fetch countries on page load
            $.ajax({
                url: '{{ url('/api/view-country-list') }}',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    let options = '<option value="">{{ __("lang.selectCountry") }}</option>';
                    $.each(response, function(index, country) {
                        options += `<option value="${country.id}">${country.country_name}</option>`;
                    });
                    $('#country').html(options);
                },
                error: function(xhr) {
                    showFlashMessage('Failed to load countries. ' + xhr.responseText, 'error');
                }
            });

            // Fetch user details and populate fields
            $.ajax({
                url: `{{ url('/api/view_user') }}/${userId}`,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                success: function(response) {
                    if (response) {
                        $('#name').val(response.name || '');
                        $('#email').val(response.email || '');
                        $('#phone').val(response.phone || '');
                        $('#role').val(response.role || '');
                        $('#gender').val(response.gender || '');
                        $('#address').val(response.address || '');
                        
                        // Set the country and trigger change to load states
                        $('#country').val(response.country_id || '').trigger('change');

                        // Ensure state, city, and branch are loaded after country is selected
                        if (response.country_id) {
                            loadStates(response.country_id, response.state_id, response.city_id, response.branch_id);
                        }
                    } else {
                        showFlashMessage('Failed to load user details. Response data is missing or empty.', 'error');
                    }
                },
                error: function(xhr) {
                    showFlashMessage('Error: ' + xhr.responseText, 'error');
                }
            });

            // Function to load states and set selected state
            function loadStates(countryId, selectedStateId = null, selectedCityId = null, selectedBranchId = null) {
                $.ajax({
                    url: '{{ url('/api/view-states-list') }}/' + countryId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        let options = '<option value="">{{ __("lang.selectState") }}</option>';
                        $.each(response, function(index, state) {
                            options += `<option value="${state.id}">${state.state_name}</option>`;
                        });
                        $('#state').html(options).prop('disabled', false);

                        if (selectedStateId) {
                            $('#state').val(selectedStateId).trigger('change');
                            loadCities(selectedStateId, selectedCityId, selectedBranchId);
                        }
                    },
                    error: function(xhr) {
                        showFlashMessage('Failed to load states. ' + xhr.responseText, 'error');
                    }
                });
            }

            // Function to load cities and set selected city
            function loadCities(stateId, selectedCityId = null, selectedBranchId = null) {
                $.ajax({
                    url: '{{ url('/api/view-cities-list') }}/' + stateId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        let options = '<option value="">{{ __("lang.selectCity") }}</option>';
                        $.each(response, function(index, city) {
                            options += `<option value="${city.id}">${city.city_name}</option>`;
                        });
                        $('#city').html(options).prop('disabled', false);

                        if (selectedCityId) {
                            $('#city').val(selectedCityId).trigger('change');
                            loadBranches(selectedCityId, selectedBranchId);
                        }
                    },
                    error: function(xhr) {
                        showFlashMessage('Failed to load cities. ' + xhr.responseText, 'error');
                    }
                });
            }

            // Function to load branches and set selected branch
            function loadBranches(cityId, selectedBranchId = null) {
                $.ajax({
                    url: '{{ url('/api/view-branches-list') }}/' + cityId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        let options = '<option value="">{{ __("lang.selectBranch") }}</option>';
                        $.each(response, function(index, branch) {
                            options += `<option value="${branch.id}">${branch.branch_name}</option>`;
                        });
                        $('#branch').html(options).prop('disabled', false);

                        if (selectedBranchId) {
                            $('#branch').val(selectedBranchId);
                        }
                    },
                    error: function(xhr) {
                        showFlashMessage('Failed to load branches. ' + xhr.responseText, 'error');
                    }
                });
            }

            // Fetch states when country is selected
            $('#country').on('change', function() {
                const countryId = $(this).val();
                if (countryId) {
                    loadStates(countryId);
                } else {
                    resetStateCityBranch();
                }
            });

            // Fetch cities when state is selected
            $('#state').on('change', function() {
                const stateId = $(this).val();
                if (stateId) {
                    loadCities(stateId);
                } else {
                    resetCityBranch();
                }
            });

            // Fetch branches when city is selected
            $('#city').on('change', function() {
                const cityId = $(this).val();
                if (cityId) {
                    loadBranches(cityId);
                } else {
                    resetBranch();
                }
            });

            // Function to show flash message
            function showFlashMessage(message, type) {
                const flashMessage = $('#flashMessage');
                $('#flashMessageText').text(message);
                flashMessage.css('background-color', type === 'error' ? '#e53e3e' : '#38a169');
                flashMessage.show();
            }

            // Function to hide flash message
            function hideFlashMessage() {
                $('#flashMessage').hide();
            }

            // Helper function to reset fields
            function resetStateCityBranch() {
                $('#state').html('<option value="">{{ __("lang.selectState") }}</option>').prop('disabled', true);
                resetCityBranch();
            }

            function resetCityBranch() {
                $('#city').html('<option value="">{{ __("lang.selectCity") }}</option>').prop('disabled', true);
                resetBranch();
            }

            function resetBranch() {
                $('#branch').html('<option value="">{{ __("lang.selectBranch") }}</option>').prop('disabled', true);
            }

            // Update user details
            $('#update_user').on('click', function() {
                const userData = {
                    name: $('#name').val(),
                    role: $('#role').val(),
                    phone: $('#phone').val(),
                    gender: $('#gender').val(),
                    country_id: $('#country').val(),
                    state_id: $('#state').val(),
                    city_id: $('#city').val(),
                    branch_id: $('#branch').val(),
                    address: $('#address').val()
                };

                $.ajax({
                    url: `{{ url('/api/edit-user') }}/${userId}`,
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(userData),
                    success: function(response) {
                        showFlashMessage('{{ __("lang.userUpdateMessage") }}', 'success');
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view_user') }}";
                        }, 1000);
                    },
                    error: function(xhr) {
                        showFlashMessage('Failed to update user. ' + xhr.responseText, 'error');
                    }
                });
            });
        });

    </script>
@endsection
