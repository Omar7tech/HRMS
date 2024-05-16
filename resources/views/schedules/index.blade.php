@include('components.private.header')
@include('components.private.sidebar')
<style>
    .card-custom {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .card-custom:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    .card-header-custom {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        font-size: 20px;
    }

    .btn-custom {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-custom:hover {
        background-color: #218838;
    }

    .btn-danger-custom {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger-custom:hover {
        background-color: #c82333;
    }
</style>



<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Schedules</span>
    </div>

    <div class="mycontent">

        <div class="container-sm mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="{{ route('schedules.create') }}" class="btn btn-custom">Add Schedule</a>
                        <!-- Show the Statistics button only if there are schedules -->
                        @if ($schedules->isNotEmpty())
                            <a href="{{ route('schedule.statistics') }}" class="btn btn-primary">Statistics</a>
                        @endif
                    </div>
                    @foreach ($schedules as $schedule)
                        <div class="col-md-4 mb-4">
                            <div class="card card-custom">
                                <div class="card-header card-header-custom">
                                    {{ $schedule->name }}
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Schedule Details</h5>
                                    <p class="card-text">Start Time: {{ $schedule->start_time }}</p>
                                    <p class="card-text">End Time: {{ $schedule->end_time }}</p>
                                    <p class="alert alert-light" role="alert">Days:
                                        {{ str_replace(',', ', ', $schedule->days_of_week) }}</p>
                                    <p class="card-text">Days Count: {{ count(explode(',', $schedule->days_of_week)) }}
                                    </p>
                                    <a href="{{ route('schedules.edit', $schedule->id) }}"
                                        class="btn btn-custom">Edit</a>
                                    <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-info">Show</a>

                                    <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger-custom"
                                            onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
                                    </form>
                                    @if (!$schedule->employees->isNotEmpty())
                                        <div class="alert alert-warning mt-2" role="alert">
                                            No employees assigned to this schedule.
                                        </div>
                                    @else
                                        <a href="{{ route('schedule.assigned', ['id' => $schedule->id]) }}"
                                            class="btn btn-primary position-relative">
                                            Assigned
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{ $schedule->employees->count() }}
                                                <span class="visually-hidden">assigned employees</span>
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

</section>

</body>

</html>
@include('components.private.footer')
