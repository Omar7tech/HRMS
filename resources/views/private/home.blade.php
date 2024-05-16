@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section bg-dark">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text text-white">Home</span>
    </div>
    <style>
        .container-fluid {
            padding: 0;
            margin: 0;
            width: 100%; /* Adjusted to fill the entire screen */
        }

        .card {
            width: 100%; /* Adjusted to fill the entire screen */
        }

        .home-section{
            height: fit-content;
        }
    </style>
    <div class="container-fluid mt-5">
        <div>
            <h1 class="text-white ms-3 mb-3">Hello, {{ Auth()->user()->first_name }}</h1>
            <div class="">
                <div class="card" style="margin: 0 ; width:auto;" data-bs-theme="dark">
                    <div class="card-body">
                        <canvas id="employeeChart" width="400" height="200"></canvas>
                    </div>
                    <div class="mt-4">
                        <h2 class="ms-4">Position Statistics</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Position</th>
                                    <th scope="col">Total Employees</th>
                                    <th scope="col">Not in Training</th>
                                    <th scope="col">In Training</th>
                                    <th scope="col">Trained</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($positions as $position)
                                <tr>
                                    <td>{{ $position->name }}</td>
                                    <td>{{ $position->all_employees_count }}</td>
                                    <td>{{ $position->employees_count }}</td>
                                    <td>{{ $position->trainees_count }}</td>
                                    <td>{{ $position->trained_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <h2 class="ms-4">Average Age per Position</h2>
                        <div class="card" data-bs-theme="dark">
                            <div class="card-body">
                                <canvas id="averageAgeChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                     <div class="m-5">
                        <h2 class="text-success mb-3">Recently Added Employees</h2>
                        <div class="row">
                            @foreach($lastAddedEmployees as $lemployee)
                            <div class="col-md-4">
                                <div class="card border-success  mb-3">
                                    <div class="card-header"><a href="{{ route("employee.show" , ["employee" => $lemployee->id]) }}">{{ $lemployee->first_name }} {{ $lemployee->last_name }}</a></div>
                                    <div class="card-body">
                                        <p class="card-text">Position: {{ $lemployee->position->name }}</p>
                                        <p class="card-text">Joined: {{ $lemployee->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
<hr>
                    <div class="m-5">
                        <h2 class="mb-3">Top 3 Longest Serving Employees</h2>
                        <div class="row">
                            @foreach($oldestEmployees as $oemployee)
                            <div class="col-md-4">
                                <div class="card text-white bg-dark mb-3">
                                    <div class="card-header"><a href="{{ route("employee.show" , ["employee" => $oemployee->id]) }}">{{ $oemployee->first_name }} {{ $oemployee->last_name }}</a></div>
                                    <div class="card-body">
                                        <p class="card-text">Position: {{ $oemployee->position->name }}</p>
                                        <p class="card-text">Joined: {{ $oemployee->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
<hr>
                    <div class="m-5">
                        <h2 class="mb-3">Top 3 Highest Salary Employees</h2>
                        <div class="row">
                            @foreach($highestSalaryEmployees as $hEmp)
                            <div class="col-md-4">
                                <div class="card text-white bg-dark mb-3">
                                    <div class="card-header"><a href="{{ route("employee.show" , ["employee" => $hEmp->id]) }}">{{ $hEmp->first_name }} {{ $hEmp->last_name }}</a></div>
                                    <div class="card-body">
                                        <p class="card-text">Position: {{ $hEmp->position->name }}</p>
                                        <p class="card-text">Salary: <span class="text-success">${{ number_format($hEmp->salary, 2) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
<hr>
                    <div class="m-5">
                        <h2 class="mb-3">Top 3 Lowest Salary Employees</h2>
                        <div class="row">
                            @foreach($lowestSalaryEmployees as $lowEmp)
                            <div class="col-md-4">
                                <div class="card text-white bg-dark mb-3">
                                    <div class="card-header"><a href="{{ route("employee.show" , ["employee" => $lowEmp->id]) }}">{{ $lowEmp->first_name }} {{ $lowEmp->last_name }}</a></div>
                                    <div class="card-body">
                                        <p class="card-text">Position: {{ $lowEmp->position->name }}</p>
                                        <p class="card-text">Salary: <span class="text-danger">${{ number_format($lowEmp->salary, 2) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('employeeChart').getContext('2d');
    var employeeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Employees', 'Employees', 'In Training', 'Trained', 'Terminated'],
            datasets: [{
                label: '# of Employees',
                data: [{{ $totalEmployees }}, {{ $employee }}, {{ $inTraining }}, {{ $trained }}, {{ $terminated }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Total Employees
                    'rgba(54, 162, 235, 0.2)',  // Employees
                    'rgba(255, 206, 86, 0.2)',  // In Training
                    'rgba(75, 192, 192, 0.2)',  // Trained
                    'rgba(153, 102, 255, 0.2)'  // Terminated
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)', // Total Employees
                    'rgba(54, 162, 235, 1)',  // Employees
                    'rgba(255, 206, 86, 1)',  // In Training
                    'rgba(75, 192, 192, 1)',  // Trained
                    'rgba(153, 102, 255, 1)'  // Terminated
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff' // Y-axis labels color
                    }
                },
                x: {
                    ticks: {
                        color: '#fff' // X-axis labels color
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#fff' // Legend text color
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#fff',
                    borderWidth: 1
                }
            }
        }
    });

    var ctx2 = document.getElementById('averageAgeChart').getContext('2d');
    var averageAgeChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: {!! json_encode($averageAges->keys()) !!},
            datasets: [{
                label: 'Average Age',
                data: {!! json_encode($averageAges->values()) !!},
                backgroundColor: 'rgba(25, 159, 182, 5)',
                borderColor: 'rgba(25, 159, 1, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff' // Y-axis labels color
                    }
                },
                x: {
                    ticks: {
                        color: '#fff' // X-axis labels color
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#fff' // Legend text color
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#fff',
                    borderWidth: 1
                }
            }
        }
    });
</script>
<script>
    var ctx = document.getElementById('employeeChart').getContext('2d');
    var employeeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Employees', 'Employees', 'In Training', 'Trained', 'Terminated'],
            datasets: [{
                label: '# of Employees',
                data: [{{ $totalEmployees }}, {{ $employee }}, {{ $inTraining }}, {{ $trained }}, {{ $terminated }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Total Employees
                    'rgba(54, 162, 235, 0.2)',  // Employees
                    'rgba(255, 206, 86, 0.2)',  // In Training
                    'rgba(75, 192, 192, 0.2)',  // Trained
                    'rgba(153, 102, 255, 0.2)'  // Terminated
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)', // Total Employees
                    'rgba(54, 162, 235, 1)',  // Employees
                    'rgba(255, 206, 86, 1)',  // In Training
                    'rgba(75, 192, 192, 1)',  // Trained
                    'rgba(153, 102, 255, 1)'  // Terminated
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff' // Y-axis labels color
                    }
                },
                x: {
                    ticks: {
                        color: '#fff' // X-axis labels color
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#fff' // Legend text color
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#fff',
                    borderWidth: 1
                }
            }
        }
    });
</script>
@include('components.private.footer')
