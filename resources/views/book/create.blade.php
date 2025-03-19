@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Add Book</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('books') }}">All Books</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourform" action="{{ route('book.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Book Name</label>
                            <input type="text" class="form-control @error('name') isinvalid @enderror"
                                placeholder="Book Name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Category input field -->
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control @error('category') isinvalid @enderror"
                                placeholder="Category" name="category" value="{{ old('category') }}" required>
                            @error('category')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Author input field -->
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" class="form-control @error('author') isinvalid @enderror"
                                placeholder="Author" name="author" value="{{ old('author') }}" required>
                            @error('author')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Publisher input field -->
                        <div class="form-group">
                            <label>Publisher</label>
                            <input type="text" class="form-control @error('publisher') isinvalid @enderror"
                                placeholder="Publisher" name="publisher" value="{{ old('publisher') }}" required>
                            @error('publisher')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- RFID tag input field -->
                        <div class="form-group">
                            <label>Scan RFID Tag</label>
                            <input id="rfid" type="text" class="form-control @error('rfid') isinvalid @enderror"
                                placeholder="Please use RFID scanner..." name="rfid" value="{{ old('rfid') }}" required>
                            @error('rfid')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Copy input field -->
                        <div class="form-group">
                            <label>Copy</label>
                            <input type="number" class="form-control @error('copy') isinvalid @enderror"
                                placeholder="Copy count" name="copy" value="{{ old('copy') }}" required>
                            @error('copy')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="Save" required>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const rfidInput = document.getElementById('rfid');
        rfidInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    </script>
@endsection
