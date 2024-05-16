@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Vacations/Take-off</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="d-flex align-items-center">
                <a href="{{ route('vacations.create') }}" class="btn btn-success mb-3 me-2">Add Vacation</a>
                <a href="{{ route('vacations.statistics') }}" class="btn btn-success mb-3 me-2">show stats</a>
                <div class="dropdown mb-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="vacationFilterDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Filter Vacations
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="vacationFilterDropdown">
                        <li><a class="dropdown-item {{ request('upcoming') == 'true' ? 'active' : '' }}"
                                href="{{ route('vacations.index', ['upcoming' => 'true']) }}">Show Upcoming
                                Vacations</a></li>
                        <li><a class="dropdown-item {{ request('ongoing') == 'true' ? 'active' : '' }}"
                                href="{{ route('vacations.index', ['ongoing' => 'true']) }}">Show Ongoing Vacations</a>
                        </li>
                        <li><a class="dropdown-item {{ request('past') == 'true' ? 'active' : '' }}"
                                href="{{ route('vacations.index', ['past' => 'true']) }}">Show Past Vacations</a></li>
                        <li><a class="dropdown-item {{ request('all') == 'true' ? 'active' : '' }}"
                                href="{{ route('vacations.index', ['all' => 'true']) }}">Show All Vacations</a></li>
                        <li><a class="dropdown-item {{ is_null(request('upcoming')) && is_null(request('ongoing')) && is_null(request('past')) && is_null(request('all')) ? 'active' : '' }}"
                                href="{{ route('vacations.index') }}">Show Current and Future Vacations</a></li>
                    </ul>
                </div>
            </div>



            {{ $vacations->appends(request()->except('page'))->links('vendor.pagination.simple-bootstrap-5') }}
            <div class="row">
                @foreach ($vacations as $vacation)
                    @php
                        $daysToStart = \Carbon\Carbon::now()->diffInDays(
                            \Carbon\Carbon::parse($vacation->start_date),
                            false,
                        );
                    @endphp
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card">
                            <div
                                class="card-header
@if ($daysToStart > 0) bg-info
@elseif(\Carbon\Carbon::today()->greaterThan(\Carbon\Carbon::parse($vacation->end_date)))
bg-secondary
@else
bg-success @endif
">
                                Vacation #{{ $vacation->id }} - {{ $vacation->employee->first_name }}
                                {{ $vacation->employee->last_name }}
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Employee Details</h5>
                                <p class="card-text">
                                    Name:
                                    @if ($vacation->employee->training == 0)
                                        <a
                                            href="{{ route('employee.show', ['employee' => $vacation->employee->id]) }}">{{ $vacation->employee->first_name }}
                                            {{ $vacation->employee->last_name }}
                                        </a>
                                    @elseif ($vacation->employee->training == 1)
                                        <a
                                            href="{{ route('trainee.show', ['trainee' => $vacation->employee->id]) }}">{{ $vacation->employee->first_name }}
                                            {{ $vacation->employee->last_name }}
                                        </a>
                                    @endif


                                    <br>
                                    Email: {{ $vacation->employee->email }}
                                </p>
                                <p class="card-text">
                                    <strong>Start Date:</strong>
                                    {{ \Carbon\Carbon::parse($vacation->start_date)->toFormattedDateString() }}
                                    <br>
                                    <strong>End Date:</strong>
                                    {{ \Carbon\Carbon::parse($vacation->end_date)->toFormattedDateString() }}

                                    @if ($daysToStart > 0)
                                        <br><span class="badge bg-warning text-dark">Starts in {{ $daysToStart }}
                                            day(s)</span>
                                    @endif
                                </p>
                                <p class="card-text">
                                    Status:
                                    @if ($daysToStart > 0)
                                        <span class="badge bg-info text-dark">Upcoming</span>
                                    @elseif(\Carbon\Carbon::today()->greaterThan(\Carbon\Carbon::parse($vacation->end_date)))
                                        <span class="badge bg-secondary">Past</span>
                                    @else
                                        <span class="badge bg-success">Ongoing</span>
                                    @endif
                                </p>
                                <!-- Button trigger modal -->
                                @if ($daysToStart > 0)
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $vacation->id }}">Edit</a>
                                @elseif(\Carbon\Carbon::today()->greaterThan(\Carbon\Carbon::parse($vacation->end_date)))
                                @else
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $vacation->id }}">Edit</a>
                                @endif


                                <button class="btn btn-danger"
                                    onclick="event.preventDefault(); document.getElementById('delete-vacation-form-{{ $vacation->id }}').submit();">
                                    Delete
                                </button>
                                <form id="delete-vacation-form-{{ $vacation->id }}"
                                    action="{{ route('vacations.destroy', $vacation) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editModal{{ $vacation->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $vacation->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $vacation->id }}">Edit Vacation End
                                        Date</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('vacations.update', $vacation) }}">
                                    @csrf
                                    @method('PATCH') <!-- Laravel method to specify a PATCH request -->
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="end_date{{ $vacation->id }}" class="form-label">End
                                                Date</label>
                                            <input type="date" class="form-control" id="end_date{{ $vacation->id }}"
                                                name="end_date"
                                                value="{{ $vacation->end_date instanceof \Carbon\Carbon ? $vacation->end_date->format('Y-m-d') : '' }}"
                                                required>


                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $vacations->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    </div>

</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        @if (session('success'))
            successToast.show();
        @endif
    });
</script>

@include('components.private.footer')
