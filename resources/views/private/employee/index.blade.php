@include('components.private.header')
@include('components.private.sidebar')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

{{-- @foreach ($data as $employee)
    <div>
        <p>{{ $employee->first_name }} {{ $employee->last_name }}</p>
        <p>Email: {{ $employee->email }}</p>
        <!-- Add other attributes you want to display -->
    </div>
@endforeach --}}
<style>
    /* Ensure the table uses the full area in fullscreen */
    #tableContainer:-webkit-full-screen,
    #tableContainer:-moz-full-screen,
    #tableContainer:fullscreen {
        width: 100%;
        height: 100%;
    }

    .email-link {
        color: inherit;
        /* Makes the color the same as the surrounding text */
        text-decoration: none;
        /* Removes underline */
        cursor: pointer;
        /* Changes the cursor to indicate it's clickable */
    }

    .email-link:hover,
    .email-link:focus {
        text-decoration: underline;
        /* Adds underline on hover for emphasis */
        color: #0056b3;
        /* Optional: changes color on hover */
    }

    .btn-modal-trigger {
        padding: 0;
        margin: 0;
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    .table-hover tbody tr td:nth-child(2) {
        cursor: pointer;
    }


    .salary-number {
        font-weight: bold;
        /* Makes the number bold */
        color: #333;
        /* Sets a dark gray color for better contrast */
    }



    /* Optional: Custom styles for resize handles */
    .ui-resizable-handle {
        background-color: #272727;
        width: 10px;
        height: 100%;
        right: -5px;
        top: 0;
        cursor: col-resize;
    }

    th {
        position: relative;
        /* Necessary to contain the resize handle */
    }

    #customContextMenu {
        border: 1px solid #ccc;
        background-color: white;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        width: 150px;
        cursor: pointer;
    }
</style>
<div id="customContextMenu" style="display: none; position: absolute; z-index: 1000;" class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">View Details</li>
        <li class="list-group-item">Edit</li>
    </ul>
