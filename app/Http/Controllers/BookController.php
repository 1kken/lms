<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Http\Requests\StorebookRequest;
use App\Http\Requests\UpdatebookRequest;
use App\Models\auther;
use App\Models\category;
use App\Models\publisher;
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
            'books' => book::Paginate(5)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Get the search term and status filter from the request
        $search = $request->input('search');
        $status = $request->input('status');

        // Initialize the query
        $books = Book::query();

        // Apply the search filter if search term is provided
        if (!empty($search)) {
            $books->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('rfid', 'like', "%$search%");
            })
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('auther', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('publisher', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
        }

        // Apply the status filter if provided
        if (!empty($status)) {
            $books->where('status', $status);
        }

        // Paginate the results (10 items per page)
        $books = $books->paginate(10);

        // Return the view with the search results
        return view('book.index', compact('books'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create', [
            'authors' => auther::latest()->get(),
            'publishers' => publisher::latest()->get(),
            'categories' => category::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorebookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorebookRequest $request)
    {
        book::create($request->validated() + [
            'status' => 'Y'
        ]);
        return redirect()->route('books');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(book $book)
    {
        return view('book.edit', [
            'authors' => auther::latest()->get(),
            'publishers' => publisher::latest()->get(),
            'categories' => category::latest()->get(),
            'book' => $book
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatebookRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatebookRequest $request, $id)
    {
        // Validate the request
        $validated = $request->validated();

        // Find the book by ID
        $book = book::findOrFail($id);

        // Update the book using validated data
        $book->update([
            'name' => $validated['name'],
            'rfid' => $validated['rfid'],
            'auther_id' => $validated['author_id'],
            'category_id' => $validated['category_id'],
            'publisher_id' => $validated['publisher_id'],
        ]);

        // Redirect to the books route
        return redirect()->route('books');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        book::find($id)->delete();
        return redirect()->route('books');
    }
}
