@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <!-- Header with Admin Information and Add Admin button -->
        <div class="row mb-3">
            <div class="col-md-6">
                <h2 class="admin-heading">Admin Information</h2>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add Admin</a>
            </div>
        </div>
        <!-- Table displaying users -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                <!-- Edit Icon -->
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!-- Delete Icon -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this admin?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination links (if you're paginating the results) -->
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
