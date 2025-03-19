@extends('layouts.app')

@section('content')
    <div id="admin-content">
        <div class="container">
            <!-- Header Section -->
            <div class="row align-items-center mb-4">
                <div class="col-md-3">
                    <h2 class="admin-heading">Add Book Issue</h2>
                </div>
                <div class="col-md-2 offset-md-7 text-md-right text-center">
                    <a class="btn btn-success" href="{{ route('book_issued') }}">All Issue List</a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg p-4">
                        <form class="yourform" action="{{ route('book_issue.store') }}" method="post" autocomplete="off">
                            @csrf

                            <!-- Student ID (Barcode) -->
                            <div class="form-group">
                                <label class="font-weight-bold">Student ID (Scan Barcode)</label>
                                <input id="student_id" type="text" class="form-control" placeholder="Scan Barcode" name="student_id"
                                       value="{{ old('student_id') }}" required autofocus>
                                @error('student_id')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Book RFID Input -->
                            <div class="form-group">
                                <label class="font-weight-bold">Book RFID (Scan RFID)</label>
                                <input id="rfid" type="text" class="form-control" placeholder="Scan Book's RFID" name="rfid"
                                       value="{{ old('rfid') }}" required>
                                @error('rfid')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Category Dropdown -->
                            <div class="form-group">
                                <label class="font-weight-bold">Category</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="assignment" {{ old('category') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                    <option value="activity" {{ old('category') == 'activity' ? 'selected' : '' }}>Activity</option>
                                </select>
                                @error('category')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <input type="submit" name="save" class="btn btn-danger px-4 py-2" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const studentIdInput = document.getElementById("student_id");
            const bookRfidInput = document.getElementById("rfid");

            // Autofocus student ID when the page loads
            studentIdInput.focus();

            studentIdInput.addEventListener("keydown", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault(); // Prevent form submission
                    bookRfidInput.focus(); // Move focus to RFID field
                }
            });

            bookRfidInput.addEventListener("keydown", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault(); // Prevent accidental form submission
                }
            });
        });
    </script>
@endsection
