@include('components.private.header')
@include('components.private.sidebar')

<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text"> Edit Position : {{ $data->name }}</span>
    </div>

    <div class="mycontent">
        <div class="container-sm mt-5">
            <hr>
            <form class="row g-3" method="POST" action="{{ route('positions.update', ['position' => $data->id]) }}">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="positionName" class="form-label">Position Name</label>
                    <input type="text" class="form-control" id="positionName" value="{{ $data->name }}" name="name" placeholder="Enter position name">
                </div>
                <div class="col-md-6">
                    <label for="positionSalary" class="form-label">Salary</label>
                    <input type="number" class="form-control" id="positionSalary" value="{{ $data->salary }}" name="salary" placeholder="Enter salary amount">
                </div>
                <div class="col-md-4">
                    <label for="numberOfEmployees" class="form-label">Number of Assigned Employees</label>
                    <input type="text" class="form-control" id="numberOfEmployees" value="{{ $data->employees->count() }}" disabled>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route("positions.delete" , ["position" => $data->id])}}" class="btn btn-danger" role="button">Delete</a>
                </div>
            </form>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

@include('components.private.footer')
