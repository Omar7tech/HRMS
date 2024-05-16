{{-- Check if the employee is assigned to a schedule --}}
@if ($employee->schedule_id == null)
    <div class="alert alert-warning" role="alert">
        <strong>Note:</strong> This employee does not have a schedule assigned. Please assign one from the list below.
    </div>

    <ol class="list-group list-group-numbered">
        @foreach ($schedules as $schedule)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">
                        <a href="{{ route('schedules.show', ['schedule' => $schedule->id]) }}">{{ $schedule->name }}</a>
                    </div>
                    {{ $schedule->days_of_week }} <br>
                    From: {{ $schedule->start_time }} To: {{ $schedule->end_time }}
                </div>
                <form action="{{ route('employees.assignSchedule', ['id' => $employee->id]) }}" method="post"
                    class="d-flex align-items-center">
                    @csrf
                    <input type="hidden" value="{{ $schedule->id }}" name="id">
                    <button type="submit" class="btn btn-success btn-sm me-2">Assign</button>
                </form>
                <span class="badge bg-primary rounded-pill">{{ $schedule->employees->count() }}</span>
                {{-- Assuming '14' is a placeholder for dynamic data, like slots available --}}
            </li>
        @endforeach
    </ol>
@else
    <style>
        .week-calendar {
            display: flex;
            justify-content: start;
            list-style: none;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        .week-calendar li {
            flex: 1;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            text-align: center;
            margin: 2px;
            font-size: 14px;
        }

        .week-calendar .active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            /* Bootstrap's default danger color */
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            /* Slightly darker for hover effect */
            border-color: #bd2130;
        }

        .card-title {
            color: #007bff;
            /* Theme color for emphasis */
        }
    </style>

    <div class="card">
        <div class="card-header">
            Schedule Information
        </div>
        <div class="card-body">
            <h5 class="card-title">Assigned to: <strong>{{ $employee->schedule->name }}</strong></h5>
            <p class="card-text">
                <strong>Days of Week:</strong> {{ $employee->schedule->days_of_week }}

                <br>
                <strong>Time:</strong> From {{ $employee->schedule->start_time }} to
                {{ $employee->schedule->end_time }}
            </p>
            <form action="{{ route('employees.unassignSchedule', ['id' => $employee->id]) }}" method="post"
                class="mt-3">
                @method('put')
                @csrf
                <button type="submit" class="btn btn-danger">Unassign Schedule</button>
            </form>
        </div>
        <ul class="week-calendar">
            @php
                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $scheduleDays = explode(',', $employee->schedule->days_of_week);
            @endphp
            @foreach ($daysOfWeek as $day)
                <li class="{{ in_array($day, $scheduleDays) ? 'active' : '' }}">{{ $day }}</li>
            @endforeach
        </ul>
    </div>
@endif
