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