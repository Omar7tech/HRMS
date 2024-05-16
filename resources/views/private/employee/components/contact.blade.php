<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-envelope-fill"></i> Email</h5>
                <p class="card-text">{{ $employee->email }}</p>
                <a href="mailto:{{ $employee->email }}" class="btn btn-primary">Send Mail</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-telephone-fill"></i> Phone Number</h5>
                <p class="card-text">{{ $employee->phone_number }}</p>
                <a href="tel:{{ $employee->phone_number }}" class="btn btn-primary">Call</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body " style=" background-color: #ffcccc;">
                <h5 class="card-title"><i class="bi bi-telephone-fill"></i> Emergency Contact</h5>
                <p class="card-text">{{ $employee->emergency_contact }}</p>
                <a href="tel:{{ $employee->emergency_contact }}"
                    class="btn btn-outline-danger">Call</a>
            </div>
        </div>
    </div>
</div>
