<style>
    /* Sticky header style */
    thead th {
        position: sticky;
        top: 0;
        /* Set top to 0 so it sticks to the top of the table scroll area */
        background-color: #000;
        /* Dark background for the header */
        color: white;
        /* Light text for contrast */
        z-index: 2;
        /* Ensure the header is above other content */
    }
</style>


<table class="table table-bordered table-striped table-hover table-sm">
    <thead class="table-dark">
        <th><i class="bi bi-image"></i></th>
        <th>First Name <i class="bi bi-info-circle ms-1 float-end" title="Click on a row to see more details"></i></th>
        <th></i> Last Name</th>
        <th><i class="bi bi-telephone-fill"></i> Phone number</th>
        <th><i class="bi bi-envelope-fill"></i> Email</th>
        <th><i class="bi bi-briefcase-fill"></i> Position <span
                class="float-end text-info">{{ \App\Models\Position::all()->count() }}</span></th>
        <th><i class="bi bi-currency-dollar"></i> Salary</th>
        <th></i> Status</th>
        <th><i class="bi bi-gear-fill"></i> Action</th>

    </thead>
    <tbody>
        @foreach ($data as $employee)
            <tr data-employee-id="{{ $employee->id }}" data-position="{{ $employee->position->name }}"
                @if ($employee->hasUpcomingVacation()) class="table-info" @endif>
                <td>
                    @if ($employee->image && Storage::disk('public')->exists($employee->image))
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-link btn-modal-trigger" data-bs-toggle="modal"
                            data-bs-target="#imageModal{{ $employee->id }}">
                            <img src="{{ asset('storage/' . $employee->image) }}" alt=""
                                style="height: 40px; width: 40px; border-radius: 50%;">
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="imageModal{{ $employee->id }}" tabindex="-1"
                            aria-labelledby="imageModalLabel{{ $employee->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-m">
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
                    @else
                        <!-- Replace the image with a default image -->
                        <img src="{{ asset('default_images/user.png') }}" alt=""
                            style="height: 40px; width: 40px; border-radius: 50%;">
                    @endif
                </td>

                <td><strong>{{ $employee->first_name }}</strong></td>
                <td>{{ $employee->last_name }}</td>
                <td>{{ $employee->phone_number }}</td>
                <td>
                    <a href="mailto:{{ $employee->email }}" class="email-link" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Click to email {{ $employee->email }}">
                        {{ $employee->email }}
                    </a>
                </td>


                <td @if (request()->has('position') && !empty(request()->get('position'))) class="bg-success p-2 text-white" @endif>
                    {{ $employee->position->name }}</td>

                <!-- Other cells -->
                <td>
                    @if ($employee->position->salary < $employee->salary)
                        @if ($employee->salary == $maxSalaries[$employee->position_id])
                            <span class="text-monospace salary-number"
                                style="color: rgb(0, 140, 255)">{{ number_format($employee->salary, 0) }}</span>
                        @else
                            <span class="text-monospace salary-number"
                                style="color: rgb(0, 173, 87)">{{ number_format($employee->salary, 0) }}</span>
                        @endif
                    @else
                        <span class="text-monospace salary-number"
                            style="color: rgb(230, 36, 36)">{{ number_format($employee->salary, 0) }}</span>
                    @endif
                </td>


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

                    <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                        <a href="{{ route('employee.show', ['employee' => $employee->id]) }}"
                            class="btn btn-outline-primary" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('employee.edit', ['employee' => $employee->id]) }}"
                            class="btn btn-outline-dark" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $data->links('vendor.pagination.bootstrap-5') }}
