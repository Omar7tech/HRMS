@include('components.private.header')
@include('components.private.sidebar')
<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Hire Proccess</span>
    </div>
    <div class="mycontent">

        <div class="container-sm mt-5">
            <div class="alert alert-danger" role="alert">
                <strong>Warning:</strong> Converting a trainee into an employee is irreversible. Once completed, this
                action cannot be undone. Are you absolutely sure you want to proceed?
            </div>
            <hr>
            <div class="container-sm mt-5 confirmation-text">

                <div class="privacy-policy">
                    <h2 class="privacy-policy__title">Trainee to Employee Transition Agreement</h2>
                    <div class="privacy-policy__content">
                        <p class="privacy-policy__intro">Welcome to <span class="privacy-policy__company-name">Omar 7
                                tech</span>! We are excited to have you join our team. Before proceeding, please review
                            the terms of the trainee to employee transition process.</p>

                        <div class="privacy-policy__section">
                            <h3 class="privacy-policy__section-title">1. Personal Information</h3>
                            <p class="privacy-policy__section-desc">As part of the transition, we collect certain
                                personal information from you. This includes:</p>
                            <ul class="privacy-policy__list">
                                <li class="privacy-policy__item">Your full name: <span
                                        class="privacy-policy__item-value">{{ $data->first_name }}
                                        {{ $data->last_name }}</span></li>
                                <li class="privacy-policy__item">Contact information: <span
                                        class="privacy-policy__item-value">{{ $data->email }},
                                        {{ $data->phone_number }}, {{ $data->address }}</span>
                                </li>
                                <li class="privacy-policy__item">Identification documents: <span
                                        class="privacy-policy__item-value">{{ $data->national_id }}</span></li>

                                <!-- Add or remove items as needed -->
                            </ul>
                        </div>

                        <div class="privacy-policy__section">
                            <h3 class="privacy-policy__section-title">2. Use of Information</h3>
                            <p class="privacy-policy__section-desc">We use the collected information for:</p>
                            <ul class="privacy-policy__list">
                                <li class="privacy-policy__item">Processing your transition to employee status</li>
                                <li class="privacy-policy__item">Compliance with legal and regulatory requirements</li>
                                <li class="privacy-policy__item">Internal record-keeping and administrative purposes
                                </li>
                                <!-- Add or remove items as needed -->
                            </ul>
                        </div>

                        <!-- Add more sections as needed -->

                        <p class="privacy-policy__footer">By proceeding with the transition, you acknowledge that you
                            have reviewed and agreed to the terms outlined above.</p>
                    </div>
                </div>
            </div>

            <div class="container-sm mt-3">
                <button class="btn btn-primary" onclick="printConfirmationText()">Print Confirmation Text</button>
            </div>

            <hr>

            <form action="{{route("onboard-hire" , ["id" => $data->id])}}" method="post">
                @csrf
                <button type="submit" class="btn btn-success btn-lg float-end">Procceed</button>
            </form>

            <script>
                function printConfirmationText() {
                    var confirmationText = document.querySelector('.confirmation-text');
                    var printWindow = window.open('', '_blank');
                    printWindow.document.write('<html><head><title>Print Confirmation Text</title></head><body>');
                    printWindow.document.write(confirmationText.innerHTML);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                }
            </script>
        </div>
    </div>
</section>
<script>
    function printConfirmationText() {
        var confirmationText = document.querySelector('.confirmation-text');
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print Confirmation Text</title></head><body>');
        printWindow.document.write(confirmationText.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
@include('components.private.footer')
