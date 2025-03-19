@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add User</h1>
    <form action="{{ route('settings.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
        </div>
        <div class="form-group mb-2">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        </div>
        <div class="form-group mb-2">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection
