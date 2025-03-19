@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Update Book</h2>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourform" action="{{ route('book.update', $book->id) }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Book Name</label>
                            <input type="text" class="form-control @error('name') isinvalid @enderror"
                                placeholder="Book Name" name="name" value="{{ $book->name }}">
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Category as a text input -->
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control @error('category') isinvalid @enderror"
                                placeholder="Category" name="category" value="{{ $book->category }}">
                            @error('category')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Author as a text input -->
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" class="form-control @error('author') isinvalid @enderror"
                                placeholder="Author" name="author" value="{{ $book->author }}">
                            @error('author')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Publisher as a text input -->
                        <div class="form-group">
                            <label>Publisher</label>
                            <input type="text" class="form-control @error('publisher') isinvalid @enderror"
                                placeholder="Publisher" name="publisher" value="{{ $book->publisher }}">
                            @error('publisher')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- RFID field remains unchanged -->
                        <div class="form-group">
                            <label>Scan RFID Tag</label>
                            <input id="rfid" type="text" class="form-control @error('rfid') isinvalid @enderror"
                                placeholder="Please use RFID scanner..." name="rfid" value="{{ $book->rfid }}" required>
                            @error('rfid')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Optional: Copy input field -->
                        <div class="form-group">
                            <label>Copy</label>
                            <input type="number" class="form-control @error('copy') isinvalid @enderror"
                                placeholder="Copy count" name="copy" value="{{ $book->copy }}">
                            @error('copy')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const rfidInput = document.getElementById('rfid');
        rfidInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent form submission when pressing Enter in the RFID field
            }
        });
    </script>
@endsection
