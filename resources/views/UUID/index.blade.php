@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Check UUID Validity</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">UUID Validation</h4>
                    <p class="card-text">
                        Enter a UUID in the field below to check its validity. This tool verifies if the entered UUID conforms to the standard UUID format and checks if it is associated with an existing employee in our database. If the UUID is valid and found, detailed information about the employee will be displayed. If not, you will receive an error message.
                    </p>
                    <form id="uuidForm" class="mb-4">
                        <div class="input-group mb-3">
                            <input type="text" id="uuidInput" class="form-control" placeholder="Enter UUID" aria-label="Enter UUID" aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Check UUID</button>
                        </div>
                    </form>
                    <div id="uuidResult" class="alert alert-secondary" role="alert" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#uuidForm').on('submit', function(e) {
            e.preventDefault();
            $('#uuidResult').hide().removeClass('alert-success alert-danger');
            var uuid = $('#uuidInput').val();
            $.ajax({
                url: "{{ route('uuid.check') }}",
                type: "POST",
                data: {
                    uuid: uuid,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.exists) {
                        $('#uuidResult').addClass('alert-success').html('Employee found:<br> First name: ' + response.employee.first_name + '<br>Last name: ' + response.employee.last_name + '<br>Email: ' + response.employee.email + '<br>Phone: ' + response.employee.phone_number).show();
                    } else {
                        $('#uuidResult').addClass('alert-danger').html(response.message).show();
                    }
                },
                error: function(response) {
                    var message = response.responseJSON && response.responseJSON.message ? response.responseJSON.message : 'Error occurred. Please try again.';
                    $('#uuidResult').addClass('alert-danger').html(message).show();
                }
            });
        });
    });
</script>

@include('components.private.footer')
