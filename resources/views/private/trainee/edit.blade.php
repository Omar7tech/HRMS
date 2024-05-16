@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Edit Trainee</span>
    </div>
    <div class="mycontent">

        <div class="container-sm mt-5">
            <form class="row g-3 needs-validation" action="{{ route('trainee.update', $data->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- First Name --}}
                <div class="col-md-4">
                    <label for="validationServer01" class="form-label">First name</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                        id="validationServer01" value="{{ $data->first_name }}" name="first_name">
                    @error('first_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div class="col-md-4">
                    <label for="validationServer02" class="form-label">Last name</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                        id="validationServer02" value="{{ $data->last_name }}" name="last_name">
                    @error('last_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- National ID --}}
                <div class="col-md-4">
                    <label for="validationServer03" class="form-label">National ID</label>
                    <input type="text" class="form-control @error('national_id') is-invalid @enderror"
                        id="validationServer03" value="{{ $data->national_id }}" name="national_id">
                    @error('national_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Other form fields go here --}}
                {{-- Date of Birth --}}
                <div class="col-md-6">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                        id="date_of_birth" name="date_of_birth" value="{{ $data->date_of_birth }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nationality --}}
                <div class="col-md-6">
                    <label for="nationality" class="form-label">Nationality</label>
                    <select class="form-select @error('nationality') is-invalid @enderror" id="nationality"
                        name="nationality">
                        <option value="{{ $data->nationality }}">{{ $data->nationality ?: 'Select Nationality' }}
                        </option>
                    </select>
                    @error('nationality')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Gender --}}
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="Male" {{ $data->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $data->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ $data->email }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                        id="phone_number" name="phone_number" value="{{ $data->phone_number }}">
                    @error('phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" value="{{ $data->address }}">
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="col-md-6">
                    <label for="position" class="form-label">Position</label>
                    <select class="form-select @error('position') is-invalid @enderror" id="position" name="position">
                        <option value="{{ $data->position->id }}">{{ $data->position->name ?: 'Select position' }}</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>

                    @error('position')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="salary" class="form-label">Salary</label>
                    <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ $data->salary }}">
                    @error('salary')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="emergency_contact" class="form-label">Emergency Contact</label>
                    <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" id="emergency_contact" name="emergency_contact" value="{{ $data->emergency_contact }}">
                    @error('emergency_contact')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="cv" class="form-label">CV (PDF)</label>
                    <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" accept=".pdf">
                    @error('cv')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    @if ($data->cv)
                        <div>
                            <a href="{{ asset('storage/' . $data->cv) }}" target="_blank">View Current CV</a>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="image-preview-container" class="mt-4">
                        <img id="image-preview" src="#" alt=""
                            style="max-width: 100%; max-height: 200px; border-radius: 7px;">
                    </div>
                </div>


                <div class="col-12 mt-5">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    // Function to display selected image
    function previewImage(input) {
        var preview = document.getElementById('image-preview');
        var previewContainer = document.getElementById('image-preview-container');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block'; // Show the image container
            }

            reader.readAsDataURL(input.files[0]); // Read the uploaded file as a URL
        } else {
            preview.src = '#';
            previewContainer.style.display = 'none'; // Hide the image container if no file is selected
        }
    }

    // Bind the previewImage function to the change event of the image input
    document.getElementById('image').addEventListener('change', function() {
        previewImage(this);
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectNationality = document.getElementById('nationality');

        // Function to fetch data with retries
        function fetchDataWithRetries(url, retries = 3, interval = 1000) {
            return new Promise((resolve, reject) => {
                const fetchData = async () => {
                    try {
                        const response = await fetch(url);
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        const data = await response.json();
                        resolve(data);
                    } catch (error) {
                        if (retries === 0) {
                            reject(error);
                        } else {
                            setTimeout(() => fetchData(), interval);
                            retries--;
                        }
                    }
                };
                fetchData();
            });
        }

        // Fetch data from the URL with retries
        fetchDataWithRetries('{{ asset('data/countries.json') }}')
            .then(data => {
                // Populate select options
                data.forEach(country => {
                    const nativeName = country.name.nativeName?.ara?.common || '';
                    const optionText = nativeName ? `${country.name.common}, ${nativeName}` :
                        country.name.common;
                    const option = new Option(optionText, country.name.common);
                    selectNationality.add(option);
                });
            })
            .catch(error => console.error('Error fetching data:', error));

        // Fetch flag emojis from the provided API with retries
        fetchDataWithRetries('{{ asset('data/flags.json') }}')
            .then(data => {
                // Add flag emojis to options
                data.forEach(country => {
                    const option = selectNationality.querySelector(
                        `option[value="${country.name}"]`);
                    if (option && country.emoji) {
                        option.textContent = country.emoji + ' ' + option.textContent;
                    }
                });
            })
            .catch(error => console.error('Error fetching flag emojis:', error));
    });
</script>
@include('components.private.footer')
