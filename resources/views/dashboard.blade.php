@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="admin-heading">Dashboard</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @php
            $cards = [
            ['icon' => 'fa-user', 'count' => $authors, 'label' => 'Authors Listed'],
            ['icon' => 'fa-building', 'count' => $publishers, 'label' => 'Publishers Listed'],
            ['icon' => 'fa-tags', 'count' => $categories, 'label' => 'Categories Listed'],
            ['icon' => 'fa-book', 'count' => $books, 'label' => 'Books Listed'],
            ['icon' => 'fa-users', 'count' => $students, 'label' => 'Registered Students'],
            ['icon' => 'fa-book-open', 'count' => $issued_books, 'label' => 'Books Issued'],
            ];
            @endphp

            @foreach ($cards as $card)
            <div class="col-md-2 col-sm-4 col-6 mb-3">
                <div class="card text-center py-2 border-0 shadow-none" style="color: white; min-width: 10rem; max-width: 12rem; height: 7rem; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa {{ $card['icon'] }} fa-sm mr-2"></i>
                            <h6 class="mb-0">{{ $card['label'] }}</h6>
                        </div>
                        <p class="card-text font-weight-bold mt-2">{{ $card['count'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Full-width Image Below the Row -->
        <div class="row">
            <div class="col-12">
                <img src="{{ asset('images/defemnhs.jpg') }}" alt="Dashboard Image" class="img-fluid w-100 mt-3">
            </div>
        </div>
    </div>
</div>
@endsection