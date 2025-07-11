@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row align-items-center">
                <!-- Heading -->
                <div class="col-md-3">
                    <h2 class="admin-heading">All Books</h2>
                </div>
                <!-- Search Form -->
                <div class="col-md-6">
                    <form action="{{ route('book.search') }}" method="get">
                        <div class="input-group">
                            <!-- Search Input -->
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Search..." name="search" value="{{  request('search') }}">
                            <!-- Dropdown for Status -->
                            <select name="status" class="form-control ml-2" >
                                <option value="">All</option>
                                <option value="Y" {{request('status') == 'Y' ? 'selected' : '' }}>Available</option>
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

                <!-- Add Book Button -->
                <div class="col-md-3 text-right">
                    <a class="btn btn-success" href="{{ route('book.create') }}">Add Book</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>S.No</th>
                            <th>Rfid no.</th>
                            <th>Book Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td class="id">{{ $book->id }}</td>
                                    <td>{{ $book->rfid }}</td>
                                    <td>{{ $book->name }}</td>
                                    <td>{{ $book->category }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->publisher}}</td>
                                    <td>
                                        @if ($book->status == 'Y')
                                            <span class='badge badge-success'>Available</span>
                                        @else
                                            <span class='badge badge-danger'>Issued</span>
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('book.edit', $book) }}" class="btn btn-success">Edit</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('book.destroy', $book) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger delete-book">Delete</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">No Books Found</td>
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
