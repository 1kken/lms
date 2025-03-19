@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row align-items-center mb-3">
            <!-- Heading -->
            <div class="col-md-4 mb-2 mb-md-0">
                <h2 class="admin-heading">All Students</h2>
            </div>

            <!-- Search Form -->
            <div class="col-md-6">
                <form action="{{ route('student.search') }}" method="get">
                    <div class="input-group">
                        <!-- Search Input -->
                        <input type="text" class="form-control @error('search') is-invalid @enderror"
                            placeholder="Search..." name="search" value="{{ request('search') }}">
                        <!-- Search Button -->
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <x-css-search />
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Add Student and Print Table Buttons -->
            <div class="col-md-2 text-md-right text-center mt-2 mt-md-0">
                <a class="btn btn-success mb-1" href="{{ route('student.create') }}">Add Student</a>
                <button class="btn btn-info" onclick="printTable()">Print Table</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="message"></div>
                <!-- Assign an ID to the table so it can be easily printed -->
                <table id="students-table" class="content-table">
                    <thead>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <td class="id">{{ substr($student->student_id, 0, 10) }}</td>
                            <td>{{ $student->name }}</td>
                            <td class="text-capitalize">{{ $student->gender }}</td>
                            <td class="text-capitalize">{{ $student->class }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No Students Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $students->links('vendor/pagination/bootstrap-4') }}
                <div id="modal">
                    <div id="modal-form">
                        <table cellpadding="10px" width="100%">
                        </table>
                        <div id="close-btn">X</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript">
    // Function to print only the students table
    function printTable() {
        // Get the HTML of the table
        var tableHTML = document.getElementById('students-table').outerHTML;
        // Open a new window
        var printWindow = window.open('', '', 'height=600,width=800');
        // Write the table HTML and basic styles to the new window
        printWindow.document.write('<html><head><title>Print Table</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
        printWindow.document.write('table, th, td { border: 1px solid #000; }');
        printWindow.document.write('th, td { padding: 8px; text-align: left; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(tableHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        // Trigger the print dialog
        printWindow.print();
        printWindow.close();
    }

    // Example script for showing student details (if needed)
    $(".view-btn").on("click", function() {
        var student_id = $(this).data("sid");
        $.ajax({
            url: "http://127.0.0.1:8000/student/show/" + student_id,
            type: "get",
            success: function(student) {
                var form = "<tr><td>Student Name :</td><td><b>" + student['name'] + "</b></td></tr>" +
                           "<tr><td>Address :</td><td><b>" + student['address'] + "</b></td></tr>" +
                           "<tr><td>Gender :</td><td><b>" + student['gender'] + "</b></td></tr>" +
                           "<tr><td>Class :</td><td><b>" + student['class'] + "</b></td></tr>" +
                           "<tr><td>Age :</td><td><b>" + student['age'] + "</b></td></tr>" +
                           "<tr><td>Phone :</td><td><b>" + student['phone'] + "</b></td></tr>" +
                           "<tr><td>Email :</td><td><b>" + student['email'] + "</b></td></tr>";
                $("#modal-form table").html(form);
                $("#modal").show();
            }
        });
    });

    // Hide modal box
    $('#close-btn').on("click", function() {
        $("#modal").hide();
    });
</script>
@endsection
