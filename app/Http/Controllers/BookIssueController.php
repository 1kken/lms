<?php

namespace App\Http\Controllers;

use App\Models\BookIssue;
use App\Http\Requests\Storebook_issueRequest;
use App\Http\Requests\Updatebook_issueRequest;
use App\Models\book;
use App\Models\settings;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use \Illuminate\Http\Request;

class BookIssueController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('book.issueBooks', [
            'books' => BookIssue::Paginate(5)
        ]);
    }

    public function search(Request $request)
    {
        // Get search term from request
        $search = $request->input('search');
        $status = $request->input('status');

        // Initialize query
        $bookIssues = BookIssue::query();

        // Apply search filter
        if (!empty($search)) {
            $bookIssues->whereHas('student', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('student_id', 'like', "%$search%");
            })
                ->orWhereHas('book', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('rfid', 'like', "%$search%");
                });
        }

        // Apply status filter if provided
        if (!empty($status)) {
            $bookIssues->where('issue_status', $status);
        }

        // Paginate results (10 per page)
        $bookIssues = $bookIssues->paginate(10);

        // Return view with results
        return view('book.issueBooks', ['books'=>$bookIssues]);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('book.issueBook_add');
    }

    /**
     * @param Storebook_issueRequest $request
     * @return RedirectResponse
     */
    public function store(Storebook_issueRequest $request)
    {
        $issue_date = date('Y-m-d');
        $return_date = date('Y-m-d', strtotime("+" . (Settings::latest()->first()->return_days) . " days"));

        // Create the book issue record
        $data = BookIssue::create($request->validated() + [
                'student_id' => $request->student_id,
                'rfid' => $request->rfid,
                'issue_date' => $issue_date,
                'return_date' => $return_date,
                'issue_status' => 'N',
            ]);

        // Find the book using RFID (not ID)
        $book = Book::where('rfid', $request->rfid)->first();

        // Check if the book exists before assigning status
        if ($book) {
            $book->status = 'N';
            $book->save();
        } else {
            return back()->withErrors(['rfid' => 'Book not found.']);
        }

        return redirect()->route('book_issued')->with('success', 'Book issued successfully.');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        // calculate the total fine  (total days * fine per day)
        $book = BookIssue::where('id',$id)->get()->first();
        $first_date = date_create(date('Y-m-d'));
        $last_date = date_create($book->return_date);
        $diff = date_diff($first_date, $last_date);
        $fine = (settings::latest()->first()->fine * $diff->format('%a'));
        return view('book.issueBook_edit', [
            'book' => $book,
            'fine' => $fine,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Find the book issue record
        $bookIssue = BookIssue::find($id);

        if (!$bookIssue) {
            return back()->withErrors(['error' => 'Book issue record not found.']);
        }

        // Update book issue status
        $bookIssue->issue_status = 'Y';
        $bookIssue->return_day = now();
        $bookIssue->save();

        // Find the actual book using RFID
        $book = book::where('rfid', $bookIssue->rfid)->first();

        if (!$book) {
            return back()->withErrors(['error' => 'Book not found.']);
        }

        // Update book status
        $book->status = 'Y';
        $book->save();

        return redirect()->route('book_issued')->with('success', 'Book returned successfully.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        BookIssue::find($id)->delete();
        return redirect()->route('book_issued');
    }

}
