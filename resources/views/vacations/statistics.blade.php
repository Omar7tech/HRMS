@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Vacation Stats</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h4>Most Past Vacations</h4>
                    <p>Name: {{ $mostPastVacations->first_name ?? 'N/A' }} {{ $mostPastVacations->last_name ?? '' }} - Total: {{ $mostPastVacations->total ?? 0 }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Longest Vacation</h4>
                    <p>Name: {{ $longestVacation->first_name ?? 'N/A' }} {{ $longestVacation->last_name ?? '' }} - Days: {{ $longestVacation->duration ?? 0 }}</p>
                </div>

                <hr>
                <div class="col-md-6 bg-white rounded">
                    <canvas id="vacationsPerMonthChart" width="400" height="400"></canvas>
                </div>

                <div class="col-md-6 bg-white rounded">
                    <canvas id="vacationStatusChart" width="400" height="400"></canvas>
                </div>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const vacationsPerMonthData = @json($vacationsPerMonth);
        const vacationStatusData = @json($vacationStatus);

        renderVacationsPerMonth(vacationsPerMonthData);
        renderVacationStatus(vacationStatusData);
    });

    function renderVacationsPerMonth(data) {
        const ctx = document.getElementById('vacationsPerMonthChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => `Month ${item.month}`),
                datasets: [{
                    label: 'Vacations per Month',
                    data: data.map(item => item.count),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
    }

    function renderVacationStatus(data) {
        const ctx = document.getElementById('vacationStatusChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.map(item => item.status),
                datasets: [{
                    label: 'Vacation Status',
                    data: data.map(item => item.count),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    }
</script>

@include('components.private.footer')
