@include('moderator.components.private.header')
@include('moderator.components.private.sidebar')
<style>
    /* Toggle Switch Styles */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .home-section {
        margin-bottom: 500px;
    }
</style>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Moderator Home</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif



            <table class="table caption-top">
                <caption>List of admins</caption>
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Active</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr data-toggle="modal" data-target="#adminModal" data-id="{{ $admin->id }}">
                            <td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="toggle-switch" data-id="{{ $admin->id }}"
                                        {{ $admin->is_active == 1 ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Admin Actions">
                                    <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.delete', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Admin
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('addAdmin') }}" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <input name="first_name" type="text" class="form-control"
                                            placeholder="First name" aria-label="First name">
                                    </div>
                                    <div class="col">
                                        <input name="last_name" type="text" class="form-control"
                                            placeholder="Last name" aria-label="Last name">
                                    </div>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label for="formGroupExampleInput6" class="form-label">Email</label>
                                    <input name="email" type="text" class="form-control"
                                        id="formGroupExampleInput6" placeholder="Example input placeholder">
                                </div>
                                <div class="mb-3 mt-4">
                                    <label for="formGroupExampleInput" class="form-label">Phone Number</label>
                                    <input name="phone_number" type="number" class="form-control"
                                        id="formGroupExampleInput" placeholder="Example input placeholder">
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Username</label>
                                    <input name="username" type="text" class="form-control"
                                        id="formGroupExampleInput2" placeholder="Username here">
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput3" class="form-label">Password</label>
                                    <input name="password" type="password" class="form-control"
                                        id="formGroupExampleInput3" placeholder="Password here">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    document.querySelectorAll('.toggle-switch').forEach(switchElement => {
        switchElement.addEventListener('change', function() {
            const adminId = this.dataset.id;
            const isActive = this.checked;

            fetch(`/moderator/admin/toggle-active/${adminId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        is_active: isActive
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        // Handle error (e.g., revert switch state)
                        this.checked = !isActive;
                        alert('Failed to update status.');
                    }
                })
                .catch(error => {
                    // Handle error (e.g., revert switch state)
                    this.checked = !isActive;
                    alert('An error occurred.');
                });
        });
    });
</script>



@include('moderator.components.private.footer')
