@include('components.private.header')
@include('components.private.sidebar')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

{{-- @foreach ($data as $employee)
    <div>
        <p>{{ $employee->first_name }} {{ $employee->last_name }}</p>
        <p>Email: {{ $employee->email }}</p>
        <!-- Add other attributes you want to display -->
    </div>
@endforeach --}}
<style>
    .btn-modal-trigger {
        padding: 0;
        margin: 0;
        border: none;
        background-color: transparent;
        cursor: pointer;
    }
</style>
<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text"> All Trainees </span>
    </div>
    <div class="mycontent">
        <div class="mt-5">
            <div>
                <form action="{{ route('trainee.index') }}" method="GET" class="d-flex float-start">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search"
                        aria-label="Search" style="width: 400px" value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <div class="float-end">
                    {{ $data->appends(request()->input())->links('vendor.pagination.simple-bootstrap-5') }}
                </div>
            </div>
        </div>
        <br>
        <br>



        <table class="table table-responsive table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Training in / Position</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $employee)
                    <tr @if ($employee->isOnVacation()) class="bg-warning" @endif>
                        <td>
                            <button type="button" class="btn btn-link btn-modal-trigger p-0" data-bs-toggle="modal"
                                data-bs-target="#imageModal{{ $employee->id }}">
                                <img src="{{ $employee->image && Storage::disk('public')->exists($employee->image) ? asset('storage/' . $employee->image) : asset('default_images/user.png') }}"
                                    alt="{{ $employee->first_name }}'s Image" class="rounded-circle"
                                    style="height: 40px; width: 40px;">
                            </button>
                            <!-- Modal for displaying the full-size image -->
                            <div class="modal fade" id="imageModal{{ $employee->id }}" tabindex="-1"
                                aria-labelledby="imageModalLabel{{ $employee->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel{{ $employee->id }}">
                                                {{ $employee->first_name }} {{ $employee->last_name }}'s Image
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('storage/' . $employee->image) }}" class="img-fluid"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $employee->first_name }}</td>
                        <td>{{ $employee->last_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->position->name }}</td>
                        <td>{{ $employee->date_of_birth }}</td>
                        <td>
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
                        <i class="fas fa-file-pdf"></i>
                    @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Action buttons">
                                <a href="{{ route('trainee.show', ['trainee' => $employee->id]) }}"
                                    class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('trainee.edit', ['trainee' => $employee->id]) }}"
                                    class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Edit Details">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('onboard-confirm', ['id' => $employee->id]) }}"
                                    class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Onboard Employee">
                                    <i class="bi bi-person-plus-fill"></i>
                                </a>
                                <a href="{{ route('trainee.endTraining.show', ['id' => $employee->id]) }}"
                                    class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="End Training">
                                    <i class="bi bi-flag-fill"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        {{ $data->links('vendor.pagination.bootstrap-5') }}
    </div>
    </div>
</section>


@include('components.private.footer')
