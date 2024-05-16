<div class="row">
    <div class="col-md-4">
        <!-- Trigger the modal with the image -->

        <div class="card">
            @if (!empty($employee->image) && Storage::disk('public')->exists($employee->image))
                <img src="{{ asset('storage/' . $employee->image) }}" class="card-img-top image-preview" alt="Employee Image" data-bs-toggle="modal" data-bs-target="#imageModal">
                <div class="card-body">
                    <h5 class="card-title">Actions</h5>
                    <div class="card-text">
                        <!-- Button to delete the image -->
                        <button class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Delete</button>
                        <form id="delete-form" action="{{ route('image.delete', ['id' => $employee->id]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            @else
                <img src="{{ asset('default_images/user.png') }}" class="card-img-top image-preview" alt="Default User Image" data-bs-toggle="modal" data-bs-target="#imageModal">
                <div class="card-body">
                    <h5 class="card-title">No Image</h5>
                    <div class="card-text">
                        <form action="{{ route('image.upload', ['id' => $employee->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="imageUpload" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" name="image" id="imageUpload" required>
                                <button type="submit" class="btn btn-success btn-sm mt-2">Add Image</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>


        <style>
            .image-preview {
                border-radius: 2px;
                cursor: pointer;
            }
        </style>



    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">
                        {{ $employee->first_name }}{{ $employee->last_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="@if (!empty($employee->image) && Storage::disk('public')->exists($employee->image)) {{ asset('storage/' . $employee->image) }}@else{{ asset('default_images/user.png') }} @endif"
                        class="img-fluid" alt="{{ asset('default_images/user.png') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <ul class="list-group">
            @if ($employee->deleted_at != null)
                <li class="list-group-item bg-danger">
                    <span class="icon"><i class="bi bi-person-fill"></i></span>
                    <span class="info"><strong>Termination date : </strong>
                        {{ $employee->deleted_at }}</span>
                </li>
            @endif

            <li class="list-group-item">
                <span class="icon"><i class="bi bi-person-fill"></i></span>
                <span class="info"><strong>First Name:</strong>
                    {{ $employee->first_name }}</span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-person-fill"></i></span>
                <span class="info"><strong>Last Name:</strong> {{ $employee->last_name }}</span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-people-fill"></i></span>
                <span class="info"><strong>Nationality:</strong>
                    {{ $employee->nationality }}</span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-card-id"></i></span>
                <span class="info"><strong>National ID:</strong>
                    {{ $employee->national_id }}</span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-gender-{{ strtolower($employee->gender) }}"></i></span>
                <span class="info"><strong>Gender:</strong> {{ $employee->gender }}</span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-calendar3"></i></span>
                <span class="info"><strong>Date of Birth:</strong>
                    {{ $employee->date_of_birth }}</span>
                <span class="age float-end" id="age"
                    style="font-family: 'Courier New', Courier, monospace ; color: #9b9b9b"></span>
            </li>

            <script>
                // Get the date of birth from the server
                var dob = new Date("{{ $employee->date_of_birth }}");

                // Calculate the age
                var ageDiff = Date.now() - dob.getTime();
                var ageDate = new Date(ageDiff);
                var calculatedAge = Math.abs(ageDate.getUTCFullYear() - 1970);

                // Display the age
                document.getElementById("age").innerText = calculatedAge + " years old";
            </script>

            <li class="list-group-item">
                <span class="icon"><i class="bi bi-cash"></i></span>
                <span class="info"><strong>Base Salary:</strong>
                    {{ $employee->position->salary }}</span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-cash"></i></span>
                <span class="info"><strong>Salary:</strong> {{ $employee->salary }}</span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-file-earmark-text"></i></span>
                <span class="info"><strong>Position:</strong>
                    <a
                        href="{{ route('positions.edit', ['position' => $employee->position_id]) }}">{{ $employee->position->name }}</a></span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-calendar-check"></i></span>
                <span class="info"><strong>Start/Created Date:</strong>
                    {{ $employee->created_at }}</span>
                <span class="date-details float-end" id="created-date-details"
                    style="font-family: 'Courier New', Courier, monospace ; color: #9b9b9b"></span>
            </li>
            <li class="list-group-item">
                <span class="icon"><i class="bi bi-calendar-check"></i></span>
                <span class="info"><strong>Last Updated:</strong>
                    {{ $employee->updated_at }}</span>
                <span class="date-details float-end" id="updated-date-details"
                    style="font-family: 'Courier New', Courier, monospace ; color: #9b9b9b"></span>
            </li>

            <script>
                // Function to format date
                function formatDate(dateString, containerId) {
                    var date = new Date(dateString);
                    var day = date.toLocaleString('en', {
                        weekday: 'short'
                    });
                    var month = date.toLocaleString('en', {
                        month: 'short'
                    });
                    var year = date.getFullYear();

                    document.getElementById(containerId).innerText = day + '/' + month + '/' + year;
                }

                // Call the function to format dates
                formatDate("{{ $employee->created_at }}", "created-date-details");
                formatDate("{{ $employee->updated_at }}", "updated-date-details");
            </script>


        </ul>

    </div>
</div>
