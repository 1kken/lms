<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.index', [
            'books' => Book::paginate(5)
        ]);
    }

    /**
     * Display a listing of the resource with search and filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $books = Book::query();

        if (!empty($search)) {
            $books->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('rfid', 'like', "%$search%")
                      ->orWhere('author', 'like', "%$search%")
                      ->orWhere('category', 'like', "%$search%")
                      ->orWhere('publisher', 'like', "%$search%");
            });
        }

        if (!empty($status)) {
            $books->where('status', $status);
        }

        $books = $books->paginate(10);

        return view('book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No longer fetching authors, publishers, or categories from separate tables.
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        // The validated data should now include author, publisher, category, and copy.
        $data = $request->validated();
        $data['status'] = 'Y'; // Set default status

        Book::create($data);

        return redirect()->route('books');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        // No need to pass authors, publishers, or categories as they're now part of the book record.
        return view('book.edit', [
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $validated = $request->validated();

        // The validated data should include keys for name, rfid, author, category, publisher, and copy.
        $book = Book::findOrFail($id);
        $book->update($validated);

        return redirect()->route('books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('books');
    }
}