</div>

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text"> All Employees </span>
    </div>
    <div class="position-absolute top-0 end-0 m-3 d-flex">
        <button id="fullscreenBtn" class="btn btn-secondary me-1">
            <i class="bi bi-fullscreen" id="fullscreenIcon"></i>
        </button>

        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#infoModal"
            data-bs-placement="left" title="Help Information">
            <i class="bi bi-info-circle"></i>
        </button>
    </div>




    <!-- Modal -->
    <div class="modal fade modal-xl" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Employee Table user manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="badge pill text-bg-danger">!Off</span>
                            The employee is currently on vacation and does not have a scheduled return.
                        </li>
                        <li class="list-group-item">
                            <span class="badge rounded-pill text-bg-danger">Off</span>
                            The employee is on leave of absence.
                        </li>
                        <li class="list-group-item">
                            <span class="badge rounded-pill text-bg-warning">On</span>
                            The employee is currently working but is unscheduled.
                        </li>
                        <li class="list-group-item">
                            <span class="badge rounded-pill text-bg-success">On</span>
                            The employee is actively engaged and present.
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-file-pdf"></i>
                            Indicates that the employee's curriculum vitae (CV) is not available.
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-info-circle ms-1" title="Click on a row to see more details"></i>
                            Click on an employee's first name to view detailed information.
                        </li>
                        <li class="list-group-item">
                            <img src="{{ asset('default_images/user.png') }}" alt=""
                                style="height: 50px; width: 50px; border-radius: 50%;">
                            The employee dont have profile picture
                        </li>
                        <li class="list-group-item">
                            <img src="data:image/jpeg;base64,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"
                                alt="" style="height: 50px; width: 50px; border-radius: 50%;">
                            if the employee have image you can click it to see in full view
                        </li>
                        <li class="list-group-item">
                            Right-click on an employee's row to edit details or view more information.
                        </li>
                        <li class="list-group-item bg-info rounded">
                            If a row is highlighted in light blue, it indicates that the employee has an upcoming
                            vacation scheduled. </li>
                        <li class="list-group-item">
                            <span class="badge text-bg-primary">Salary Colors Explained:</span>
                            Salaries displayed in <strong style="color: rgb(0, 173, 87);">green</strong> indicate that
                            the employee's salary is above the average for their position, while those in <strong
                                style="color: rgb(230, 36, 36);">red</strong> indicate below-average earnings. Salaries
                            highlighted in <strong style="color: rgb(0, 140, 255);">blue</strong> represent the highest
                            earners within their respective positions.
                        </li>
                        <li class="list-group-item">
                            <span class="badge text-bg-secondary">Fullscreen Mode:</span>
                            Click the button with the <i class="bi bi-fullscreen"></i> icon to view the table in
                            fullscreen mode. You can exit fullscreen by pressing the
                            <strong>Esc</strong> key on your keyboard.
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Employee Detail Modal -->
    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailModalLabel">Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="employeeDetails">

                    <!-- Details will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <div class="mycontent">
        <div class="mt-2">
            <div>
                <form action="{{ route('employee.index') }}" method="GET" class="d-flex float-start">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search"
                        aria-label="Search" style="width: 400px" value="{{ request('search') }}">
                    <div class="btn-group" role="group" class="mb-3"> <!-- Bootstrap margin bottom class -->
                        <button class="btn btn-success" type="submit" title="Search"> <i class='bx bx-search'></i>
                        </button>
                        <a href="{{ route('employee.index') }}" class="btn btn-outline-dark">
                            <i class="bi bi-arrow-clockwise" title="Refresh"></i>
                        </a>
                    </div>

                    <!-- Position Filter -->
                    <select name="position" class="form-select ms-2">
                        <option value="">All Positions</option>
                        @foreach (\App\Models\Position::all() as $position)
                            <option value="{{ $position->id }}"
                                {{ request('position') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }} {{ $position->employees->count() }}

                            </option>
                        @endforeach
                    </select>

                    <!-- Salary Filter -->
                    <!-- Salary Sorting -->
                    <select name="salary_sort" class="form-select ms-2">
                        <option value="">Sort by Salary</option>
                        <option value="asc" {{ request('salary_sort') == 'asc' ? 'selected' : '' }}>Ascending
                        </option>
                        <option value="desc" {{ request('salary_sort') == 'desc' ? 'selected' : '' }}>Descending
                        </option>
                    </select>
                    <div class="dropdown ms-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bx bx-menu'></i>

                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('employees.statistics') }}"> <i
                                        class="fas fa-chart-bar"></i> Statistics</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('employees.terminated') }}"><i
                                        class="fas fa-ban"></i>
                                    Terminated</a>
                            </li>
                        </ul>
                    </div>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
                        rel="stylesheet">
                </form>

                <div class="float-end ">
                    {{ $data->appends(request()->input())->links('vendor.pagination.simple-bootstrap-5') }}
                </div>
            </div>
        </div>
        <br>
        <br>

        <div id="tableContainer">
            <!-- Your table code here -->
            @include('private.employee.components.table', ['data' => $data])
        </div>



    </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
    document.getElementById('fullscreenBtn').addEventListener('click', function() {
        var tableContainer = document.getElementById('tableContainer');
        if (!document.fullscreenElement) {
            tableContainer.requestFullscreen().catch(err => {
                alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
            });
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    });

    // Optional: Add an event listener to adjust button text based on fullscreen state
    document.addEventListener('fullscreenchange', () => {
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        fullscreenBtn.textContent = document.fullscreenElement ? 'Exit Fullscreen' : 'View Table in Fullscreen';
    });
</script>

<script>
    $(document).ready(function() {
        // Bind click event to the second column (first name) of each row in the table
        $('.table-hover tbody tr td:nth-child(2)').click(function() {
            const row = $(this).parent(); // Get the parent tr of this td
            const employeeId = row.data(
                'employee-id'); // Assuming each row has a data attribute like `data-employee-id`

            const details = `
                <p><strong>Name:</strong> ${row.find('td:nth-child(2)').text()} ${row.find('td:nth-child(3)').text()}</p>
                <p><strong>Phone:</strong> ${row.find('td:nth-child(4)').text()}</p>
                <p><strong>Email:</strong> ${row.find('td:nth-child(5)').text()}</p>
                <p><strong>Position:</strong> ${row.find('td:nth-child(6)').text()}</p>
                <p><strong>Salary:</strong> ${row.find('td:nth-child(7)').text()}</p>
                <p><strong>Status:</strong> ${row.find('td:nth-child(8)').html()}</p>
                <a href="/employee/${employeeId}" class="btn btn-primary">View Full Details</a> <!-- Adjust the route as necessary -->
            `;

            // Set the details in the modal's body and show the modal
            $('#employeeDetails').html(details);
            $('#employeeDetailModal').modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Right-click event on table row
        $('table tbody tr').on('contextmenu', function(e) {
            e.preventDefault(); // Prevent the default context menu

            // Position the context menu
            $('#customContextMenu').css({
                top: e.pageY + 'px',
                left: e.pageX + 'px',
                display: 'block'
            });

            // Store the ID or any relevant data attribute of the row if needed
            var employeeId = $(this).data('employee-id');
            $('#customContextMenu').data('employee-id', employeeId);
        });

        // Click anywhere to close the context menu
        $(document).click(function(e) {
            $('#customContextMenu').hide();
        });

        // Example action when clicking on menu items
        $('#customContextMenu .list-group-item').click(function() {
            var action = $(this).text();
            var employeeId = $('#customContextMenu').data('employee-id');

            console.log("Action: " + action + ", on Employee ID: " + employeeId);

            // Here you can redirect or perform further actions based on the clicked item
            if (action === "View Details") {
                window.location.href = '/employee/' + employeeId; // Adjust URL as needed
            }
            if (action === "Edit") {
                window.location.href = '/employee/' + employeeId + '/edit'; // Adjust URL as needed
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        const colorMap = {};

        function generateColor() {
            const randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16);
            return randomColor;
        }

        rows.forEach(row => {
            const position = row.dataset.position;
            if (!colorMap[position]) {
                colorMap[position] = generateColor(); // Generate color if it doesn't exist
            }
            row.style.backgroundColor = colorMap[position];
        });
    });
</script>

<script>
    document.addEventListener('fullscreenchange', () => {
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        // Clear the current content of the button
        fullscreenBtn.innerHTML = '';

        // Fill it with the correct icon based on fullscreen state
        if (document.fullscreenElement) {
            fullscreenBtn.innerHTML = '<i class="bi bi-fullscreen-exit" id="fullscreenIcon"></i>';
        } else {
            fullscreenBtn.innerHTML = '<i class="bi bi-fullscreen" id="fullscreenIcon"></i>';
        }
    });
</script>
@include('components.private.footer')
