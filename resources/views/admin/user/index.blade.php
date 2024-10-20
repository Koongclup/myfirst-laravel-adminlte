<x-admin>
    @section('title', 'Users')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Table</h3>

            <div class="card-tools">
                <a data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-primary">Add</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mx-3">
                <div class="col-md-6">
                    <!-- Pie Chart Container -->
                    <div id="pie-chart" style="width:100%; height:300px;"></div>
                </div>
                <div class="col-md-6">
                    <!-- Column Chart Container -->
                    <div id="column-chart" style="width:100%; height:300px;"></div>
                </div>
            </div>

            <br>
            <table class="table table-hover table-striped" id="userTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Background</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="userId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:*</label>
                            <input type="text" class="form-control" name="name" id="userName" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:*</label>
                            <input type="email" class="form-control" name="email" id="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="mode" class="form-label">mode:*</label>
                            <select name="mode" id="userMode" class="form-control" required>
                                <option value="" selected disabled>Select Mode</option>
                                @foreach ($modes as $mode)
                                    <option value="{{ $mode->name }}">{{ $mode->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role:*</label>
                            <select name="role" id="userRole" class="form-control" required>
                                <option value="" selected disabled>Select the role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (leave blank to keep current
                                password):</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="float-right">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="POST"> <!-- Use this ID for AJAX -->
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name:*</label>
                                    <input type="text" class="form-control" name="name" required>
                                    <x-error>name</x-error>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email:*</label>
                                    <input type="email" class="form-control" name="email" required>
                                    <x-error>email</x-error>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password:*</label>
                                    <input type="password" class="form-control" name="password" required>
                                    <x-error>password</x-error>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="role" class="form-label">Role:*</label>
                                    <select name="role" class="form-control" required>
                                        <option value="" selected disabled>Select the role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-error>role</x-error>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="float-right">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <!-- DataTables and Buttons CDN -->

        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(function() {
                var table = $('#userTable').DataTable({
                    "iDisplayLength": 5,
                    "lengthMenu": [
                        [5, 10, 25, 50, 100, -1],
                        [5, 10, 25, 50, 100, "All"]
                    ],
                    dom: '<"row"<"col-sm-3 col-6"l><"col-sm-3 col-6"B> <"col-sm-6 col-12"f>> rt <"row"<"col-sm-6"i><"col-sm-6"p>>',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Excel ',
                        titleAttr: 'Export a Excel',
                        className: 'btn btn-default btn-sm'
                    }, {
                        extend: 'print',
                        text: 'Print',
                        titleAttr: 'Print',
                        className: 'btn btn-default btn-sm'
                    }],
                    
                    ajax: "{{ route('admin.user.data') }}", // Route to fetch data via AJAX
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'mode',
                            name: 'mode'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function(data) {
                                const date = new Date(data);
                                const day = String(date.getDate()).padStart(2, '0');
                                const month = String(date.getMonth() + 1).padStart(2,
                                    '0'); // Months are zero-based
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`; // Return formatted date
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $('#addUserForm').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('admin.user.store') }}",
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            Swal.fire('Success', 'User added successfully!', 'success');
                            $('#exampleModal').modal('hide');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    Swal.fire('Error', value[0], 'error');
                                });
                            } else {
                                Swal.fire('Error', 'Failed to add user.', 'error');
                            }
                        }
                    });
                });

                function showEditModal(userId) {
                    $.ajax({
                        url: "{{ url('admin/users') }}/" + userId + "/edit",
                        type: 'GET',
                        success: function(data) {
                            $('#userId').val(data.id);
                            $('#userName').val(data.name);
                            $('#userEmail').val(data.email);
                            $('#userRole').val(data.role);
                            $('#userMode').val(data.Mode);
                            $('#editUserModal').modal('show');
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to fetch user data.', 'error');
                        }
                    });
                }

                $('#userTable tbody').on('click', '.edit-btn', function() {
                    const userId = $(this).data('id');
                    showEditModal(userId);
                });

                $('#editUserForm').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ url('admin/users') }}/" + $('#userId').val(),
                        type: 'PUT',
                        data: $(this).serialize(),
                        success: function(response) {
                            Swal.fire('Success', 'User updated successfully!', 'success');
                            $('#editUserModal').modal('hide');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to update user.', 'error');
                        }
                    });
                });

                // Delete Permission
                $(document).on('click', '.delete-btn', function(e) {
                    e.preventDefault(); // Prevent form submission

                    const form = $(this).closest('form'); // Get the form containing the delete button
                    const userId = $(this).data('id'); // Get the user ID for the alert

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        </script>
        <script src="https://code.highcharts.com/highcharts.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Function to detect current theme (dark or light)
                function isDarkMode() {
                    return document.body.classList.contains('dark-mode');
                }

                // Set chart background based on the theme
                function getChartBackgroundColor() {
                    return isDarkMode() ? '#343a40' : '#ffffff'; // Dark mode: dark gray, Light mode: white
                }

                // AJAX request to fetch chart data
                $.ajax({
                    url: '/chart-data', // Adjust the URL based on your routing setup
                    method: 'GET',
                    success: function(response) {
                        // Pie Chart for user roles
                        Highcharts.chart('pie-chart', {
                            chart: {
                                type: 'pie',
                                backgroundColor: getChartBackgroundColor()
                            },
                            title: {
                                text: 'User Roles Distribution',
                                style: {
                                    color: isDarkMode() ? '#ffffff' :
                                        '#000000' // Adjust text color based on theme
                                }
                            },
                            series: [{
                                name: 'Users',
                                colorByPoint: true,
                                data: response.roleData
                            }]
                        });

                        // Column Chart for user modes
                        Highcharts.chart('column-chart', {
                            chart: {
                                type: 'column',
                                backgroundColor: getChartBackgroundColor()
                            },
                            title: {
                                text: 'User Modes Usage',
                                style: {
                                    color: isDarkMode() ? '#ffffff' :
                                        '#000000' // Adjust text color based on theme
                                }
                            },
                            xAxis: {
                                categories: response.modeCategories,
                                crosshair: true,
                                labels: {
                                    style: {
                                        color: isDarkMode() ? '#ffffff' :
                                            '#000000' // Adjust xAxis label color based on theme
                                    }
                                }
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Number of Users',
                                    style: {
                                        color: isDarkMode() ? '#ffffff' :
                                            '#000000' // Adjust yAxis title color based on theme
                                    }
                                },
                                labels: {
                                    style: {
                                        color: isDarkMode() ? '#ffffff' :
                                            '#000000' // Adjust yAxis label color based on theme
                                    }
                                }
                            },
                            series: [{
                                name: 'Users',
                                data: response.modeData
                            }]
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching chart data:', error);
                    }
                });
            });
        </script>
    @endsection

</x-admin>
