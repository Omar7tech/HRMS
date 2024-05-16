@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">
            @if ($employee->training == 1)
                Trainee :
            @else
                Employee :
                @endif {{ $employee->first_name }} {{ $employee->last_name }} @if ($employee->training == 1)
                    <a
                        href="{{ route('trainee.edit', ['trainee' => $employee->id]) }}"class="btn btn-outline-primary">edit</a>
                    <a href="{{ $backUrl }}" class="btn btn-outline-dark">Back</a>
                @else
                    <a
                        href="{{ route('employee.edit', ['employee' => $employee->id]) }}"class="btn btn-outline-primary">edit</a>
                    <a href="{{ $backUrl }}" class="btn btn-outline-dark">Back</a>
                @endif
                @if ($employee->isOnVacation())
                    @if ($employee->schedule_id == null)
                        <span class="badge pill text-bg-danger">!Off</span>
                    @else
                        <span class="badge rounded-pill text-bg-danger">Off</span>
                    @endif
                @else
                    @if ($employee->schedule_id == null)
                        <span class="badge rounded-pill text-bg-warning">on</span>
                    @else
                        <span class="badge rounded-pill text-bg-success">on</span>
                    @endif
                @endif
                @if (!$employee->cv)
                    <i class="bi bi-file-earmark-pdf text-danger"></i>
                @endif

        </span>
    </div>
    <div class="mycontent">
        <div class="container mt-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane"
                        aria-selected="true">Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Contact</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#card-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Card</button>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#cv-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">CV</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#schedule-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">schedule</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vacations-tab" data-bs-toggle="tab"
                        data-bs-target="#vacations-tab-pane" type="button" role="tab"
                        aria-controls="vacations-tab-pane" aria-selected="false">Vacations</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger" id="fire-tab" data-bs-toggle="tab"
                        data-bs-target="#fire-tab-pane" type="button" role="tab" aria-controls="fire-tab-pane"
                        aria-selected="false">fire</button>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
                    @include('private.employee.components.profile')
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                    @include('private.employee.components.contact')
                </div>
                <div class="tab-pane fade" id="card-tab-pane" role="tabpanel" aria-labelledby="card-tab">
                    @include('private.employee.components.card')
                </div>
                <div class="tab-pane fade" id="vacations-tab-pane" role="tabpanel" aria-labelledby="vacations-tab">
                    <!-- Content to show employee's vacations -->
                    @include('private.employee.components.vacations')
                </div>
                <div class="tab-pane fade" id="schedule-tab-pane" role="tabpanel" aria-labelledby="schedule-tab">
                    <!-- Content to show employee's schedule -->
                    @include('private.employee.components.schedule')
                </div>
                <div class="tab-pane fade" id="fire-tab-pane" role="tabpanel" aria-labelledby="fire-tab">
                    @include('private.employee.components.fire')
                </div>
                <div class="tab-pane fade" id="cv-tab-pane" role="tabpanel" aria-labelledby="cv-tab">
                    <style>
                        .pdf-container {
                            width: 100%;
                            /* Adjust width as needed */
                            height: 600px;
                            /* Adjust height as needed */
                            border: 1px solid #ddd;
                            /* Add border */
                            border-radius: 8px;
                            /* Add border radius */
                            overflow: auto;
                            /* Add scrollbar if content overflows */
                        }
                    </style>
                    <div class="container mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                @if ($employee->cv && Storage::disk('public')->exists($employee->cv))
                                    <div class="card">
                                        <div class="card-body">
                                            <iframe src="{{ asset('storage/' . $employee->cv) }}"
                                                class="pdf-container w-100" style="height: 500px;"></iframe>
                                        </div>
                                        <div class="card-footer">
                                            <form action="{{ route('cv.delete', $employee->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete CV</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">CV Not Available</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>You can upload a CV using the form below:</p>
                                            <form action="{{ route('cv.upload', $employee->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="cvFile" class="form-label">Upload CV:</label>
                                                    <input accept=".pdf" type="file" id="cvFile"
                                                        name="cvFile" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn btn-success">Upload CV</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

@include('components.private.footer')
