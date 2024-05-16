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
            @endif
            {{ $employee->first_name }} {{ $employee->last_name }}
            @if ($employee->training == 1)
                <a <a href="{{ route('trainee.index') }}"class="btn btn-outline-dark">back</a>
            @else
                <a <a href="{{ route('employees.terminated') }}"class="btn btn-outline-dark">back</a>
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

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($employee->cv && Storage::disk('public')->exists($employee->cv))
                                    <iframe src="{{ asset('storage/' . $employee->cv) }}"
                                        class="pdf-container"></iframe>
                                @else
                                    <center>
                                        <h1>There is No PDF !</h1>
                                    </center>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Bootstrap JS -->

            </div>




        </div>
    </div>
    </div>
</section>

@include('components.private.footer')
