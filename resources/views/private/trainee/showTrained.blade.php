@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Show Trained: {{ $trained->first_name }} {{ $trained->last_name }}</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="card">
                <div class="card-header">
                    Details
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $trained->first_name }}</h5>
                    <p class="card-text">
                        <strong>Email:</strong> {{ $trained->email }}<br>
                        <strong>Created at:</strong> {{ $trained->created_at->format('d M Y') }}<br>
                        <strong>Position:</strong> {{ $trained->position->name }}<br>
                        <strong>Phone:</strong> {{ $trained->phone_number }}<br>
                        <strong>Nationaloty:</strong> {{ $trained->nationality }}<br>
                        <strong>National Id:</strong> {{ $trained->national_id }}<br>
                        <strong>Gender:</strong> {{ $trained->gender }}<br>
                        <strong>Date of birth:</strong> {{ $trained->date_of_birth }}<br>
                        <strong>EC:</strong> {{ $trained->emergency_contact }}<br>
                    </p>
                    {{-- $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('UUID()'));
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_id');
            $table->string('nationality');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->decimal('salary', 10, 2);
            $table->string('emergency_contact');
            $table->string('cv')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('position_id'); // Define foreign key column
            $table->smallInteger('training')->default(0);
            $table->date("start_date")->nullable();
            $table->softDeletes();
            $table->timestamps(); --}}
                    @if ($trained->image)
                        <a href="{{ asset('storage/' . $trained->image) }}" target="_blank" class="btn btn-secondary">
                            <i class="bi bi-image"></i> View Image
                        </a>
                    @endif

                    @if ($trained->cv)
                        <a href="{{ asset('storage/' . $trained->cv) }}" class="btn btn-info" target="_blank">
                            <i class="bi bi-file-earmark-text"></i> View CV
                        </a>
                    @else
                        <p>No CV available</p>
                    @endif
                    <a href="#" onclick="event.preventDefault(); window.history.back();" class="btn btn-dark">Back</a>
                    <a href="{{  route("onboard-confirm" , ["id" => $trained->id]) }}" class="btn btn-primary float-end">Hire</a>
                </div>
                <div class="card-footer text-muted">
                    Training Status: Completed
                </div>
            </div>
        </div>
    </div>
</section>

@include('components.private.footer')
