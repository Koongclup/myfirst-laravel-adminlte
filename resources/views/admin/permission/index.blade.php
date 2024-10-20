<x-admin>
    @section('title', 'Permissions')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Permissions</h3>
            <div class="card-tools">
                <button class="btn btn-sm btn-primary" id="addPermissionBtn">Add Permission</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="collectionTable" width="100%" cellspacing="">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Create/Edit Permission -->
    <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="permissionForm">
                        <input type="hidden" id="permission_id" name="permission_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('js')
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                var table = $('#collectionTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive : true,
                    ajax: "{{ route('admin.permission.index') }}",
                    columns: [
                        { data: 'name' },
                        { data: 'created_at' },
                        { data: 'action', orderable: false, searchable: false },
                    ]
                });

                // Open modal for adding permission
                $('#addPermissionBtn').click(function() {
                    $('#permissionForm')[0].reset();
                    $('#modalLabel').text("Add Permission");
                    $('#permission_id').val('');
                    $('#saveBtn').text('Save');
                    $('#permissionModal').modal('show');
                });

                // Submit form for Create and Update
                $('#permissionForm').on('submit', function(e) {
                    e.preventDefault();

                    var id = $('#permission_id').val();
                    var url = id ? "{{ url('admin/permission') }}/" + id : "{{ route('admin.permission.store') }}";
                    var type = id ? "PUT" : "POST";

                    $.ajax({
                        url: url,
                        type: type,
                        data: $(this).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success
                            });
                            $('#permissionModal').modal('hide');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: value[0]
                                    });
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An unexpected error occurred. Please try again.'
                                });
                            }
                        }
                    });
                });

                // Edit Permission
                $(document).on('click', '.editPermission', function() {
                    var id = $(this).data('id');

                    $.get("{{ url('admin/permission') }}/" + id, function(data) {
                        $('#modalLabel').text("Edit Permission");
                        $('#permission_id').val(id);
                        $('#name').val(data.name);
                        $('#saveBtn').text('Update');
                        $('#permissionModal').modal('show');
                    }).fail(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch permission data. Please try again.'
                        });
                    });
                });

                // Delete Permission
                $(document).on('click', '.deletePermission', function() {
                    var url = $(this).data('url');

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
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.success
                                    });
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Failed to delete permission. Please try again.'
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
</x-admin>
