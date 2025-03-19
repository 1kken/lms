@extends('layouts.guest')
@section('content')
<style>
    body {
        background-color: #2A3F54;
    }

    /* Login container without white background and centered */
    #wrapper-admin {
        background-color: transparent;
        padding: 30px;
        border-radius: 8px;
        max-width: 500px;
        margin: 50px auto;
    }

    .yourform {
        color: white;
    }

    /* Form label styling: updated to #2A3F54 */
    .yourform label {
        color: #2A3F54;
    }

    /* Library Information System heading styled and centered */
    .yourform h3 {
        color: #2A3F54;
        text-align: center;
    }

    /* Footer styling */
    .footer {
        text-align: center;
        color: white;
        margin-top: 20px;
        font-size: 14px;
    }
</style>

<div id="wrapper-admin">
    <div class="container">
        <form class="yourform" action="{{ route('login') }}" method="post">
            @csrf
            <h3>&#128214; Library Information System</h3>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <!-- Remember Me checkbox -->
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <input type="submit" name="login" class="btn btn-danger btn-block" value="Login" />

            <!-- Forgot Password link -->
            <div class="text-center mt-3">
                <a href="">Forgot Password?</a>
            </div>
        </form>
        @error('username')
        <div class="alert alert-danger mt-3">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Footer -->
<div class="footer">
    &copy; 2025 Library Information System. All Rights Reserved
</div>
@endsection
