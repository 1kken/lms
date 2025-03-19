@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('settings.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-2">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="{{ $user->username }}" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="password">Password <small>(leave blank to keep current password)</small>:</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
