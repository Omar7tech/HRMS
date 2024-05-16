<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <br>
<canvas id="employeeChart" width="400" height="150" style="background: rgb(255, 255, 255)"></canvas>

            <script>
                var ctx = document.getElementById('employeeChart').getContext('2d');

                var employeeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($positionNames) !!},
                        datasets: [{
                                label: 'Employees',
                                data: {!! json_encode($employeeCounts) !!},
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Trainees',
                                data: {!! json_encode($traineeCounts) !!},
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
