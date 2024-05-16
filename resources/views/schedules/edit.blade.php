@include('components.private.header')
@include('components.private.sidebar')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Edit Schedule</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Important for Laravel to recognize it as an update operation -->
                <div class="mb-3">
                    <label for="scheduleName" class="form-label">Schedule Name</label>
                    <input type="text" class="form-control" id="scheduleName" name="scheduleName"
                        placeholder="Enter schedule name" value="{{ old('scheduleName', $schedule->name) }}" required>
                </div>
                <h2 class="mb-3">Weekday Time Selector</h2>
                <div class="row">
                    <div class="col">
                        <label class="form-label">Select Days</label>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="{{ strtolower($day) }}"
                                    name="days[]" value="{{ $day }}"
                                    {{ in_array($day, old('days', explode(',', $schedule->days_of_week))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ strtolower($day) }}">{{ $day }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="col">
                        <label for="startTime" class="form-label">Start Time</label>
                        <input type="text" class="form-control mb-3 timepicker" id="startTime" name="startTime"
                            value="{{ old('startTime', $schedule->start_time) }}">

                        <label for="endTime" class="form-label">End Time</label>
                        <input type="text" class="form-control mb-3 timepicker" id="endTime" name="endTime"
                            value="{{ old('endTime', $schedule->end_time) }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
        <!-- Toast -->
        <div class="toast" id="validationToast">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Validation Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body bg-white">
                <!-- Error messages will be inserted here -->
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                let errorMessage = `<ul>`;
                @foreach ($errors->all() as $error)
                    errorMessage += `<li>{{ $error }}</li>`;
                @endforeach
                errorMessage += `</ul>`;

                document.querySelector('#validationToast .toast-body').innerHTML = errorMessage;
                var toast = new bootstrap.Toast(document.getElementById('validationToast'));
                toast.show();
            @endif
        });
    </script>
</section>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr(".timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>

@include('components.private.footer')
