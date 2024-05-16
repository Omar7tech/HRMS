@include('components.private.header')
@include('components.private.sidebar')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Trained Staff</span>
    </div>
    <div class="mycontent">
        <div class="container-sm mt-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($data as $trained)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $trained->first_name }} {{ $trained->last_name }}
                                    .
                                </h5>

                                <p class="card-text">
                                    {{ $trained->phone_number }}
                                    <br>
                                    {{ $trained->email }}
                                    <br>
                                    <span class="text-success">{{ $trained->position->name }}</span>

                                    <br>
                                    <strong>{{ $trained->uuid }}</strong>

                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-body-secondary">End Date : {{ $trained->updated_at }}</small>
                                <div class="dropdown float-end">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route("trained.show" , ["id" => $trained->id]) }}">Show</a></li>
                                        <li><a class="dropdown-item" href="{{ route("onboard-confirm" , ["id" => $trained->id]) }}">Hire</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@include('components.private.footer')
