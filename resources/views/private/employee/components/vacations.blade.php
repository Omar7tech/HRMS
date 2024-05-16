@if($employee->vacations->isNotEmpty())
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Vacations</h4>
        </div>
        <ul class="list-group list-group-flush">
            @foreach($employee->vacations as $vacation)
                @php
                    $startDate = \Carbon\Carbon::parse($vacation->start_date);
                    $endDate = \Carbon\Carbon::parse($vacation->end_date);
                    $today = \Carbon\Carbon::today();
                    $status = $today->isBetween($startDate, $endDate) ? 'Active' :
                              ($today->lt($startDate) ? 'Upcoming' : 'Past');
                    $badgeClass = $status === 'Active' ? 'badge bg-success' :
                                  ($status === 'Upcoming' ? 'badge bg-warning text-dark' : 'badge bg-secondary');
                @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fw-bold">Period:</span>
                        {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
                    </div>
                    <span class="{{ $badgeClass }}">{{ $status }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <div class="alert alert-info mt-4" role="alert">
        No vacations recorded.
    </div>
@endif
