{{-- resources/views/schedules/statistics.blade.php --}}
@include('components.private.header')
@include('components.private.sidebar')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Schedule Statistics</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Summary</h5>
                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item ">Total Employees Across All Schedules:
                            <strong>{{ $totalEmployees }}</strong></li>
                        <li class="list-group-item">Highest Paying Schedule:
                            <strong>{{ $highestPayingSchedule['name'] }}</strong> (Average Salary:
                            <strong>${{ number_format($highestPayingSchedule['averageSalary'], 2) }}</strong>)</li>
                        <li class="list-group-item">Lowest Paying Schedule:
                            <strong>{{ $lowestPayingSchedule['name'] }}</strong> (Average Salary:
                            <strong>${{ number_format($lowestPayingSchedule['averageSalary'], 2) }}</strong>)</li>
                    </ul>
                </div>
            </div>

            <h4 class="mb-4">Schedule Durations</h4>
            <ul class="list-group mb-4">
                @foreach ($schedules as $schedule)
                    @php
                        $startTime = new DateTime($schedule->start_time);
                        $endTime = new DateTime($schedule->end_time);

                        // If the end time is earlier than the start time, assume it's the next day
                        if ($endTime < $startTime) {
                            $endTime->modify('+1 day');
                        }

                        $duration = $startTime->diff($endTime);
                        $hours = $duration->h;
                        if ($duration->days > 0) {
                            $hours += 24 * $duration->days; // Add 24 hours for each full day
                        }
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $schedule->name }}
                        <span>{{ $hours }} hours</span>
                    </li>
                @endforeach
            </ul>

            <div class="alert alert-info" role="alert">
                <strong>Note:</strong> These statistics are dynamically generated based on the data available.
            </div>

            <div class="row bg-white rounded">
                <div class="col-md-6">
                    <canvas id="employeeChart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="salaryChart"></canvas>
                </div>
            </div>
            <div class="row bg-white rounded">
                <div class="col-md-6">
                    <canvas id="positionsChart"></canvas>
                </div>
            </div>

            <script>
                // Employee distribution chart
                const ctx1 = document.getElementById('employeeChart').getContext('2d');
                const employeeChart = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($scheduleStats->pluck('name')) !!},
                        datasets: [{
                            label: '# of Employees',
                            data: {!! json_encode($scheduleStats->pluck('employeeCount')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Average salary chart
                const ctx2 = document.getElementById('salaryChart').getContext('2d');
                const salaryChart = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($scheduleStats->pluck('name')) !!},
                        datasets: [{
                            label: 'Average Salary',
                            data: {!! json_encode($scheduleStats->pluck('averageSalary')) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Positions breakdown chart
                const ctx3 = document.getElementById('positionsChart').getContext('2d');
                const positionsChart = new Chart(ctx3, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($scheduleStats->pluck('positionsCount')->collapse()->keys()) !!},
                        datasets: [{
                            label: 'Positions Distribution',
                            data: {!! json_encode($scheduleStats->pluck('positionsCount')->collapse()->values()) !!},
                            backgroundColor: ['rgba(255, 206, 86, 0.2)', 'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor: ['rgba(255, 206, 86, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });
            </script>
        </div>
    </div>
</section>

@include('components.private.footer')
