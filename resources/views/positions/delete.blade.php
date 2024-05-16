@include('components.private.header')
@include('components.private.sidebar')
<section class="home-section" style="margin-bottom: 500px">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text"> Delete Position : {{ $data->name }}</span>
    </div>

    <div class="mycontent">
        <div class="container-sm mt-5">
            <hr>
            <ul class="list-group">
                <li class="list-group-item active" aria-current="true">{{ $data->name }}</li>
                <li class="list-group-item">Salary : {{ $data->salary }}</li>
                <li class="list-group-item">Created At : {{ $data->created_at }}</li>
            </ul>


            <div class="mt-3">
                <p>Are you sure you want to delete this position ? </p>
            </div>
            <form class="d-flex" action="{{ route("positions.destroy" , ["position" => $data->id]) }}" method="POST">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger ps-5 pe-5">Yes</button>
            </form>

        </div>
    </div>
</section>

@include('components.private.footer')
