@include('components.private.header')
@include('components.private.sidebar')
<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">{{ $schedule->name }} staff</span>
    </div>
    <div class="mycontent">

        <div class="container-sm mt-5">
            <h2>{{ $schedule->name }} - Assigned Employees</h2>
            {{ $employees->links('vendor.pagination.simple-bootstrap-4') }}
            @if ($employees->isEmpty())
                <p>No employees are currently assigned to this schedule.</p>
            @else
                <div class="list-group">
                    @foreach ($employees as $employee)
                        @if ($employee->training == 0)
                            <a href="{{ route('employee.show', $employee->id) }}"
                                class="list-group-item list-group-item-action">
                                {{ $employee->first_name }} , {{ $employee->last_name }} -
                                <span class="badge text-bg-primary">Employee</span>
                                <span class="text-primary float-end">More details</span>
                            </a>
                        @else
                            <a href="{{ route('trainee.show', $employee->id) }}"
                                class="list-group-item list-group-item-action">
                                {{ $employee->first_name }} , {{ $employee->last_name }} -
                                <span class="badge text-bg-info">Trainee</span>

                                <span class="text-primary float-end">More details</span>
                            </a>
                        @endif
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="mt-4">
        {{ $employees->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>
</section>

@include('components.private.footer')
