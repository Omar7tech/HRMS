@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Add Vacation</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('vacations.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="employee_search" class="form-label">Search Employee</label>
                    <input type="text" class="form-control" id="employee_search" placeholder="Type to search..." autocomplete="off">
                    <input type="hidden" id="employee_id" name="employee_id" required>
                    <div id="employee_list" class="list-group"></div>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" disabled>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" disabled>
                </div>

                <button type="submit" class="btn btn-primary" id="submit_button" disabled>Submit</button>
            </form>
        </div>
    </div>
</section>
<script>
   document.getElementById('employee_search').addEventListener('input', function() {
    const searchValue = this.value.trim();

    if (searchValue.length > 1) {
        fetch(`/search-employees?search=${searchValue}`)
            .then(response => response.json())
            .then(data => {
                const employeeList = document.getElementById('employee_list');
                employeeList.innerHTML = '';
                if (data.length) {
                    data.forEach(employee => {
                        let div = document.createElement('div');
                        div.className = 'list-group-item list-group-item-action';
                        div.textContent = `${employee.first_name} ${employee.last_name} (${employee.email})`;
                        div.onclick = function() {
                            document.getElementById('employee_id').value = employee.id;
                            document.getElementById('employee_search').value = employee.first_name + ' ' + employee.last_name;
                            employeeList.innerHTML = '';

                            // Enable the date inputs and submit button
                            document.getElementById('start_date').disabled = false;
                            document.getElementById('end_date').disabled = false;
                            document.getElementById('submit_button').disabled = false;
                        };
                        employeeList.appendChild(div);
                    });
                    employeeList.style.display = 'block';
                } else {
                    employeeList.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching employees:', error);
                employeeList.style.display = 'none';
            });
    } else {
        document.getElementById('employee_list').style.display = 'none';
    }
});

// Focus and Blur events to manage the display of results
document.getElementById('employee_search').addEventListener('focus', function() {
    if (this.value.trim().length > 1 && document.getElementById('employee_list').innerHTML !== '') {
        document.getElementById('employee_list').style.display = 'block';
    }
});
document.getElementById('employee_search').addEventListener('blur', function() {
    setTimeout(() => {
        document.getElementById('employee_list').style.display = 'none';
    }, 200);
});
</script>

@include('components.private.footer')
