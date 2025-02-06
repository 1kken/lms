@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <!-- Heading -->
                <div class="col-md-3">
                    <h2 class="admin-heading">All Book Issue</h2>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('book_issue.search') }}" method="get">
                        <div class="input-group">
                            <!-- Search Input -->
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Search..." name="search" value="{{  request('search') }}">
                            <!-- Dropdown for Status -->
                            <select name="status" class="form-control ml-2" >
                                <option value="">All</option>
                                <option value="Y" {{request('status') == 'Y' ? 'selected' : '' }}>Returned</option>
                                <option value="N" {{ request('status') == 'N' ? 'selected' : '' }}>Issued</option>
                            </select>

                            <!-- Search Button -->
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <x-css-search />
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class=" col-md-3">
                    <a class="add-new" href="{{ route('book_issue.create') }}">Add Book Issue</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="content-table">
                        <thead>
                            <th>BI.No</th>
                            <th>Student Name</th>
                            <th>Book Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Issue Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr style='@if (date('Y-m-d') > $book->return_date->format('d-m-Y') && $book->issue_status == 'N') ) background:rgba(255,0,0,0.2) @endif'>
                                    <td>{{ $book->id }}</td>
                                    <td>{{ $book->student->name }}</td>
                                    <td>{{ $book->book->name }}</td>
                                    <td>{{ $book->student->phone }}</td>
                                    <td>{{ $book->student->email }}</td>
                                    <td>{{ $book->issue_date->format('d M, Y') }}</td>
                                    <td>{{ $book->return_date->format('d M, Y') }}</td>
                                    <td>
                                        @if ($book->issue_status == 'Y')
                                            <span class='badge badge-success'>Returned</span>
                                        @else
                                            <span class='badge badge-danger'>Issued</span>
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('book_issue.edit', $book->id) }}" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('book_issue.destroy', $book) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger">Delete</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">No Books Issued</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $books->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
