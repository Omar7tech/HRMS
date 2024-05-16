@include('components.header')

<style>
    body {
        background-color: #f4f7fa;
        /* Light gray background for a professional look */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /* Professional font */
    }

    .container {
        background-color: #ffffff;
        /* Solid white background for clarity */
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Refined shadow for depth */
        padding: 40px;
        margin-top: 2%;
        margin-bottom: 2%;
    }

    .form-control {
        border: 1px solid #ccd1d9;
        /* Subtle border */
        border-radius: 4px;
        height: 45px;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #5d9cec;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(93, 156, 236, .6);
    }

    .btn-primary {
        background-color: #337ab7;
        border: none;
        border-radius: 4px;
        padding: 10px 15px;
        font-size: 16px;
        color: white;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #286090;
    }

    label {
        font-weight: 600;
        color: #333;
    }

    .invalid-feedback,
    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
        padding: 10px;
        border-radius: 4px;
    }

    .header-text {
        text-align: center;
        margin-bottom: 20px;
    }

    .header-text h1 {
        font-size: 24px;
        color: #333;
    }

    .header-text p {
        font-size: 16px;
        color: #666;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-10 col-12">
            <div class="header-text">
                <h1>Welcome to HRMS Portal</h1>
                <p>Human Resources Management System: Streamlining HR processes for better efficiency.</p>
            </div>

            <div class="alert alert-danger" id="error-alert" style="display: none;">
                <strong>Error!</strong> Incorrect username or password.
            </div>

            <form id="login-form" action="{{ route('auth') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" value="{{ old('username') }}">
                    @error('username')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}.
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password">
                    @error('password')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}.
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3 w-100">Login</button>
                <div class="header-text mt-4">
                    <p>Demo Moderator Account <br>
                        Username : moderator <br>
                        Password : moderator</p>
                </div>
            </form>

            @if ($errors->has('credentials'))
                <div class="alert alert-danger mt-4">
                    {{ $errors->first('credentials') }}
                </div>
            @endif

        </div>
    </div>
</div>

@include('components.footer')
