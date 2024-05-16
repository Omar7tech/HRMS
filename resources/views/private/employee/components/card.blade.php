
<div class="card border-0 shadow" style="max-width: 450px">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4">
                <img src="@if ($employee->image) {{ asset('storage/' . $employee->image) }} @else {{ asset('default_images/user.png') }} @endif"
                    alt="Employee Image" class="img-fluid rounded-circle"
                    style="width: 150px; height: 150px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <h3 class="mb-3">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                <p class="mb-1"><strong>Role:</strong> {{ $employee->position->name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $employee->email }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $employee->phone_number }}</p>
                <p class="mb-0"><strong>UUID:</strong> {{ $employee->uuid }}</p>
            </div>
        </div>
    </div>
</div>
