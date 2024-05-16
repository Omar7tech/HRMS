<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Termination Process for {{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Termination Letter</h4>
                            <p class="card-text">Dear {{ $employee->first_name }},</p>
                            <p class="card-text">We regret to inform you that your employment with Omar 7 Tech will be terminated effective {{ now() }}.</p>
                            <!-- Add more content of the termination letter here -->
                            <hr>
                            <button class="btn btn-primary" onclick="printTerminationLetter()">Print Termination Letter</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Fire or Delete Employee</h4>
                            <p class="card-text">Are you sure you want to terminate the employment of {{ $employee->first_name }} {{ $employee->last_name }}?</p>
                            <form method="POST"  action="{{ route('employee.destroy', ['employee' => $employee->id]) }} ">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Fire Employee</button>
                            </form>
                            <!-- Add more options for termination, like deleting the employee's account -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<textarea id="terminationLetter" style="display: none;">
    {{ now() }}

    {{ $employee->first_name }} {{ $employee->last_name }}
    {{ $employee->address }}

    Dear {{ $employee->first_name }},

    We regret to inform you that your employment with "Omar 7 Tech" will be terminated effective {{ now() }}.

    This decision was not made lightly and follows a thorough review of your employment history and performance. Despite our efforts to provide support and guidance, it has become clear that a continuation of your employment with the company is no longer feasible.

    We want to express our appreciation for your contributions and efforts during your time with us. We understand that this news may come as a surprise, and we will do our best to assist you during this transition period.

    We wish you the best in your future endeavors and hope that you find success and fulfillment in your future pursuits.

    Sincerely,

    {{ Auth()->user()->first_name }}
    Human Resource
    Omar 7 Tech
</textarea>

<script>
    function printTerminationLetter() {
        var terminationLetter = document.getElementById('terminationLetter').value;

        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<div style="font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; font-size: 18px; line-height: 1.6; padding: 20px;">' + terminationLetter + '</div>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
