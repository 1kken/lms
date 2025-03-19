<?php

namespace App\Http\Controllers;

use App\Http\Requests\changePasswordRequest;
use App\Models\auther;
use App\Models\book;
use App\Models\BookIssue;
use App\Models\category;
use App\Models\publisher;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class dashboardController extends Controller
{
    public function index()
    {
        // Get the count values for the dashboard cards
        $authors      = auther::count();
        $publishers   = publisher::count();
        $categories   = category::count();
        $books        = book::count();
        $students     = student::count();
        $issued_books = BookIssue::count();

        // Define the start and end date for the past 5 days (including today)
        $startDate = Carbon::today()->subDays(4);
        $endDate = Carbon::today();

        // Get the book issues counts grouped by date
        $bookIssues = BookIssue::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Initialize arrays for labels and data, ensuring all 5 days are present
        $labels = [];
        $dataArr = [];
        for ($date = clone $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $labels[] = $formattedDate;
            $dataArr[$formattedDate] = 0;
        }

        // Update the data array with the counts from the query
        foreach ($bookIssues as $issue) {
            $dataArr[$issue->date] = $issue->count;
        }

        // Prepare chart data arrays
        $chartLabels = $labels; // Already ordered from oldest to newest
        $chartData = array_values($dataArr);

        // Return the view with all the necessary data
        return view('dashboard', [
            'authors'      => $authors,
            'publishers'   => $publishers,
            'categories'   => $categories,
            'books'        => $books,
            'students'     => $students,
            'issued_books' => $issued_books,
            'chartLabels'  => $chartLabels,
            'chartData'    => $chartData,
        ]);
    }


    public function change_password_view()
    {
        return view('reset_password');
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'c_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if (password_verify($request->c_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route("dashboard")->with('success', 'Password changed successfully');
        } else {
            return redirect()->back()->withErrors(['c_password' => 'Old password is incorrect']);
        }
    }
}
